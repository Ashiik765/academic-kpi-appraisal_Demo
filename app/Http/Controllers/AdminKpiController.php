<?php

namespace App\Http\Controllers;

use App\Models\Kpi;
use Illuminate\Http\Request;

class AdminKpiController extends Controller
{
    public function category($category)
    {
        $kpis = Kpi::where('category', $category)->get();

        return view('admin.kpi.category', compact('kpis','category'));
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
                ]);
            }
        }

        return back()->with('success', 'KPI Saved Successfully');
    }

}