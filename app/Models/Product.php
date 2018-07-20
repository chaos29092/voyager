<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Resizable;

class Product extends Model
{
    use Resizable;

    public function tags()
    {
        return $this->belongsToMany(ProductTag::class);
    }
}
