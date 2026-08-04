<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of system activity logs.
     */
    public function index()
    {
        $logs = ActivityLog::latest()->paginate(15);

        return view('activity_logs.index', compact('logs'));
    }
}
