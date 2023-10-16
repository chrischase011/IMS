<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    public function index()
    {
        $admins = User::where('roles', 1)->orderBy('lastname', 'asc')->get();
        $employees = User::where('roles', 2)->orderBy('lastname', 'asc')->get();
        $customers = User::where('roles', 3)->orderBy('lastname', 'asc')->get();

        return view('management.index', ['admins' => $admins, 'employees' => $employees, 'customers' => $customers]);
    }
}
