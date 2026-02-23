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

        $items = $request->item;
        $descriptions = $request->description;
        $marks = $request->max_marks;

        if ($items) {
            foreach ($items as $index => $item) {

                Kpi::create([
                    'category' => $category,
                    'item' => $item,
                    'description' => $descriptions[$index] ?? null,
                    'max_marks' => $marks[$index],
                ]);
            }
        }

        return back()->with('success', 'KPI Saved Successfully');
    }

}