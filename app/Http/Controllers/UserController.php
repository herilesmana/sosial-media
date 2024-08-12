<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function manage()
    {
        $users = User::withCount('posts')
        ->withCount('comments')
        ->latest()->paginate(10);

        return Inertia::render('ManageUsers', [
            'users' => $users,
        ]);
    }
}
