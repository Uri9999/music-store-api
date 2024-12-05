<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Interfaces\UserSubscriptionServiceInterface;

class UserSubscriptionController extends Controller
{
    protected UserSubscriptionServiceInterface $service;

    public function __construct(UserSubscriptionServiceInterface $service)
    {
        $this->service = $service;
    }

    public function register(Request $request)
    {
         
    }
}
