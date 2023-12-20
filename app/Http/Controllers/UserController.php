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

    public function index()
    {
        $users = User::all();

        return view('admin.view_user', compact('users'));
    }

    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function update(Request $request)
{
    $validatedData = $request->validate([
        'user_id' => 'required',
        'name' => 'required',
        'role' => 'required',
        'email' => 'email',
        'number' => 'nullable|numeric',
        'branch' => 'nullable',
    ]);

    $user = User::find($validatedData['user_id']);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    $user->role = $validatedData['role'];
    $user->branch = $validatedData['branch'];
    $user->number = $validatedData['number'];

    $user->save();

    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}

}
