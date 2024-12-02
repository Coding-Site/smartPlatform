<?php

namespace App\Http\Controllers\Comment;

use App\Enums\Comment\Status;
use App\Http\Controllers\Controller;
use App\Models\Comment\Comment;
use App\Models\Lesson\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Lesson $lesson)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'lesson_id' => $lesson->id,
            'content' => $validated['content'],
            'parent_id' => $request->parent_id,
            'status' => Status::PENDING->value,
        ]);

        return response()->json(['success' => 'Your comment is pending approval'], 201);
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

        return response()->json($comments);
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
