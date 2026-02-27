<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KpiSubmissionItem;

class AppraiserKpiController extends Controller
{
    public function index()
    {
        return redirect()->route('appraiser.kpi');
        
    }

    public function showAll()

    {
        abort_if(session('role') !== 'appraiser', 403);

        $items = \App\Models\KpiSubmissionItem::with('kpi')->get();

        return view('appraiser.kpi.review', compact('items'));
    }

    public function updateScore(Request $request, $id)
    {
        abort_if(session('role') !== 'appraiser', 403);

        $item = \App\Models\KpiSubmissionItem::with('kpi')->findOrFail($id);

        $weightage = $item->kpi->weightage;

        $item->appraiser_score = $request->appraiser_score;

        $item->staff_score = $weightage * $item->self_score;
        $item->appraiser_final_score = $weightage * $request->appraiser_score;
        $item->final_score = $item->appraiser_final_score;

        $item->save();

        return back()->with('success', 'Score Updated');
    }
}