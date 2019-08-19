<?php

namespace TNM\AuthService\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
