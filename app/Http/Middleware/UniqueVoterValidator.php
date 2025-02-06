<?php
namespace App\Http\Middleware;

use App\Models\Poll;
use App\Models\PollVisitorLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UniqueVoterValidator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $poll_uid    = $request->poll_uid;
        $fingerprint = $request->fingerprint;
        $ip          = $request->ip();
        $userAgent   = $request->header('User-Agent');

        $poll = Poll::where('poll_uid', $poll_uid)->select('id')->first();

        $logs = PollVisitorLog::where('poll_id', $poll->id)
            ->where('ip', $ip)
            ->where('user_agent', $userAgent)
            ->where('is_voted', 1)
            ->first();

        $logs = PollVisitorLog::where('poll_id', $poll->id)
            ->where('is_voted', 1)
            ->where(function ($query) use ($ip, $userAgent, $fingerprint) {
                $query->where(function ($q) use ($ip, $userAgent) {
                    $q->where('ip', $ip)
                        ->where('user_agent', $userAgent);
                })
                    ->orWhere(function ($q) use ($fingerprint) {
                        $q->where('fingerprint', $fingerprint);
                    });
            })
            ->first();

        if ($logs) {
            return response()->json(['error' => 'You have already voted for this poll.'], 500);
        }

        return $next($request);
    }
}
