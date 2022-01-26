<?php

namespace App\Http\Controllers\Like;

use App\Models\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    public function likeComment($id)
    {
        $likable_ty = 'App\Models\Comment';
        $a_comment = Like::where([
            'likable_id' => $id,
            'likable_type' => $likable_ty,
            'user_id' => auth()->user()->id
        ])->get();

        if ($a_comment->isEmpty()) {
            $response = Like::create([
                'user_id' => auth()->user()->id,
                'likable_id' => $id,
                'likable_type' => $likable_ty,
            ]);
            if ($response) {
                return response([
                    'message' => 'liked'
                ]);
            }
        } else {
            $response =
                Like::where([
                    'likable_id' => $id,
                    'likable_type' => $likable_ty,
                    'user_id' => auth()->user()->id
                ])->delete();
            if ($response) {
                return response([
                    'message' => 'disliked'
                ]);
            }
        }
    }
    //mfjdfjkdnfgkjdnkfdjkjdnjdfkjnglodsb fds
    public function likeCommentOfComment($id)
    {
        $likable_ty = 'App\Models\Commentofcomment';
        $a_comment = Like::where([
            'likable_id' => $id,
            'likable_type' => $likable_ty,
            'user_id' => auth()->user()->id
        ])->get();

        if ($a_comment->isEmpty()) {
            $response = Like::create([
                'user_id' => auth()->user()->id,
                'likable_id' => $id,
                'likable_type' => $likable_ty,
            ]);
            if ($response) {
                return response([
                    'message' => 'liked'
                ]);
            }
        } else {
            $response =
                Like::where([
                    'likable_id' => $id,
                    'likable_type' => $likable_ty,
                    'user_id' => auth()->user()->id
                ])->delete();
            if ($response) {
                return response([
                    'message' => 'disliked'
                ]);
            }
        }
    }
    public function index()
    {
        return Like::with('likable')->get();
    }
}
