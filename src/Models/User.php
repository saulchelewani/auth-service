<?php

namespace TNM\AuthService\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
