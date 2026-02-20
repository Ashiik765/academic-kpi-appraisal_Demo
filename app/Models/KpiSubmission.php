<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiSubmission extends Model
{
    protected $fillable = [
        'user_id',
        'year',
        'status',
        'total_score',
        'comment'
    ];

    public function items()
    {
        return $this->hasMany(KpiSubmissionItem::class, 'submission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}