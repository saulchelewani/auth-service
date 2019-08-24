<?php


namespace TNM\AuthService\Http\Controllers;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use TNM\AuthService\Models\Permission;

class PermissionsController extends Controller
{
    public function sync(Request $request)
    {
        $user = User::findByUsername($request->get('username'));
        if (!$user) return response()->json();
        $user->update(['role' => $request->get('role')]);
        $user->permissions()->sync(Permission::sync($request->all()));
        return response()->json($user->load('permissions'));
    }
}
