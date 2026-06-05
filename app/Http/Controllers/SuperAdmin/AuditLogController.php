<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer');

        if ($request->filled('log_name')) {
            $query->where('log_name', $request->log_name);
        }

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }
        
        if ($request->filled('causer_id')) {
            $query->where('causer_id', $request->causer_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $perPage = $request->input('per_page', 20);
        $logs = $query->latest()->paginate($perPage)->withQueryString();

        $logNames = Activity::select('log_name')->distinct()->pluck('log_name');
        $events = Activity::select('event')->whereNotNull('event')->where('event', '!=', '')->distinct()->pluck('event');
        $users = \App\Models\User::all();

        return view('super-admin.audit-logs.index', compact('logs', 'logNames', 'events', 'users'));
    }
    public function show($id)
    {
        $log = Activity::with('causer')->findOrFail($id);
        return view('super-admin.audit-logs.show', compact('log'));
    }
}
