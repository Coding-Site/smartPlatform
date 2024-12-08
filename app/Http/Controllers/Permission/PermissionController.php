<?php

namespace App\Http\Controllers\Permission;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Permission\PermissionResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return ApiResponse::sendResponse(200, 'Permissions retrieved successfully', PermissionResource::collection($permissions));
    }
}

