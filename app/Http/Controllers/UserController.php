<?php

namespace App\Http\Controllers;

use App\Interfaces\UserServiceInterface;
use App\Services\ApiResponseService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserServiceInterface $service;

    public function __construct(UserServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $paginator = $this->service->index($request);

        return ApiResponseService::paginate($paginator);
    }
}
