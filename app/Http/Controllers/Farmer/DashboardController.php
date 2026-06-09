<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Farmer Dashboard Controller
 * 
 * Redirects to the main DashboardController which handles farmer/petani logic.
 */
class DashboardController extends Controller
{
    /**
     * Redirect to the main dashboard handler.
     */
    public function index()
    {
        return redirect()->route('dashboard');
    }
}
