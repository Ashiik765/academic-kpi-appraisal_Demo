<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiSubmissionItem extends Model
{
    protected $fillable = [
        'submission_id',
        'kpi_id',
        'rating',
        'score',
        'evidence',
        'status',
        'comment'
    ];

    public function submission()
    {
        return $this->belongsTo(KpiSubmission::class, 'submission_id');
    }

    public function kpi()
    {
        return $this->belongsTo(Kpi::class, 'kpi_id');
    }
}