<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $appends = ['_links'];
    protected $fillable = [
        'category_id', 'user_id', 'title', 'description', 'date_limit', 'done'
    ];

    public function getLinksAttribute()
    {
        return [
            'href'  => route('tasks.tasksShow', $this->id),
            'rel'   => 'Tarefas'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
