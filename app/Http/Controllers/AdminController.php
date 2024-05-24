<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register()
    {
        return view('auth.register');
    }

    public function login()
    {
        return view('auth.login');
    }
    public function dashboard()
    {
        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function doregister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' =>  'required',
            'password' =>  'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('login')->with('success', 'Registration successful!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function doLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => "required",
            'password' => "required"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $login = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        // dd($login);
        if (auth()->guard('admin')->attempt($login)) {
            return redirect()->route('dashboard');
        }
        return back()->with('error', "Invalid email or password!!");
    }


    /**
     * Display the specified resource.
     */
    public function logout()
    {

        auth()->guard()->logout();
        session()->regenerate();
        session()->flush();
        return redirect()->route('login')->with('success','Logged out successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
