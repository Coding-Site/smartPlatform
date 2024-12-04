<?php

namespace App\Repositories\Book;

use App\Models\Book\Book;

interface BookRepositoryInterface
{
    public function getAllBooks();
    public function createBook(array $data);
    public function getBookById(Book $book);
    public function updateBook(Book $book, array $data);
    public function deleteBook(Book $book);
}
