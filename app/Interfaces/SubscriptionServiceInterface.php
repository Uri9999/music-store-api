<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface SubscriptionServiceInterface
{
    public function index(): Collection;
}
