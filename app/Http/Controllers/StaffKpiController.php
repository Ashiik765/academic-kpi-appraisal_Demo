<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpi;
use App\Models\KpiSubmission;
use App\Models\KpiSubmissionItem;
use Illuminate\Support\Facades\Auth;

class StaffKpiController extends Controller

{
    public function index()
    {
        abort_if(session('role') !== 'staff', 403);

        $userId = session('user_id');
        $year = now()->year;

        // Create submission if not exists
        $submission = KpiSubmission::firstOrCreate(
            [
                'user_id' => $userId,
                'year' => $year
            ],
            [
                'status' => 'draft'
            ]
        );

        // Load all master KPI items
        $kpis = Kpi::all();

        // Create categories (THIS WAS MISSING)
        $categories = $kpis->pluck('category')->unique();

        // Load existing submission items
        $submissionItems = KpiSubmissionItem::where('submission_id', $submission->id)
                            ->get()
                            ->keyBy('kpi_id');

        return view('staff.kpi.staff_kpi', compact(
            'kpis',
            'submission',
            'categories',
            'submissionItems'
        ));
    }

    public function turnIn(Request $request)
    {
        abort_if(session('role') !== 'staff', 403);

        $kpi = Kpi::findOrFail($request->kpi_id);

        $submission = KpiSubmission::firstOrCreate(
            [
                'user_id' => session('user_id'),
                'year' => now()->year
            ],
            [
                'status' => 'pending'
            ]
        );

        $filePath = null;

        if ($request->hasFile('evidence')) {
            $filePath = $request->file('evidence')
                                ->store('evidence', 'public');
        }

        $score = $request->rating * $kpi->weight;

        KpiSubmissionItem::updateOrCreate(
            [
                'submission_id' => $submission->id,
                'kpi_id' => $kpi->id
            ],
            [
                'category' => $kpi->category,
                'rating' => $request->rating,
                'score' => $score,
                'evidence' => $filePath,
                'status' => 'submitted'
            ]
        );

        return redirect()->route('staff.kpi')
                         ->with('success', 'KPI Turned In Successfully!');
    }


    
    public function turnOff(Request $request)
    {
        abort_if(session('role') !== 'staff', 403);

        KpiSubmissionItem::where('id', $request->item_id)
            ->update(['status' => 'draft']);

        return redirect()->route('staff.kpi')
                         ->with('success', 'KPI Turned Off');
    }


    public function save(Request $request)

    {
        abort_if(session('role') !== 'staff', 403);

        $submission = KpiSubmission::findOrFail($request->submission_id);

        foreach ($request->self_score as $kpi_id => $score) {

            KpiSubmissionItem::updateOrCreate(
                [
                    'submission_id' => $submission->id,
                    'kpi_id' => $kpi_id
                ],
                [
                    'self_score' => $score,
                    'comment' => $request->comment[$kpi_id] ?? null
                ]
            );
        }

        return back()->with('success', 'KPI saved successfully.');
    }


    public function submit($id)
    {
        abort_if(session('role') !== 'staff', 403);

        $submission = KpiSubmission::findOrFail($id);

        $submission->update([
            'status' => 'submitted'
        ]);

        return back()->with('success', 'KPI submitted successfully.');
    }

}
