<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Exceptions\SpamForgotPasswordException;
use App\Interfaces\AuthServiceInterface;
use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\DeviceTokenServiceInterface;
use App\Mail\VerifycationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Interfaces\UserRepositoryInterface;
use App\Models\PasswordResetToken;
use App\Models\User;
use App\Mail\ForgotPasswordEmail;
use Illuminate\Support\Arr;
use App\Mail\ResetPasswordEmail;
use Illuminate\Http\Request;

class AuthService implements AuthServiceInterface
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data)
    {
        $token = Str::random(64);
        $data['verification_token'] = $token;
        $expiresAt = Carbon::now()->addMinutes(User::REGISTER_VERIFY_EXPIRED);
        $data['expires_at'] = $expiresAt;
        $data['commission_rate'] = 10;
        $data['referral_code'] = strtoupper(Str::random(8));

        $user = $this->authRepository->createUser($data);
        Mail::to($user->email)->send(new VerifycationEmail($user->email, $token, $expiresAt));

        return $user;
    }

    public function verifyUser($email, $token): User|CustomException
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = app(UserRepositoryInterface::class);
        $user = $userRepository->findByEmailAndToken($email, $token);
        if (Carbon::parse($user->expires_at)->isPast()) {
            throw new CustomException('Hết hạn.');
        }
        $user->update([
            'status' => User::STATUS_ACTIVE,
            'expires_at' => null,
            'verification_token' => null,

        ]);

        return $user;
    }

    public function login(array $data)
    {
        $user = $this->authRepository->getUserByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }
        // $user->tokens()->delete();
        $token = $user->createToken('auth_token');
        // Lấy thời gian hết hạn từ cấu hình Sanctum
        $expirationMinutes = (int) config('sanctum.expiration', 60);
        $expiresAt = Carbon::now()->addMinutes($expirationMinutes);

        return [
            'access_token' => $token->plainTextToken,
            'expires_at' => $expiresAt->toDateTimeString(),
            'user' => $user,
        ];
    }

    public function logout()
    {
        /** @var DeviceTokenServiceInterface $deviceTokenService */
        $deviceTokenService = app(DeviceTokenServiceInterface::class);
        $deviceTokenService->delete(Auth::user()->id);

        Auth::user()->currentAccessToken()->delete();
    }

    public function forgotPassword(User $user)
    {
        $token = Str::random(64);
        $email = $user->email;
        $passwordReset = $this->updatePasswordReset($email, $token);
        $expired = Carbon::parse($passwordReset->updated_at)->addMinutes(User::TOKEN_FORGOT_PASSWORD_EXPIRED);

        Mail::to($user->email)->send(new ForgotPasswordEmail($email, $token, $expired));
    }

    protected function updatePasswordReset(string $email, string $token): PasswordResetToken
    {
        $passwordReset = PasswordResetToken::where('email', $email)->first();
        if (!$passwordReset) {
            $passwordReset = PasswordResetToken::create([
                'email' => $email,
                'token' => $token,
            ]);

            return $passwordReset;
        }
        $isSpam = $this->isSpamForgotPassword($passwordReset);
        if ($isSpam) {
            $diffMinutes = abs((int) Carbon::now()->diffInMinutes($passwordReset->updated_at));
            $timeRemaining = 10 - $diffMinutes;
            if ($timeRemaining <= 1) {
                $timeRemaining = 1;
            }
            throw new SpamForgotPasswordException($timeRemaining);
        }
        $passwordReset->update([
            'token' => $token
        ]);

        return $passwordReset;
    }

    protected function isSpamForgotPassword(PasswordResetToken $passwordReset): bool
    {
        return !Carbon::parse($passwordReset->updated_at)->addMinutes(10)->isPast();
    }

    public function resetPassword(User $user, string $token)
    {
        $passwordReset = PasswordResetToken::where(['email' => $user->email, 'token' => $token])->first();
        $expired = Carbon::parse($passwordReset->updated_at)->addMinutes(User::TOKEN_FORGOT_PASSWORD_EXPIRED);
        if ($expired < Carbon::now()) {
            throw new CustomException('Không còn hiệu lực, vui lòng tạo lại yêu cầu mới.');
        }
        $newPassword = $this->makeRandPassword();
        $user->update([
            'password' => Hash::make($newPassword)
        ]);
        $user->tokens()->delete();

        Mail::to($user->email)->send(new ResetPasswordEmail($user->email, $newPassword));
    }

    protected function makeRandPassword(int $length = 8): string
    {
        $randomString = Str::random($length - 4);
        $lowercase = Arr::random(range('a', 'z'));
        $digits = Arr::random(range('0', '9'));
        $uppercase = Arr::random(range('A', 'Z'));
        $special = Arr::random(['#', '?', '!', '@', '$', '%', '^', '&', '*', '-']);

        return $randomString . $lowercase . $digits . $uppercase . $special;
    }


    public function updateProfile(Request $request): void
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = app(UserRepositoryInterface::class);
        $user = $userRepository->update($request->only(['name', 'gender', 'dob', 'phone', 'introduce']), $request->user()->getKey());
        if ($request->file('media_avatar')) {
            $user->clearMediaCollection(User::MEDIA_AVATAR);
            $media = $user->addMediaFromRequest('media_avatar')->toMediaCollection(User::MEDIA_AVATAR);
        }
    }
}
