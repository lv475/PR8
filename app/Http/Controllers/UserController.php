<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', [
            'title' => 'Список пользователей',
            'users' => User::select('id', 'name', 'email')->orderBy('id', 'desc')->paginate(10),
            'flash' => session('success'),
        ]);
    }
    public function create()
    {
        return Inertia::render('Users/Create', [
            'title' => 'Новый пользователь',
            'roles' => ['student', 'business'],
    ]);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:50'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        return redirect()->route('users.index')->with('success', 'Пользователь успешно создан');
    }
}