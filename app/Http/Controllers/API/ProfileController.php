<?php
namespace App\Http\Controllers\API;

use App\Helper\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    protected function isAuthUser()
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            return $user;
        }
        return false;
    }

    public function authUser()
    {
        $user = $this->isAuthUser();
        if ($user) {
            return Response::success('', $user);
        }
        return Response::error('Unauthorized');
    }

    public function profileInfo($username = null)
    {
        $user = [];

        if ($username == null) {
            $user = $this->isAuthUser();
            if (! $user) {
                return Response::error('User not found');
            }
        } else {
            $user = User::where('username', $username)->first();
        }

        $activePoll = $user->polls()->where('status', 'active')->count();

        return Response::success(null, [
            'user'       => $user,
            'activePoll' => $activePoll,
        ]);
    }

    public function userPolls($username = null)
    {
        $user = $this->isAuthUser();
        if ($user && ($user->username === $username || $username === null)) {
            $polls = $user->polls()->orderByDesc('created_at')->paginate(10);

            return Response::success(null, [
                'isOwner' => true,
                'polls'   => $polls,
            ]);

        }

        $user = User::where('username', $username)->first();
        if ($user) {
            $polls = $user->polls()->visible()->select('poll_uid', 'title', 'status', 'total_vote', 'expire_at')->paginate(10);

            return Response::success(null, [
                'isOwner' => false,
                'polls'   => $polls,
            ]);
        }

        return Response::error();
    }

    public function changePassword()
    {

        $password        = request()->password;
        $confirmPassword = request()->confirmPassword;

        if ($password === $confirmPassword) {
            $user = Auth::user();
            if ($user) {
                $updated = $user->update(['password' => bcrypt($password)]);
                if ($updated) {
                    return Response::success();
                }
            }
        }

        return Response::failed();
    }
}
