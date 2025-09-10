<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Meal extends Model
{
    use HasFactory;

    public function creator() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likedBy() : BelongsToMany
    {
        return $this->belongsToMany(User::class, $table = 'favorite');
    }
}
