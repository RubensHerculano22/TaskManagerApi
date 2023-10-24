<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $appends = ['_links'];
    protected $fillable = [
        'name'
    ];

    public function getLinksAttribute()
    {
        return [
            'href'  => route('categories.categoriesShow', $this->id),
            'rel'   => 'Categoria'
        ];
    }

    public function task()
    {
        return $this->hasOne(Task::class);
    }
}
