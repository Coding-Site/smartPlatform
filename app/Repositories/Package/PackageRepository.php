<?php

namespace App\Repositories\Package;

use App\Models\Package\Package;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Exception;

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
            return Package::create($data);
        } catch (Exception $e) {
            throw new Exception('Error creating package: ' . $e->getMessage());
        }
    }


    public function update(Package $package, array $data): bool
    {
        try {
            return $package->update($data);
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
}