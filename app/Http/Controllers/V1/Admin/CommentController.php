<?php

namespace App\Http\Controllers\V1\Admin;

use App\API\Req\Request;
use App\API\Res\Facades\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\Comment\AnswerCommentRequest;
use App\Http\Requests\V1\Admin\Comment\IndexCommentRequest;
use App\Http\Requests\V1\Admin\Comment\ShowCommentRequest;
use App\Http\Resources\V1\Admin\Comment\CommentApiResource;
use App\Http\Resources\V1\Admin\Comment\CommentApiResourceCollection;
use App\Http\Resources\V1\Admin\Comment\ShowCommentDatilsResource;
use App\Models\Comment;
use App\Models\User;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexCommentRequest $request)
    {
        $result = app(Request::class)(function () {
            return Comment::with(['user', 'post'])->paginate(5);
        });

        return Response::withStatus(200)->withData(new CommentApiResourceCollection($result->data))->send();
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowCommentRequest $request, Comment $comment)
    {
        $result = app(Request::class)(function () use ($comment) {
            $comment->load('children');

            return $comment;
        });

        return Response::withStatus(200)->withData(new ShowCommentDatilsResource($comment))->send();
    }

    /**
     * Store the specified resource in storage.
     */
    public function answer(AnswerCommentRequest $request, Comment $comment)
    {

        if ($comment->comment_id != null) {
            return Response::withStatus(400)->withMessage('cant reply to answer comment')->send();
        }

        $result = app(Request::class)(function () use ($request, $comment) {
            $inputs = $request->validated();

            $inputs['comment_id'] = $comment->id;
            $inputs['post_id'] = $comment->post_id;
            $inputs['user_id'] = User::first()->id;

            return Comment::create($inputs);
        });

        return Response::withStatus(200)->withData(new CommentApiResource($result->data))->send();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function changeStatus(Comment $comment)
    {
        $result = app(Request::class)(function () use ($comment) {
            $comment->update(['status' => $comment->status == 1 ? 2 : 1]);

            return $comment;
        });

        return Response::withStatus(200)->withData(new CommentApiResource($comment))->send();
    }
}
