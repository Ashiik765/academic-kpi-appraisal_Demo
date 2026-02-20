<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountChangeRequest;

if (! class_exists(\App\Http\Controllers\ProfileController::class)) {
    class ProfileController extends Controller
    {
        public function requestChange(Request $request)
        {
            AccountChangeRequest::create([
                'user_id' => session('user_id'),
                'type' => 'account_change'
            ]);

            return back()->with('success', 'Request sent to admin for approval.');
        }
    }
}
