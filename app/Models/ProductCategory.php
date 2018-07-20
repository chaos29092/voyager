<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProductCategory extends Model
{
    public function parentId()
    {
        return $this->belongsTo(self::class);
    }
}
