<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Event;


class Comment extends Model
{
    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 'user_id', 'comment'
    ];

    public function events()
    {
        return $this->belongsTo(Event::class);
    }     
}
