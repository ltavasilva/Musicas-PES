<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function changePass()
    {
        return view('auth.passwords.changePass');
    }

    public function doChangePass(Request $request)
    {
        $user = User::findOrFail($request->id);
        $request->validate([
            'password' => 'required|confirmed|string',
            'current_password' => ['required', function ($attr, $password, $validation) use ($user) {
                if (!Hash::check($password, $user->password)) {
                    return $validation(__('The current password is incorrect.'));
                }
            }],
        ]);

        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('home');
    }
}
