<?php

namespace TNM\AuthService\Tests;

use App\User;
use PHPUnit\Framework\TestCase;
use TNM\AuthService\Models\Permission;

class PermissionTest extends TestCase
{
    public function testSyncPermissions()
    {
        $fakeRequest = json_decode('{
  "result": {
    "success": true,
    "code": 200,
    "error": null,
    "message": "Action complete"
  },
  "auth": {
    "authenticated": true,
    "role": "Developer",
    "name": "Saul Chelewani",
    "username": "S.chelewani",
    "password": "$2y$10$yyk8pwJ7M5oUuT38k71bQekRKTUz5fdCc\/rbIb3w6g5PFikbAlmfW",
    "handshake": "xr\/WCQjjQp531JyXqlrnvm\/+XoV7ha6bJD\/Y3LZjJumXPsGGDj3BnE+VDyR7b7lXNij989nvNGjot2fv5YgTew==",
    "permissions": [
      {
        "id": 2,
        "name": "View Secret",
        "client_id": 1,
        "created_at": "2019-08-15 07:40:18",
        "updated_at": "2019-08-20 12:15:11",
        "route": "secret.show",
        "pivot": {
          "client_user_id": 1,
          "permission_id": 2
        }
      },
      {
        "id": 3,
        "name": "Edit Client",
        "client_id": 1,
        "created_at": "2019-08-15 11:53:01",
        "updated_at": "2019-08-20 12:15:53",
        "route": "client.update",
        "pivot": {
          "client_user_id": 1,
          "permission_id": 3
        }
      },
      {
        "id": 6,
        "name": "Edit Permissions",
        "client_id": 1,
        "created_at": "2019-08-15 21:30:25",
        "updated_at": "2019-08-20 12:16:07",
        "route": "permission.update",
        "pivot": {
          "client_user_id": 1,
          "permission_id": 6
        }
      },
      {
        "id": 7,
        "name": "Create Groups",
        "client_id": 1,
        "created_at": "2019-08-15 21:30:49",
        "updated_at": "2019-08-20 12:16:34",
        "route": "groups.store",
        "pivot": {
          "client_user_id": 1,
          "permission_id": 7
        }
      },
      {
        "id": 13,
        "name": "Create User",
        "client_id": 1,
        "created_at": "2019-08-20 12:05:29",
        "updated_at": "2019-08-20 12:05:29",
        "route": "users.store",
        "pivot": {
          "client_user_id": 1,
          "permission_id": 13
        }
      }
    ],
    "groups": [
      "Developers"
    ]
  }
}', true);
        $permissions = Permission::getPermissionsFromRequest($fakeRequest);

        $this->assertEquals([
            "secret.show",
            "client.update",
            "permission.update",
            "groups.store",
            "users.store"
        ], $permissions);
    }
}
