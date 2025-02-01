<?php
namespace App\Http\Controllers\API;

use App\Helper\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function profile($username)
    {
        $user       = User::where('username', $username)->first();
        $activePoll = $user->polls()->where('status', 'active')->count();

        return Response::success(null, [
            'user'       => $user,
            'activePoll' => $activePoll,
        ]);
    }

    public function userPolls($username)
    {
        $user  = User::where('username', $username)->first();
        $polls = $user->polls()->visible()->select('title', 'status', 'total_vote', 'expire_at')->paginate(10);

        return Response::success(null, [
            'polls' => $polls,
        ]);

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
