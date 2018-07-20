<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;


class Article extends Model
{
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
