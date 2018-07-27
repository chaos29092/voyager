<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Resizable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    use Resizable;

//    use SearchableTrait;
//    protected $searchable = [
//        'columns' => [
//            'users.first_name' => 10,
//            'users.last_name' => 10,
//            'users.bio' => 2,
//            'users.email' => 5,
//            'posts.title' => 2,
//            'posts.body' => 1,
//        ],
//        'joins' => [
//            'posts' => ['users.id','posts.user_id'],
//        ],
//    ];

    public function tags()
    {
        return $this->belongsToMany(ProductTag::class);
    }
}
