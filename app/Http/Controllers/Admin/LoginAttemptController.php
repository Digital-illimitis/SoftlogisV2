<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoginAttempt;

class LoginAttemptController extends Controller
{
    //
    
    public function index()
{
    $attempts = LoginAttempt::latest()->paginate(50);
    return view('admin.login_attempts.index', compact('attempts'));
}
}
