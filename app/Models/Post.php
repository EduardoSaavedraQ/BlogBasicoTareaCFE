<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopeAuthorFilter($query, $partialName) {
        $partialName = strtoupper($partialName);
        return $query->whereHas('author.datos', function($query) use ($partialName) {
            $query->whereRaw("UPPER(CONCAT(datosusers.nombre, ' ', datosusers.paterno, ' ', datosusers.materno) LIKE ?)", ["%{$partialName}%"]);
        });
    }
}
