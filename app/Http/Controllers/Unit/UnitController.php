<?php

namespace App\Http\Controllers\Unit;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Unit\StoreUnitRequest;
use App\Http\Requests\Unit\UpdateUnitRequest;
use App\Http\Resources\Unit\UnitResource;
use App\Repositories\Unit\UnitRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UnitController extends Controller
{
    protected $unitRepository;

    public function __construct(UnitRepository $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }

    public function store(StoreUnitRequest $request)
    {
        try {
            $unit = $this->unitRepository->create($request->validated());
            return ApiResponse::sendResponse(201,'Unit Created Successfully',new UnitResource($unit));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Failed to create unit' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $unit = $this->unitRepository->getById($id);
            return ApiResponse::sendResponse(200,'Unit',new UnitResource($unit));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404,'Unit not found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Unable to fetch Unit'.$e->getMessage());
        }
    }

    public function update(UpdateUnitRequest $request, $id)
    {
        try {
            $unit = $this->unitRepository->update($id, $request->validated());
            return ApiResponse::sendResponse(200,'Unit Updated Successfully',new UnitResource($unit));
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404,'Unit not found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Unable to Update Unit'.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->unitRepository->delete($id);
            return ApiResponse::sendResponse(200,'Unnit deleted successfully');
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404,'Unnit not found');
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Unable to Delete Unnit'.$e->getMessage());
        }
    }

}
