<?php
namespace App\Http\Controllers\API;

use App\Helper\Response;
use App\Http\Controllers\Controller;
use App\Models\Poll;
use Illuminate\Support\Facades\Cache;

class PollFeedController extends Controller
{
    public function getPolls($filterParam = "recent")
    {

        $timeFrom = 60 * 5; // 5 minutes
        $timeTo   = 60 * 7; // 7 minutes

        $page  = request()->get('page', 1); //default page is 1
        $polls = [];

        if ($filterParam == 'mostVoted') {
            $key   = 'feed_' . $filterParam . '_' . $page;
            $polls = Cache::flexible($key, [$timeFrom, $timeTo], function () {
                return Poll::visible()->unexpired()->orderByDesc('total_vote')->with('pollOptions')->paginate(10);
            });
        } else if ($filterParam == 'endingSoon') {
            $key   = 'feed_' . $filterParam . '_' . $page;
            $polls = Cache::flexible($key, [$timeFrom, $timeTo], function () {
                return Poll::visible()->unexpired()->orderBy('expire_at')->with('pollOptions')->paginate(10);
            });
        } else {
            $key   = 'feed_' . 'recent' . '_' . $page;
            $polls = Cache::flexible($key, [$timeFrom, $timeTo], function () {
                return Poll::visible()->unexpired()->orderByDesc('created_at')->with('pollOptions')->paginate(10);
            });
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
