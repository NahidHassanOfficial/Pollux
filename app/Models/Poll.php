<?php
namespace App\Models;

use App\Observers\PollObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Str;

#[ObservedBy([PollObserver::class])]
class Poll extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'allow_multiple',
        'public_visibility',
        'status',
        'total_visitor',
        'total_vote',
        'expire_at',
        'signature',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->poll_uid = str()->uuid();
        });

    }

    public function scopeVisible($query)
    {
        return $query->where('public_visibility', true)->where('status', '!=', 'restricted');
    }

    public function scopeUnexpired($query)
    {
        return $query->where('expire_at', '>', now());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pollOptions()
    {
        return $this->hasMany(PollOption::class);
    }

}
