<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollOption extends Model
{
    //make fillable
    protected $fillable = [
        'poll_id',
        'option',
        'votes',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
