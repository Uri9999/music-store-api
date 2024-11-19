<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'payment_method' => 'required|string', // Ví dụ: "credit_card", "paypal", v.v.
        ]);

        $user = $request->user(); // Lấy thông tin người dùng hiện tại

        // Lấy thông tin gói subscription
        $subscription = Subscription::find($request->subscription_id);

        if (!$subscription) {
            return response()->json(['message' => 'Subscription không tồn tại.'], 404);
        }

        // Tạo bản ghi thanh toán (ở trạng thái pending)
        $payment = Payment::create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'amount' => $subscription->price,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
        ]);

        // Giả lập xử lý thanh toán (bạn có thể tích hợp cổng thanh toán thực tế như Stripe, PayPal...)
        // Ở đây, chúng ta giả định thanh toán luôn thành công
        $payment->update([
            'payment_status' => 'completed',
            'payment_date' => now(),
        ]);

        // Nếu thanh toán thất bại, trả về lỗi
        if ($payment->payment_status !== 'completed') {
            return response()->json(['message' => 'Thanh toán thất bại.'], 400);
        }

        // Tính toán ngày bắt đầu và kết thúc subscription
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addDays($subscription->duration_in_days);

        // Tạo hoặc cập nhật subscription của người dùng
        $userSubscription = UserSubscription::create([
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
        ]);

        return response()->json([
            'message' => 'Đăng ký subscription thành công.',
            'subscription' => [
                'id' => $userSubscription->id,
                'subscription_name' => $subscription->name,
                'start_date' => $userSubscription->start_date->toDateString(),
                'end_date' => $userSubscription->end_date->toDateString(),
                'status' => $userSubscription->status,
            ],
            'payment' => [
                'id' => $payment->id,
                'amount' => $payment->amount,
                'method' => $payment->payment_method,
                'status' => $payment->payment_status,
                'date' => $payment->payment_date,
            ],
        ]);
    }

    public function generateQRCode(Request $request)
    {
        // Lấy thông tin từ request
        $amount = $request->amount;
        $orderId = time(); // Unique order ID
        $orderInfo = "Thanh toán dịch vụ"; // Mô tả đơn hàng
        $requestId = time(); // Unique request ID

        // Thông tin MoMo từ file env
        $endpoint = "https://test-payment.momo.vn/v2/generate";
        $partnerCode = env('MOMO_PARTNER_CODE');
        $accessKey = env('MOMO_ACCESS_KEY');
        $secretKey = env('MOMO_SECRET_KEY');
        $callbackUrl = route('handleCallback'); // Notify URL

        // Tạo signature
        $rawHash = "accessKey=$accessKey&amount=$amount&extraData=&orderId=$orderId&orderInfo=$orderInfo&partnerCode=$partnerCode&redirectUrl=$callbackUrl&requestId=$requestId";
        $signature = hash_hmac('sha256', $rawHash, $secretKey);

        // Dữ liệu gửi đến API MoMo
        $data = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $callbackUrl,
            'notifyUrl' => $callbackUrl,
            'extraData' => '',
            'signature' => $signature
        ];

        // Gửi yêu cầu đến MoMo
        $response = Http::post($endpoint, $data);

        // Kiểm tra kết quả từ MoMo
        if ($response->successful()) {
            $responseData = $response->json();
            $qrCodeUrl = $responseData['qrCodeUrl'] ?? null;

            // Lưu thông tin thanh toán vào database
            Payment::create([
                'user_subscription_id' => $request->user_subscription_id,
                'amount' => $amount,
                'payment_method' => 'momo_qr',
                'payment_status' => 0, // Pending
                'payment_date' => now(),
            ]);

            return response()->json([
                'success' => true,
                'qrCodeUrl' => $qrCodeUrl,
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Failed to generate QR Code']);
    }

    public function handleCallback(Request $request)
    {
        // Nhận dữ liệu callback từ MoMo
        $data = $request->all();

        // Xác thực signature
        $accessKey = env('MOMO_ACCESS_KEY');
        $secretKey = env('MOMO_SECRET_KEY');
        $rawHash = "accessKey=$accessKey&amount={$data['amount']}&extraData={$data['extraData']}&message={$data['message']}&orderId={$data['orderId']}&orderInfo={$data['orderInfo']}&orderType={$data['orderType']}&partnerCode={$data['partnerCode']}&payType={$data['payType']}&requestId={$data['requestId']}&responseTime={$data['responseTime']}&resultCode={$data['resultCode']}&transId={$data['transId']}";
        $signature = hash_hmac('sha256', $rawHash, $secretKey);

        if ($signature !== $data['signature']) {
            return response()->json(['success' => false, 'message' => 'Invalid signature']);
        }

        // Cập nhật trạng thái thanh toán
        $payment = Payment::where('orderId', $data['orderId'])->first();
        if ($payment) {
            $payment->update([
                'payment_status' => $data['resultCode'] == 0 ? 1 : 2, // 1: Thành công, 2: Thất bại
            ]);
        }

        return response()->json(['success' => true]);
    }
}
