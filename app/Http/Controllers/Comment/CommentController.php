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
        // dd(Auth::user());
        // if (Auth::check() || !Auth::guard('teacher')->check()) {
        //     return ApiResponse::sendResponse(401, 'Unauthorized');
        // }

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

        $commentData = [
            'lesson_id' => $lessonId,
            'content' => $request->has('content') ? $validated['content'] : null,
            'parent_id' => $request->parent_id,
            'status' => $status,
        ];

        if (Auth::guard('teacher')->check()) {
            $commentData['teacher_id'] = Auth::guard('teacher')->id();
        } else {
            $commentData['user_id'] = Auth::id();
        }

        if ($request->hasFile('voice_note')) {
            $voiceNotePath = $request->file('voice_note')->store('voice_notes', 'public');
            $commentData['content'] = null;

            $comment = Comment::create($commentData);
            $comment->addMedia(storage_path("app/public/{$voiceNotePath}"))->toMediaCollection('voice_notes');
        } else {
            Comment::create($commentData);
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


    public function update(CommentRequest $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id() && $comment->teacher_id !== Auth::guard('teacher')->id()) {
            return ApiResponse::sendResponse(403, 'Unauthorized to update this comment');
        }

        $validated = $request->validated();

        if ($request->has('content') && $request->hasFile('voice_note')) {
            return ApiResponse::sendResponse(422, 'You cannot upload both content and a voice note at the same time');
        }

        if ($request->has('content')) {
            if ($comment->media->count() > 0) {
                $comment->media->each(function ($media) {
                    $media->delete();
                });
            }
            $comment->content = $validated['content'];
        }

        if ($request->hasFile('voice_note')) {
            if ($comment->content) {
                $comment->content = null;
            }

            if ($comment->media->count() > 0) {
                $comment->media->each(function ($media) {
                    $media->delete();
                });
            }

            $voiceNotePath = $request->file('voice_note')->store('voice_notes', 'public');
            $comment->addMedia(storage_path("app/public/{$voiceNotePath}"))->toMediaCollection('voice_notes');
        }

        $comment->save();

        return ApiResponse::sendResponse(200, 'Comment updated successfully');
    }


    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id() && $comment->teacher_id !== Auth::guard('teacher')->id()) {
            return ApiResponse::sendResponse(403, 'Unauthorized to delete this comment');
        }

        if ($comment->media->count() > 0) {
            $comment->media->each(function ($media) {
                $media->delete();
            });
        }

        $comment->delete();

        return ApiResponse::sendResponse(200, 'Comment deleted successfully');
    }
}
