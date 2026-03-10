<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KpiSubmissionItem;

class AppraiserKpiController extends Controller
{
    public function index()
    {
        abort_if(session('role') !== 'appraiser', 403);

        $submissions = \App\Models\KpiSubmission::where('status', 'submitted')
            ->with('user')
            ->get();

        return view('appraiser.kpi.index', compact('submissions'));
    }

    public function show($id)
    {
        abort_if(session('role') !== 'appraiser', 403);

        $submission = \App\Models\KpiSubmission::with('user')
            ->findOrFail($id);

        $items = \App\Models\KpiSubmissionItem::with('kpi')
            ->where('submission_id', $id)
            ->get();

        return view('appraiser.kpi.review', compact('submission', 'items'));
    }

    public function submitReview(Request $request, $id)
    {
        abort_if(session('role') !== 'appraiser', 403);

        $submission = \App\Models\KpiSubmission::findOrFail($id);        

        foreach ($request->appraiser_score as $itemId => $score) {

            $item = \App\Models\KpiSubmissionItem::with('kpi')->findOrFail($itemId);

            $weight = $item->kpi->weightage;

            $appraiser_total = $item->kpi->weightage * $score;

            $item->update([
                'appraiser_score' => $score,
                'staff_total'     => $weight * $item->self_score,
                'appraiser_total' => $appraiser_total,
                'total_score'     => $appraiser_total,
                'comment'         => $request->comment[$itemId] ?? null,
                'status'          => 'reviewed'
            ]);
        }

        $submission->update(['status' => 'reviewed']);

            // ⭐ Save appraiser name
        $submission->update([
            'status' => 'reviewed',
            'appraiser_name' => session('name')
        ]);


        return redirect()->route('appraiser.kpi')
            ->with('success', 'KPI reviewed successfully.');
    }


    public function updateScore(Request $request, $id)
    
    {
        abort_if(session('role') !== 'appraiser', 403);

        $item = \App\Models\KpiSubmissionItem::with('kpi')->findOrFail($id);

        $weightage = $item->kpi->weightage;

        $item->appraiser_score = $request->appraiser_score;

        $item->staff_total = $weightage * $item->self_score;
        $item->appraiser_total = $weightage * $request->appraiser_score;
        $item->total_score = $item->appraiser_total;

        $item->save();

        return back()->with('success', 'Score Updated');
    }
}