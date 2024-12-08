<?php

namespace App\Repositories\Book;

use App\Helpers\ApiResponse;
use App\Models\Book\Book;
use Illuminate\Http\Response;

class BookRepository implements BookRepositoryInterface
{
    public function getAllBooks()
    {
        return Book::with(['teacher', 'term', 'grade'])->paginate(10);
    }

    public function createBook(array $data)
    {
        $fileSample = $data['file_sample'] ?? null;
        $image = $data['image'] ?? null;
        unset($data['file_sample'], $data['image']);

        $book = Book::create($data);

        if ($fileSample) {
            $book->addMedia($fileSample)
                ->toMediaCollection('file_samples');
        }

        if ($image) {
            $book->addMedia($image)
                ->toMediaCollection('image');
        }

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

