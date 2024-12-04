<?php

namespace App\Repositories\Book;

use App\Models\Book\Book;

class BookRepository implements BookRepositoryInterface
{
    public function getAllBooks()
    {
        return Book::with(['teacher', 'term', 'grade'])->paginate(10);
    }

    public function createBook(array $data)
    {
        $fileSample = $data['file_sample'] ?? null;
        unset($data['file_sample']);

        $book = Book::create($data);

        if ($fileSample) {
            $book->addMedia($fileSample)
                ->toMediaCollection('file_samples');
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
        unset($data['file_sample']);

        $book->update($data);
        if ($fileSample) {
            $book->clearMediaCollection('file_samples');
            $book->addMedia( $fileSample)
                ->toMediaCollection('file_samples');
        }
        return $book;
    }

    public function deleteBook(Book $book)
    {
        $book->clearMediaCollection('file_samples');
        $book->delete();
        return true;
    }
}
