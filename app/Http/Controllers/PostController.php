<?php

namespace App\Http\Controllers;

use App\Models\PostComment;
use App\Models\PostLike;
use App\Models\UserPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function createPost(Request $request)
    {

        $rules = [
            'title' => 'sometimes|required',
            'post' => 'required|string',
            'image' => 'sometimes|required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $userPost = new UserPost();
                if ($request->has('title')) {
                    $userPost->title = $request->title;
                }

                if ($request->has('image')) {

                    $userPost->addMediaFromRequest('image')->toMediaCollection('user-post');
                }

                $userPost->post = $request->post;
                $userPost->save();

                return response()->json(['status' => true, 'message' => 'Post submitted Successfully']);
            }
        }
    }

    public function getAllPost(Request $request)
    {

        $user = $request->user();

        if ($user) {
        }
    }

    public function addPostLike(Request $request)
    {

        $rules = [
            'post_id' => 'required|integer',
            'post_like' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $postLike = new PostLike();
                $postLike->user_id = $user->id;
                $postLike->post_id = $request->post_id;
                $postLike->post_like = $request->post_like;
                $postLike->save();

                return response()->json(['status' => true, 'message' => 'Your Response Added Succesfully.']);
            }
        }
    }

    public function addPostComment(Request $request)
    {
        $rules = [
            'post_id' => 'required|integer',
            'comments' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $postComment = new PostComment();
                $postComment->user_id = $user->id;
                $postComment->post_id = $request->post_id;
                $postComment->comments = $request->comments;
                $postComment->save();

                return response()->json(['status' => true, 'message' => 'Your comment added successfully.']);
            }
        }
    }
}
