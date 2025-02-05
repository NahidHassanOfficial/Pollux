<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class FeaturePageController extends Controller
{
    public function createPoll()
    {
        return view('components.client.feature.create-poll');
    }

    public function pollFeed()
    {
        return view('components.client.feature.poll-feed');
    }

    public function viewPoll($poll_uid)
    {
        return view('components.client.feature.poll');
    }
}
