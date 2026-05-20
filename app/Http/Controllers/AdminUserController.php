<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)->latest()->get();
        return view('admin.users.index', compact('users'));
    }
}
