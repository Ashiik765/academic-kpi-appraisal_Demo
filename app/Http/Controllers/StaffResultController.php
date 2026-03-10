<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KpiSubmission;
use App\Models\KpiSubmissionItem;

class StaffResultController extends Controller
{

    public function index()
    {
        // Only staff can access

        
        abort_if(session('role') !== 'staff', 403);

        $userId = session('user_id');

        // Get reviewed submission
        $submission = KpiSubmission::where('user_id',$userId)
                        ->where('status','reviewed')
                        ->latest()
                        ->first();

        if(!$submission){
            return view('staff.kpi.no_result');
        }

        // Get KPI items
        $items = KpiSubmissionItem::with('kpi')
                    ->where('submission_id',$submission->id)
                    ->get();

        return view('staff.kpi.result',compact('items','submission'));
    }


    public function print()
    {
        abort_if(session('role') !== 'staff', 403);

        $userId = session('user_id');

        $submission = KpiSubmission::where('user_id',$userId)
                        ->where('status','reviewed')
                        ->latest()
                        ->first();

        $items = KpiSubmissionItem::with('kpi')
                    ->where('submission_id',$submission->id)
                    ->get();

        return view('staff.kpi.print',compact('items','submission'));
    }

}