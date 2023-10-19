<?php

namespace App\Http\Controllers;

use App\Models\LoginActivity;
use Illuminate\Http\Request;

class UserLogController extends Controller
{
    public function index()
    {
        $activities = LoginActivity::all();

        return view('management.logs', ['activities' => $activities]);
    }
}
