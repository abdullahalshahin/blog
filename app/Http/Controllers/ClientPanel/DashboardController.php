<?php

namespace App\Http\Controllers\ClientPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        return view('client_panel.dashboard.index');
    }
}
