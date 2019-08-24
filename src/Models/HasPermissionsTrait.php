<?php


namespace TNM\AuthService\Models;


use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Passport\HasApiTokens;

trait HasPermissionsTrait
{
    use HasApiTokens;

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission(string $route): bool
    {
        return $this->permissions()->get()->contains(function (Permission $permission) use ($route) {
            return $route == $permission->{'route'};
        });
    }

    public static function findByUsername(string $username): ?User
    {
        return User::where(['username' => $username])->first();
    }
}
