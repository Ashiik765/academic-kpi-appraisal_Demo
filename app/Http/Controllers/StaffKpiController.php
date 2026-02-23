<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kpi;
use App\Models\KpiSubmission;
use App\Models\KpiSubmissionItem;


class StaffKpiController extends Controller

{
    public function category($category)

    {
        abort_if(session('role') !== 'staff', 403);

        $userId = session('user_id');
        $year = now()->year;

        $submission = KpiSubmission::firstOrCreate(
            [
                'user_id' => $userId,
                'year' => $year
            ],
            [
                'status' => 'draft'
            ]
        );

        // Only load KPIs of selected category
        $kpis = Kpi::whereRaw('LOWER(category) = ?', [strtolower($category)])->get();

        // Load submission items
        $submissionItems = KpiSubmissionItem::where('submission_id', $submission->id)
                            ->get()
                            ->keyBy('kpi_id');

        return view('staff.kpi.staff_kpi', compact(
            'kpis',
            'submission',
            'submissionItems',
            'category'
        ));
    }

    public function save(Request $request)
    {
        abort_if(session('role') !== 'staff', 403);

        // validate incoming data
        $request->validate([
            'submission_id' => 'required|exists:kpi_submissions,id',
            'category'      => 'required|string',
            'self_score'    => 'nullable|array',
            'self_score.*'  => 'nullable|integer|min:0',
            'action'        => 'nullable|string|in:save,submit'
        ]);

        $submission = KpiSubmission::findOrFail($request->submission_id);

        // iterate through submitted scores (if any were provided)
        foreach ($request->input('self_score', []) as $kpi_id => $score) {
            $filePath = null;

            if ($request->hasFile("evidence.$kpi_id")) {
                $filePath = $request->file("evidence.$kpi_id")
                                    ->store('evidence', 'public');
            }

            KpiSubmissionItem::updateOrCreate(
                [
                    'submission_id' => $submission->id,
                    'kpi_id'        => $kpi_id
                ],
                [
                    'category'   => $request->category,
                    'self_score' => $score,
                    'evidence'   => $filePath,
                    'status'     => $request->action === 'submit' ? 'submitted' : 'draft'
                ]
            );
        }

        // if the user chose to submit the entire dimension, update submission status
        if ($request->action === 'submit') {
            $submission->update(['status' => 'submitted']);
            return back()->with('success', 'Dimension submitted successfully.');
        }

        return back()->with('success', 'Draft saved successfully.');
    }


    public function submit($id)
    
    {
        $submission = KpiSubmission::findOrFail($id);

        $submission->update([
            'status' => 'submitted'
        ]);

        return back()->with('success', 'KPI submitted successfully.');
    }

}
