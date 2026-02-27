<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiSubmissionItem extends Model
{
    // include all fields that will be updated via mass assignment from controller
    protected $fillable = [
        'submission_id',
        'kpi_id',
        'self_score',    // staff-entered score
        'rating',
        'score',
        'evidence',
        'status',
        'comment',
        'role'           // added by later migration
        
    ];

    public function submission()
    {
        return $this->belongsTo(KpiSubmission::class, 'submission_id');
    }

    public function kpi()
    {
        return $this->belongsTo(\App\Models\Kpi::class, 'kpi_id');
    }

}