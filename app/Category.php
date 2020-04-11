<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Event;


class Category extends Model
{
    protected $table = 'categorys';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    public function events()
    {
        //return $this->hasMany('App\User', 'role_id', 'id');
        return $this->belongsToMany(Event::class);
    }
    
}
