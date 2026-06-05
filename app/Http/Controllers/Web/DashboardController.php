<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __invoke(DashboardService $dashboard)
    {
        return view('dashboard.index', ['stats' => $dashboard->stats()]);
    }
}
