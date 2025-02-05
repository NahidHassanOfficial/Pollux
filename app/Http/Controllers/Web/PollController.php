<?php
namespace App\Http\Controllers\Web;

use App\Helper\Response;
use App\Http\Controllers\Controller;
use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function viewPrivatePoll($poll_uid)
    {
        $poll = null;

        if (request()->hasValidSignature()) {
            $poll = Poll::where('poll_uid', $poll_uid)->with('pollOptions')->with('user:id,username,profile_img')->first();
        }

        if ($poll == null) {
            if (request()->wantsJson()) {
                return Response::error('Poll not found');
            } else {
                abort(404);
            }
        }

        if (request()->wantsJson()) {
            return Response::success(null, $poll);
        }

        return view('components.client.feature.poll');
    }

}
