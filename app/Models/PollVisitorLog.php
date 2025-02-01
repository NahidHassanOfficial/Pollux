<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollVisitorLog extends Model
{
    protected $fillable = [
        'poll_id',
        'ip',
        'user_agent',
        'is_voted',
        'hits',
    ];
}
