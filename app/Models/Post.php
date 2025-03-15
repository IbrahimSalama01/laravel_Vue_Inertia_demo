<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Post extends Model
{
    //
    use SoftDeletes;
    use HasFactory;
    use Sluggable;
    use SluggableScopeHelpers;
    use HasApiTokens;
    protected $fillable = [
        "title",
        "description",
        "user_id"
    ];
    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);

    }
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
