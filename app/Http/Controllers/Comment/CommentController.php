<?php

namespace App\Http\Controllers\Comment;

use App\Enums\Comment\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment\Comment;
use App\Models\Lesson\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Lesson $lesson)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validated();

        $parentComment = $request->parent_id ? Comment::find($request->parent_id) : null;

        if ($parentComment) {
            if ($parentComment->lesson_id !== $lesson->id) {
                return response()->json(['error' => 'This reply does not belong to the correct lesson'], 400);
            }

            if ($parentComment->user_id !== Auth::id() && !Auth::guard('teacher')->check()) {
                return response()->json(['error' => 'Unauthorized to reply to this comment'], 403);
            }
            $lessonId = $parentComment->lesson_id;
        } else {
            $lessonId = $lesson->id;
        }

        $status = Auth::guard('teacher')->check() ? Status::APPROVED->value : Status::PENDING->value;

        Comment::create([
            'user_id' => Auth::id(),
            'lesson_id' => $lessonId,
            'content' => $validated['content'],
            'parent_id' => $request->parent_id,
            'status' => $status,
        ]);

        $message = (Auth::guard('teacher')->check())
            ? 'Your comment has been created'
            : 'Your comment is pending approval';

        return response()->json(['success' => $message], 201);
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

        return CommentResource::collection($comments);
    }

    public function approve(Comment $comment)
    {
        if (!Auth::guard('teacher')->check()) {
            return response()->json(['error' => 'Unauthorized. Teacher access required'], 403);
        }

        $comment->update(['status' => Status::APPROVED->value]);

        return response()->json(['success' => 'Comment approved'], 200);
    }

    public function reject(Comment $comment)
    {
        if (!Auth::guard('teacher')->check()) {
            return response()->json(['error' => 'Unauthorized. Teacher access required'], 403);
        }

        $comment->update(['status' => Status::REJECTED->value]);

        return response()->json(['success' => 'Comment Rejected'], 200);
    }
}
