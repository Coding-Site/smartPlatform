<?php

namespace App\Http\Controllers\Comment;

use App\Enums\Comment\Status;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment\Comment;
use App\Models\Lesson\Lesson;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Lesson $lesson)
    {
        if (!Auth::check()) {
            return ApiResponse::sendResponse(401, 'Unauthorized');
        }

        if (($request->has('content') && $request->hasFile('voice_note')) || (!$request->has('content') && !$request->hasFile('voice_note'))) {
            return ApiResponse::sendResponse(422, 'Please provide either content or a voice note, but not both.');
        }

        $validated = $request->validated();

        $parentComment = $request->parent_id ? Comment::find($request->parent_id) : null;

        if ($parentComment) {
            if ($parentComment->lesson_id !== $lesson->id) {
                return ApiResponse::sendResponse(400, 'This reply does not belong to the correct lesson');
            }

            if ($parentComment->user_id !== Auth::id() && !Auth::guard('teacher')->check()) {
                return ApiResponse::sendResponse(403, 'Unauthorized to reply to this comment');
            }
            $lessonId = $parentComment->lesson_id;
        } else {
            $lessonId = $lesson->id;
        }

        $status = Auth::guard('teacher')->check() ? Status::APPROVED->value : Status::PENDING->value;

        if ($request->hasFile('voice_note')) {
            $voiceNotePath = $request->file('voice_note')->store('voice_notes', 'public');

            Comment::create([
                'user_id' => Auth::id(),
                'lesson_id' => $lessonId,
                'content' => null,
                'parent_id' => $request->parent_id,
                'status' => $status,
            ]);

            $comment = Comment::latest()->first();
            $comment->addMedia(storage_path("app/public/{$voiceNotePath}"))->toMediaCollection('voice_notes');
        }else{
            Comment::create([
                'user_id' => Auth::id(),
                'lesson_id' => $lessonId,
                'content' => $validated['content'],
                'parent_id' => $request->parent_id,
                'status' => $status,
            ]);
        }

        $message = (Auth::guard('teacher')->check())
            ? 'Your comment has been created'
            : 'Your comment is pending approval';

        return ApiResponse::sendResponse(201, $message);
    }

    public function showComments(Lesson $lesson)
    {
        $comments = Comment::where('lesson_id', $lesson->id)
            ->where('parent_id', null)
            ->approved()
            ->with([
                'replies' => function($query) {
                    $query->approved();
                }
            ])
            ->get();

        return ApiResponse::sendResponse(200, 'Comments retrieved successfully', CommentResource::collection($comments));
    }

    public function approve(Comment $comment)
    {
        if (!Auth::guard('teacher')->check()) {
            return ApiResponse::sendResponse(403, 'Unauthorized. Teacher access required');
        }

        $comment->update(['status' => Status::APPROVED->value]);

        return ApiResponse::sendResponse(200, 'Comment approved');
    }

    public function reject(Comment $comment)
    {
        if (!Auth::guard('teacher')->check()) {
            return ApiResponse::sendResponse(403, 'Unauthorized. Teacher access required');
        }

        $comment->update(['status' => Status::REJECTED->value]);

        return ApiResponse::sendResponse(200, 'Comment rejected');
    }
}
