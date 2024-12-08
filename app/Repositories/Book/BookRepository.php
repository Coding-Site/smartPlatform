<?php

namespace App\Repositories\Book;

use App\Models\Book\Book;

class BookRepository implements BookRepositoryInterface
{
    public function getAllBooks()
    {
        return Book::paginate(10);
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
}

