<?php

namespace App\Repositories\Package;

use App\Models\Package\Package;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Exception;
use Illuminate\Http\Request;

class PackageRepository
{

    public function all()
    {
        try {
            return Package::all();
        } catch (Exception $e) {
            throw new Exception('Error fetching packages: ' . $e->getMessage());
        }
    }

    public function findById(Package $package): ?Package
    {
        try {
            return $package;
        } catch (Exception $e) {
            throw new Exception('Error fetching package: ' . $e->getMessage());
        }
    }


    public function create(array $data): Package
    {
        try {
            $package = Package::create($data);

            $package->translateOrNew('ar')->name = $data['name_ar'];
            $package->translateOrNew('en')->name = $data['name_en'];
            $package->translateOrNew('ar')->description = $data['description_ar'];
            $package->translateOrNew('en')->description = $data['description_en'];

            $package->save();

            return $package;

        } catch (Exception $e) {
            throw new Exception('Error creating package: ' . $e->getMessage());
        }
    }


    public function update(Package $package, array $data): bool
    {
        try {
            $package->update($data);

            if (!empty($data['name_ar'])) {
                $package->translateOrNew('ar')->name = $data['name_ar'];
            }

            if (!empty($data['name_en'])) {
                $package->translateOrNew('en')->name = $data['name_en'];
            }
            if (!empty($data['description_ar'])) {
                $package->translateOrNew('ar')->description = $data['description_ar'];
            }

            if (!empty($data['description_en'])) {
                $package->translateOrNew('en')->description = $data['description_en'];
            }

            return $package->save();
        } catch (Exception $e) {
            throw new Exception('Error updating package: ' . $e->getMessage());
        }
    }

    public function delete(Package $package): bool
    {
        try {
            return $package->delete();
        } catch (Exception $e) {
            throw new Exception('Error deleting package: ' . $e->getMessage());
        }
    }

    public function getFilteredPackages(Request $request)
    {
        try {
            $stageId = $request->query('stage_id');
            $gradeId = $request->query('grade_id');
            return Package::filter($stageId, $gradeId)
                ->limit(3)
                ->get();
        } catch (Exception $e) {
            throw new Exception('Error fetching filtered packages: ' . $e->getMessage());
        }
    }
}
