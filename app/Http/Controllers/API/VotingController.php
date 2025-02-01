<?php
namespace App\Http\Controllers\API;

use App\Helper\Response;
use App\Http\Controllers\Controller;
use App\Models\Poll;
use App\Models\PollOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VotingController extends Controller
{
    public function vote()
    {
        $poll_id = request()->poll_id;
        $options = request()->options;

        $poll = Poll::findOrFail($poll_id);
        if ($poll->status != 'active') {
            return response()->json(['error' => 'Voting not allowed, time out'], 400);
        }
        DB::beginTransaction();
        try {
            if ($poll->allow_multiple) {
                foreach ($options as $option) {
                    $pollOption = PollOption::where('poll_id', $poll_id)
                        ->where('id', $option)->first();
                    if ($pollOption) {
                        $pollOption->increment('votes');
                    } else {
                        throw new \Exception("Option not exist for the poll", 500);
                    }
                }
            } else {
                if (count($options) != 1) {
                    return response()->json(['error' => 'You can only vote for one option.'], 500);
                }

                $pollOption = PollOption::where('poll_id', $poll_id)
                    ->where('id', $options[0])->first();
                if ($pollOption) {
                    $pollOption->increment('votes');
                } else {
                    throw new \Exception("Option not exist for the poll", 500);
                }
            }

            $poll->increment('total_vote');
            DB::commit();

            return Response::success('Vote recieved successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return Response::error();
        }
    }
}
