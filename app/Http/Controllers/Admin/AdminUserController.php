<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller {

    public function index() {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function create() {
        return view('admin.users.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:admin,officer,farmer',
            'district' => 'required|string',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'district' => $request->district,
            'phone'    => $request->phone,
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User created successfully.');
    }

    public function edit(User $user) {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:admin,officer,farmer',
            'district' => 'required|string',
        ]);

        $user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'district' => $request->district,
            'phone'    => $request->phone,
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user) {
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function show(User $user) {
        return view('admin.users.show', compact('user'));
    }
}