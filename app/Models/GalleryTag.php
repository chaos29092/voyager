<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Gallery;


class GalleryTag extends Model
{
    public function galleries()
    {
        return $this->belongsToMany(Gallery::class);
    }
}
