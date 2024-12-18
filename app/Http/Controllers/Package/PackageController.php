<?php

namespace App\Http\Controllers\Package;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Package\PackageRequest;
use App\Http\Resources\Package\PackageResource;
use App\Models\Package\Package;
use App\Repositories\Package\PackageRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    protected $packageRepository;

    public function __construct(PackageRepository $packageRepository)
    {
        $this->packageRepository = $packageRepository;
    }


    public function index()
    {
        try {
            $packages = $this->packageRepository->all();
            return ApiResponse::sendResponse(200, 'All Packages', PackageResource::collection($packages));
        } catch (\Exception $e) {
            return ApiResponse::sendResponse(500,'Failed to fetch packages');
        }
    }


    public function show(Package $package)
    {
        try {
            $package = $this->packageRepository->findById($package);
            return ApiResponse::sendResponse(200,'The Package',new PackageResource($package));
        }catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404, 'Package Not Found');
        }catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Failed to fetch package');
        }    }


    public function store(PackageRequest $request)
    {
        try {
            $package = $this->packageRepository->create($request->validated());
            return ApiResponse::sendResponse(200, 'Package created successfully', new PackageResource($package));
        } catch (\Exception $e) {
            return ApiResponse::sendResponse(500,'Failed to create package');
        }
    }


    public function update(PackageRequest $request, Package $package)
    {
        try {
            $updated = $this->packageRepository->update($package, $request->validated());

            if (!$updated) {
                return ApiResponse::sendResponse(404, 'Package not found');
            }

            return ApiResponse::sendResponse(200, 'Package updated successfully', new PackageResource($package));
        } catch (\Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to update package');
        }
    }

    public function destroy(Package $package)
    {
        try {
            $deleted = $this->packageRepository->delete($package);

            if (!$deleted) {
                return ApiResponse::sendResponse(404,'Package not found');
            }

            return ApiResponse::sendResponse(200, 'Package deleted successfully');
        } catch (\Exception $e) {
            return ApiResponse::sendResponse(500,'Failed to delete package');
        }
    }

    public function filteredPackages(Request $request)
    {
        try {
            $packages = $this->packageRepository->getFilteredPackages($request);

            $packagesObject = $packages->mapWithKeys(function ($package) {
                return [$package->type->value => new PackageResource($package)];
            });

            return ApiResponse::sendResponse(200, 'Packages', $packagesObject);
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to fetch packages');
        }
    }


}
