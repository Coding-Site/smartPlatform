<?php

namespace App\Http\Controllers\Like;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Comment\Comment;
use App\Models\Like\Like;
use App\Models\Teacher\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggleLike(Request $request, $commentId)
    {
        $user = auth()->user();
        $type = $request->input('type');

        if ($type === 'user') {
            $likable = User::findOrFail($user->id);
        } elseif ($type === 'teacher') {
            $likable = Teacher::findOrFail($user->id);
        } else {
            return ApiResponse::sendResponse(400, 'Invalid type');
        }

        $comment = Comment::findOrFail($commentId);

        $like = Like::where('likable_id', $likable->id)
            ->where('likable_type', get_class($likable))
            ->where('comment_id', $comment->id)
            ->first();

        if ($like) {
            $like->delete();
            return ApiResponse::sendResponse(200,  'Comment unliked');

        } else {
            $comment->likes()->create([
                'likable_id' => $likable->id,
                'likable_type' => get_class($likable),
            ]);
            return ApiResponse::sendResponse(200, 'Comment liked');
        }
    }

}
