<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiTeaching extends Model
{
    protected $fillable = [
        'kpi_submission_id',
        'teval_rating',
        'teval_evidence',
        'innovative_rating',
        'innovative_evidence'
    ];

    public function submission()
    {
        return $this->belongsTo(KpiSubmission::class);
    }
}
