<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Poll;
use App\Models\PollVisitorLog;
use Illuminate\Http\Request;

class FingerprintStoreController extends Controller
{
    public function store()
    {
        $poll_uid    = request()->poll_uid;
        $ip          = request()->ip();
        $userAgent   = request()->header('User-Agent');
        $fingerprint = request()->fingerprint;

        $poll = Poll::where('poll_uid', $poll_uid)->select('id')->first();

        $logs = PollVisitorLog::where('poll_id', $poll->id)
            ->where('ip', $ip)
            ->where('user_agent', $userAgent)
            ->first();

        if ($logs) {
            $logs->fingerprint = $fingerprint;
            if ($logs->isDirty()) {
                $logs->save();
            }
        } else {
            PollVisitorLog::create([
                'poll_id'     => $poll->id,
                'fingerprint' => $fingerprint,
                'ip'          => $ip,
                'user_agent'  => $userAgent,
            ]);
        }

    }
}
