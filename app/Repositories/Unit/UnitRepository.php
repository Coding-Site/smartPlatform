<?php
namespace App\Repositories\Unit;

use App\Models\Unit\Unit;

class UnitRepository
{
    public function getAll()
    {
        return Unit::with('translations')->get();
    }

    public function getById($id)
    {
        return Unit::with('translations')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Unit::create($data);
    }

    public function update($id, array $data)
    {
        $unit = $this->getById($id);
        $unit->update($data);
        return $unit;
    }

    public function delete($id)
    {
        $unit = $this->getById($id);
        return $unit->delete();
    }
}
