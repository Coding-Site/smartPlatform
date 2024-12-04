<?php

namespace App\Http\Controllers\Book;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\Book\BookResource;
use App\Models\Book\Book;
use App\Repositories\Book\BookRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function index()
    {
        try {
            $books = $this->bookRepository->getAllBooks();
            return ApiResponse::sendResponse(200,'All Books',BookResource::collection($books));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Failed to fetch books');
        }
    }

    public function show(Book $book)
    {
        try {
            $book = $this->bookRepository->getBookById($book);
            return ApiResponse::sendResponse(200,'The Book',new BookResource($book));
        }catch (ModelNotFoundException $e) {
                return ApiResponse::sendResponse(404, 'Book Not Found');
        }catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Failed to fetch book');
        }
    }
}
