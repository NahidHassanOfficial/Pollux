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
            $polls = Poll::visible()->unexpired()->orderByDesc('total_vote')->paginate(10);
        } else if ($filterParam == 'endingSoon') {
            $polls = Poll::visible()->unexpired()->orderBy('expire_at')->paginate(10);
        } else {
            $polls = Poll::visible()->unexpired()->orderByDesc('created_at')->paginate(10);
        }

        return Response::success(null, $polls);
    }

    public function searchPoll($search)
    {
        $polls = Poll::visible()->where('title', 'like', '%' . $search . '%')
            ->orderByDesc('created_at')->limit(5)->get();

        return $polls;
    }

}
