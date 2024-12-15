<?php

namespace App\Repositories\Book;

use App\Helpers\ApiResponse;
use App\Models\Book\Book;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class BookRepository implements BookRepositoryInterface
{
    public function getAllBooks($stageId = null, $gradeId = null)
    {
        return Book::filter($stageId, $gradeId)->paginate(10);
    }

    public function getBooksByAuthUser()
    {
        $teacherId = Auth::id();
        return Book::where('teacher_id', $teacherId)->get();
    }

    public function createBook(array $data): Book
    {
        $book = Book::create($data);

        $book->translateOrNew('en')->name = $data['name_en'];
        $book->translateOrNew('ar')->name = $data['name_ar'];


        if (isset($data['file_sample'])) {
            $book->addMedia($data['file_sample'])
                ->toMediaCollection('file_samples');
        }

        if (isset($data['image'])) {
            $book->addMedia($data['image'])
                ->toMediaCollection('image');
        }

        $book->save();

        return $book;
    }

    public function getBookById(Book $book)
    {
        return $book;
    }

    public function updateBook(Book $book, array $data)
    {
        $fileSample = $data['file_sample'] ?? null;
        $image = $data['image'] ?? null;
        unset($data['file_sample'], $data['image']);

        $book->update($data);

        if (!empty($data['name_en'])) {
            $book->translateOrNew('en')->name = $data['name_en'];
        }

        if (!empty($data['name_ar'])) {
            $book->translateOrNew('ar')->name = $data['name_ar'];
        }

        if ($fileSample) {
            $book->clearMediaCollection('file_samples');
            $book->addMedia($fileSample)
                ->toMediaCollection('file_samples');
        }

        if ($image) {
            $book->clearMediaCollection('image');
            $book->addMedia($image)
                ->toMediaCollection('image');
        }

        $book->save();

        return $book;
    }
    public function deleteBook(Book $book)
    {
        $book->clearMediaCollection('file_samples');
        $book->clearMediaCollection('image');
        $book->delete();

        return true;
    }

    public function downloadFileSample(Book $book)
    {
        if (!$book->hasMedia('file_samples')) {
            return ApiResponse::sendResponse(Response::HTTP_NOT_FOUND, 'File sample not found.');
        }

        $fileSample = $book->getFirstMedia('file_samples');

        if ($fileSample) {
            $filePath = $fileSample->getPath();
            $fileName = $fileSample->file_name;

            return response()->download($filePath, $fileName);
        }

        return ApiResponse::sendResponse(Response::HTTP_NOT_FOUND, 'File not found.');
    }
}

