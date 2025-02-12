<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollReport extends Model
{

    protected $fillable = [
        'poll_id',
        'reporter_ip',
        'reason',
        'description',
        'restrict_poll',
        'report_status',
        'admin_note',
        'superuser_id',
    ];

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function superuser()
    {
        return $this->belongsTo(Superuser::class);
    }

}