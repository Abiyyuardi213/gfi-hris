<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = \App\Models\ActivityLog::with('user')
            ->latest()
            ->paginate(20);

        return view('activity_log.index', compact('logs'));
    }
}
