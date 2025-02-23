<?php
namespace App\Http\Controllers\API;

use App\Helper\Response;
use App\Http\Controllers\Controller;
use App\Models\Poll;
use App\Models\PollReport;
use Illuminate\Validation\ValidationException;

class ReportController extends Controller
{
    public function reportPoll()
    {
        $poll_id     = Poll::where('poll_uid', request('poll_uid'))->whereStatus('active')->select('id')->first();
        $reporter_ip = request()->ip();

        if (! $poll_id) {
            return response()->json(['message' => 'Poll not found'], 404);
        }

        try {
            request()->validate([
                'reason'      => 'required|string',
                'description' => 'required|string',
            ]);
        } catch (ValidationException $e) {
            return Response::error($e->errors());
        }

        PollReport::create([
            'poll_id'     => $poll_id->id,
            'reporter_ip' => $reporter_ip,
            'reason'      => request('reason'),
            'description' => request('description'),
        ]);

        return Response::success('Poll reported successfully');
    }
}
