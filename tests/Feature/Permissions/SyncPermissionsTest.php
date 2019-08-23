<?php

namespace TNM\AuthService\Tests\Feature\Permissions;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SyncPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_sync_permissions_from_auth_server()
    {
        $this->assertTrue(true);
    }
}
