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
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }
    public function index(Request $request)
    {
        try {
            $stageId = $request->query('stage_id');
            $gradeId = $request->query('grade_id');

            $books = $this->bookRepository->getAllBooks($stageId, $gradeId);

            return ApiResponse::sendResponse(200, 'All Books', BookResource::collection($books));
        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'Failed to fetch books');
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

    public function download(Book $book)
    {
        return $this->bookRepository->downloadFileSample($book);
    }
}
