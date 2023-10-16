<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManagementController extends Controller
{
    public function index()
    {
        $admins = User::where('roles', 1)->orderBy('lastname', 'asc')->get();
        $employees = User::where('roles', 2)->orderBy('lastname', 'asc')->get();
        $customers = User::where('roles', 3)->orderBy('lastname', 'asc')->get();

        return view('management.index', ['admins' => $admins, 'employees' => $employees, 'customers' => $customers]);
    }

    public function store(Request $request)
    {
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'roles' => $request->role
        ]);

        if($user)
            return back()->with('success', 'New user has been added');

        return back()->with('error', 'Unexpected error occurred!');
    }

    public function verifyEmail($email, $token)
    {
        $user = User::where(function($query) use ($email, $token){
            $query->where('email', $email)
                ->where("token", $token);
        })->firstOrFail();

        $user->email_verified_at = Carbon::now();
        $user->token = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Email has been confirmed. You may now login.');

    }
}
