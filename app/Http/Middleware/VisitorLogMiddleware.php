<?php
namespace App\Http\Middleware;

use App\Models\Poll;
use App\Models\PollVisitorLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitorLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $poll_uid  = $request->poll_uid;
        $ip        = $request->ip();
        $userAgent = $request->header('User-Agent');

        $poll = Poll::where('poll_uid', $poll_uid)->select('id')->first();
        $logs = PollVisitorLog::where('poll_id', $poll->id)
            ->where('ip', $ip)
            ->where('user_agent', $userAgent)
            ->orderByRaw('is_voted DESC')
            ->first();

        if ($logs) {
            $logs->increment('hits');
            if ($logs->is_voted) {
                view()->share('hasVoted', true);
                // return response()->json(['error' => 'You have already voted for this poll.'], 500);
            }
        } else {
            PollVisitorLog::create([
                'poll_id'    => $poll->id,
                'ip'         => $ip,
                'user_agent' => $userAgent,
            ]);
        }

        return $next($request);
    }
}
