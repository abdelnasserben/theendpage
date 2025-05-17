<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load(['pages', 'comments.page', 'votes.page']);
        return view('dashboard', compact('user'));
    }
}
