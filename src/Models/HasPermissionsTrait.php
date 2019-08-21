<?php


namespace TNM\AuthService\Models;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Passport\HasApiTokens;

trait HasPermissionsTrait
{
    use HasApiTokens;

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
}
