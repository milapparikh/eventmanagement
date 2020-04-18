<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Comment;

class Event extends Model
{
    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id','location_id','title', 'description', 'event_date'
    ];


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }       

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
