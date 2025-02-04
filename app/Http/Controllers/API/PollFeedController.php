<?php
namespace App\Http\Controllers\API;

use App\Helper\Response;
use App\Http\Controllers\Controller;
use App\Models\Poll;

class PollFeedController extends Controller
{
    public function getPolls($filterParam = "recent")
    {
        if ($filterParam == 'mostVoted') {
            $polls = Poll::visible()->unexpired()->orderByDesc('total_vote')->with('pollOptions')->paginate(10);
        } else if ($filterParam == 'endingSoon') {
            $polls = Poll::visible()->unexpired()->orderBy('expire_at')->with('pollOptions')->paginate(10);
        } else {
            $polls = Poll::visible()->unexpired()->orderByDesc('created_at')->with('pollOptions')->paginate(10);
        }

        return Response::success(null, $polls);
    }

    public function searchPoll()
    {
        $search = request()->input('query');
        $polls  = Poll::visible()->unexpired()->where('title', 'like', '%' . $search . '%')
            ->with('pollOptions')->orderByDesc('created_at')->limit(10)->get();

        return Response::success(null, $polls);
    }

}
