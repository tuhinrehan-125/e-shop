<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $filable = [
        'category_id',
        'name',
        'description',
        'delete_status',
    ];
    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
