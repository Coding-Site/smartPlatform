<?php

namespace App\Http\Controllers\Role;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\Role\RoleResource;
use App\Models\Teacher\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return ApiResponse::sendResponse(200, 'Roles retrieved successfully', RoleResource::collection($roles));
    }


    public function store(StoreRoleRequest $request)
    {
        $request->validated();

        $role = Role::create(['name' => $request->name,'guard_name' => 'teacher']);

        if ($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }

        return ApiResponse::sendResponse(201, 'Role created successfully', new RoleResource($role));
    }


    public function show(Role $role)
    {
        return ApiResponse::sendResponse(200, 'Role retrieved successfully', new RoleResource($role));
    }


    public function update(UpdateRoleRequest $request, Role $role)
    {
        $request->validated();

        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return ApiResponse::sendResponse(201, 'Role updated successfully', new RoleResource($role));
    }


    public function destroy(Role $role)
    {
        $role->delete();

        return ApiResponse::sendResponse(200, 'Role deleted successfully');
    }

    public function assignRoleToTeacher(Request $request, Teacher $teacher)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|exists:roles,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($teacher->hasRole($request->role)) {
            return ApiResponse::sendResponse(200, 'Teacher already has the assigned role');
        }

        $teacher->assignRole($request->role);

        return ApiResponse::sendResponse(200, 'Role assigned successfully', [
            'teacher' => $teacher->load('roles'),
        ]);
    }

}

