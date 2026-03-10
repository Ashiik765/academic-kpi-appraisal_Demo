<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiSubmissionItem extends Model
{
    protected $fillable = [
        'submission_id',
        'kpi_id',

        'self_score',

        'appraiser_score',
        'staff_total',
        'appraiser_total',
        'total_score',

        'rating',
        'score',
        'evidence',
        'status',
        'comment',
        'role'
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