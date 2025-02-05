<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class ProfilePageController extends Controller
{
    public function profile()
    {
        return view('components.client.feature.profile');
    }
}
