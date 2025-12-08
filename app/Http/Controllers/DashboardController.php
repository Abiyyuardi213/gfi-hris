<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPeran = Role::count();

        return view('dashboard', compact(
            'totalPeran',
        ));
    }
}
