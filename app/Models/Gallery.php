<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GalleryTag;


class Gallery extends Model
{
    public function tags()
    {
        return $this->belongsToMany(GalleryTag::class);
    }
}
