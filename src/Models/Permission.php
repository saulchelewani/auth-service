<?php

namespace TNM\AuthService\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(config('auth.providers.users.model'));
    }
}
