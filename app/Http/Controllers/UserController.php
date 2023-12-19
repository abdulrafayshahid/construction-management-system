<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'name' => 'required',
            'role' => 'required',
            'email' => 'email',
            'number' => 'nullable|numeric',
            'branch' => 'nullable',
            'password' => 'required',
        ]);

        $user = new User();
        $user->user_id = $validatedData['user_id'];
        $user->name = $validatedData['name'];
        $user->role = $validatedData['role'];
        $user->email = $validatedData['email'];
        $user->number = $validatedData['number'];
        $user->branch = $validatedData['branch'];
        $user->password = bcrypt($validatedData['password']);

        $user->save();

        return redirect()->route('createuser')->with('success', 'User created successfully');
    }
}
