<?php

namespace TNM\AuthService\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public static function findByRoute(string $route): ?self
    {
        return static::where(['route' => $route])->first();
    }

    public static function getPermissionsFromRequest(array $request): array
    {
        return array_map(function (array $permission) {
            if (!static::findByRoute($permission['route'])) {
                static::create([
                    'origin_id' => $permission['id'],
                    'name' => $permission['name'],
                    'route' => $permission['route']
                ]);
            }
            return $permission['route'];
        }, json_decode($request['permissions'], true));
    }

    public static function sync(array $request)
    {
        if (!array_key_exists('permissions', $request)) return [];
        return array_map(function (string $route) {
            return Permission::findByRoute($route)->{'id'};
        }, static::getPermissionsFromRequest($request));
    }
}
