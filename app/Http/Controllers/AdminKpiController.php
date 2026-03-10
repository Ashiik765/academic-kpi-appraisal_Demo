<?php

namespace App\Http\Controllers;

use App\Models\Kpi;
use Illuminate\Http\Request;


class AdminKpiController extends Controller
{
    public function category($staff_type, $category)

    {
        $kpis = Kpi::where('category', $category)
                    ->where('staff_type', $staff_type)
                    ->get();

        return view('admin.kpi.category', compact('kpis','category','staff_type'));
    }



    public function delete($id)
    {
        Kpi::find($id)->delete();
        return back();
    }

    public function storeAll(Request $request)
    
    {
        $category = $request->category;

        $criteria = $request->criteria;
        $weights = $request->weightage;

        if ($criteria) {
            foreach ($criteria as $index => $crit) {
                Kpi::create([
                    'category' => $category,
                    'criteria' => $crit,
                    'weightage' => $weights[$index],
                    'staff_type' => $request->staff_type
                ]);
            }
        }

        return back()->with('success', 'KPI Saved Successfully');
    }

}