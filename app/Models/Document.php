<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Document extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'content',
    ];

    /**
     * Returns all of the users that own the document
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
