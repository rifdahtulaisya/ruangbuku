<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['category_name'];

    // Category 1 - N Book
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
