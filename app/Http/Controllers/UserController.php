<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(int $id)
    {
        return "This is controller based routing with ID: " . $id;
    }

    public function show(User $user)
    {
        return $user->email;
    }

    public function create() {
        return 'Protected by middleware';
    }
}
