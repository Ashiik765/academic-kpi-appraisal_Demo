<?php

namespace App\Http\Controllers;

use App\Models\KpiSubmission;
use Illuminate\Http\Request;

class AppraiserKpiController extends Controller
{
    public function index()
    {
        abort_if(session('role') !== 'appraiser', 403);
        

        $submissions = KpiSubmission::with([
                'user',
                'items.kpi'
            ])
            ->where('status', 'submitted')
            ->get();

        $totalCount = $submissions->count();

        $approvedCount = KpiSubmission::where('status', 'approved')->count();

        $pendingCount = KpiSubmission::where('status', 'submitted')->count();

        $average = $submissions->avg('score') ?? 0;

        return view('appraiser.kpi.teaching_kpi', compact(
            'submissions',
            'totalCount',
            'pendingCount',
            'approvedCount',
            'average'
        ));
    }

    public function review(Request $request, $id)
    {
        abort_if(session('role') !== 'appraiser', 403);

        $submission = KpiSubmission::findOrFail($id);

        $submission->update([
            'score'   => $request->score,
            'comment' => $request->comment,
            'status'  => $request->status
        ]);

        return response()->json(['success' => true]);
    }
}