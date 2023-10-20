<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagementController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $admins = User::where('roles', 1)->orderByRaw("id = $id DESC, lastname ASC")->get();
        $employees = User::whereIn('roles', [2,4,5,6])->orderByRaw("id = $id DESC, lastname ASC")->get();


        return view('management.index', ['admins' => $admins, 'employees' => $employees]);
    }

    public function customerIndex()
    {
        $customers = User::where('roles', 3)->orderBy('lastname', 'asc')->get();

        return view('management.customers', ['customers' => $customers]);
    }

    public function store(Request $request)
    {
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'roles' => $request->role,
            'email_verified_at' => Carbon::now(),
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

    public function getUser(Request $request)
    {
        $id = $request->id;

        $data = User::find($id);

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $id = $request->id;

        $user = User::find($id);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->roles = $request->role;

        if($request->password !== "")
        {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'User account has been updated.');

    }

    public function deleteUser(Request $request)
    {
        $id = $request->id;

        $user = User::find($id);
        $user->delete();

        return 1;
    }
}
