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
        return Unit::with('lessons')->with('translations')->findOrFail($id);
    }

    public function create(array $data)
    {
        $unit = Unit::create($data);
        foreach ($data['translations'] as $translation) {
            $unit->translateOrNew($translation['locale'])->title = $translation['title'];
        }
        $unit->save();
        return$unit;
    }


    public function update($id, array $data)
    {
        $unit = $this->getById($id);
        $unit->update($data);

        if (!empty($data['translations'])) {
            foreach ($data['translations'] as $translation) {
                $unit->translateOrNew($translation['locale'])->title = $translation['title'];
            }
            $unit->save();
        }
        return $unit;

    }

    public function delete($id)
    {
        $unit = $this->getById($id);
        return $unit->delete();
    }
}
