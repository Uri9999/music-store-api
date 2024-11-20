<?php

namespace App\Http\Controllers;

use App\Interfaces\OrderServiceInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $service;

    public function __construct(OrderServiceInterface $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        
    }

}
