<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityLog\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function __construct(
        protected ActivityLogService $activityLogService
    ) {}

    /**
     * Display a listing of the system activity logs.
     */
    public function index(): View
    {
        $logs = $this->activityLogService->paginateLogs(15);
        $stats = $this->activityLogService->getStats();

        return view('backend.activity-logs.index', compact('logs', 'stats'));
    }

    /**
     * Delete all activity log records.
     */
    public function destroyAll(): RedirectResponse
    {
        $deletedCount = $this->activityLogService->clearAllLogs();

        return redirect()->route('admin.activity-logs.index')
            ->with('success', "Successfully cleared all activity logs ({$deletedCount} records deleted).");
    }
}
