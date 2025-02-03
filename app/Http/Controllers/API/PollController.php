<?php
namespace App\Http\Controllers\API;

use App\Helper\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\PollRequest;
use App\Models\Poll;
use App\Models\PollOption;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class PollController extends Controller
{

    public function createPoll(PollRequest $request)
    {
        $request->validated();

        DB::beginTransaction();
        try {
            $poll = Poll::create([
                'user_id'           => Auth::user()->id,
                'title'             => $request->title,
                'description'       => $request->description,
                'allow_multiple'    => $request->allow_multiple,
                'public_visibility' => $request->public_visibility,
                'expire_at'         => $request->expire_at,
            ]);

            foreach ($request->options as $option) {
                PollOption::create([
                    'poll_id' => $poll->id,
                    'option'  => $option,
                ]);
            }

            if (! $request->public_visibility) {
                $signature = URL::temporarySignedRoute('pollView', Carbon::parse($request->expire_at), ['poll_uid' => $poll->poll_uid]);
                $poll->forceFill(['signature' => $signature])->save();
            }

            Auth::user()->increment('total_poll');

            DB::commit();
            return Response::success();
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::error();
        }
    }

    public function viewPoll($poll_uid)
    {
        if (request()->hasValidSignature()) {
            $poll = Poll::where('poll_uid', $poll_uid)->with('pollOptions')->with('user:id,username,profile_img')->first();
        } else {
            $poll = Poll::visible()->where('poll_uid', $poll_uid)->with('pollOptions')->with('user:id,username,profile_img')->first();
        }
        if ($poll) {
            return Response::success(null, $poll);
        } else {
            return Response::failed('Poll not found');
        }

    }

    public function deletePoll()
    {
        $poll = Poll::where('user_id', Auth::user()->id)
            ->where('poll_uid', request()->poll_uid)->first();

        if ($poll) {
            $poll->delete();
            Auth::user()->decrement('total_poll');

            return Response::success();
        }

        return Response::failed();
    }

}
