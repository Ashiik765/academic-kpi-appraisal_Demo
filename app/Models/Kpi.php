<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    protected $fillable = [
        'category',
        'item',
        'description',
        'weight',
        'max_marks',
        'created_by'
    ];

    // relation: many submissions
    public function items()
    {
        
        return $this->hasMany(KpiSubmissionItem::class);

    }

}

