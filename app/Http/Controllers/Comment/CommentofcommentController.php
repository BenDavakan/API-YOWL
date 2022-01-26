<?php

namespace App\Http\Controllers\Comment;

use Illuminate\Http\Request;
use App\Models\Commentofcomment;
use App\Http\Controllers\Controller;

class CommentofcommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_commentofcomment = Commentofcomment::with('likes')->orderBy('created_at', 'DESC')->get();
        return response($all_commentofcomment);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $fields = $request->validate([
            'content' => ['required', 'string'],
        ]);

        $new_ccomment = Commentofcomment::create([
            'content' => $fields['content'],
            'user_id' => auth()->user()->id,
            'comment_id' => $id
        ]);
        $response = [
            'comment' => $new_ccomment,
            'message' => 'Comment of comment create successfully'
        ];
        return response($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Commentofcomment::find($id);
        if (!$comment) {
            return response('Not Found', 404);
        }
        return response($comment);
    }
}
