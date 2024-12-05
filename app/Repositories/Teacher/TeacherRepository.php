<?php

namespace App\Repositories\Teacher;

use App\Models\Teacher\Teacher;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Exception;

class TeacherRepository
{

    public function all(): LengthAwarePaginator
    {
        try {
            return Teacher::paginate(10);
        } catch (Exception $e) {
            throw new Exception('Error fetching teachers: ' . $e->getMessage());
        }
    }

    public function findById(int $id): ?Teacher
    {
        try {
            return Teacher::find($id);
        } catch (Exception $e) {
            throw new Exception('Error fetching teacher: ' . $e->getMessage());
        }
    }

    public function create(array $data): Teacher
    {
        try {
            return Teacher::create($data);
        } catch (Exception $e) {
            throw new Exception('Error creating teacher: ' . $e->getMessage());
        }
    }

    public function update(int $id, array $data): bool
    {
        try {
            $teacher = Teacher::findOrFail($id);
            return $teacher->update($data);
        } catch (Exception $e) {
            throw new Exception('Error updating teacher: ' . $e->getMessage());
        }
    }


    public function delete(int $id): bool
    {
        try {
            $teacher = Teacher::findOrFail($id);
            return $teacher->delete();
        } catch (Exception $e) {
            throw new Exception('Error deleting teacher: ' . $e->getMessage());
        }
    }
}
