<?php

namespace App\Http\Controllers\Book;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\Book\BookResource;
use App\Models\Book\Book;
use App\Repositories\Book\BookRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DashboardBookController extends Controller
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

    public function store(StoreBookRequest $request)
    {
        try {
            $validated = $request->validated();
            $book = $this->bookRepository->createBook($validated);
            return ApiResponse::sendResponse(201,' Book Created Successfully',new BookResource($book));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500,'Failed to create book'. $e->getMessage());
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

    public function update(UpdateBookRequest $request, Book $book)
    {
        try {
                $validated = $request->validated();
                $book = $this->bookRepository->updateBook($book, $validated);
                return ApiResponse::sendResponse(201,' Book Update Successfully',new BookResource($book));
            }catch (ModelNotFoundException $e) {
                return ApiResponse::sendResponse(404, 'Book Not Found');
            }catch (Exception $e) {
                return ApiResponse::sendResponse(500,'Failed to Update book'. $e->getMessage());
            }
    }

    public function destroy(Book $book)
    {
        try {
                $this->bookRepository->deleteBook($book);
                return ApiResponse::sendResponse(201,' Book Deleted Successfully');
            } catch (ModelNotFoundException $e) {
                return ApiResponse::sendResponse(404, 'Book Not Found');
            } catch (Exception $e) {
                return ApiResponse::sendResponse(500,'Failed to Delete book'. $e->getMessage());
            }
    }
}
