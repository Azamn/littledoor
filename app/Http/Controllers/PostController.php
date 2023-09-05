<?php

namespace App\Http\Controllers;

use App\Models\PostLike;
use App\Models\UserPost;
use App\Models\PostComment;
use Illuminate\Http\Request;
use App\Http\Resources\UserPostResource;
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
                $userPost->user_id = $user->id;
                $userPost->post = $request->post;
                $userPost->save();

                return response()->json(['status' => true, 'message' => 'Post Submitted Successfully']);
            }
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


    public function getAllPost(Request $request)
    {

        $user = $request->user();

        if ($user) {

            $allUserPost = UserPost::with('user', 'likes', 'comments.user')->get();
            if ($allUserPost) {
                return response()->json(['status' => true, 'data' => UserPostResource::collection($allUserPost)]);
            }
        }
    }

    public function getUserPost(Request $request)
    {
        $user = $request->user();

        if ($user) {

            $allUserPost = UserPost::with('user', 'likes', 'comments.user')->where('user_id', $user->id)->get();
            if ($allUserPost) {
                return response()->json(['status' => true, 'data' => UserPostResource::collection($allUserPost)]);
            }
        }
    }

    public function deletePost(Request $request, $postId)
    {

        $user = $request->user();

        if ($user) {

            $userPost = UserPost::where('id', $postId)->first();
            if ($userPost) {

                $postLikes = PostLike::where('post_id', $userPost->id)->get();
                if ($postLikes) {
                    foreach ($postLikes as $likes) {
                        $likes->delete();
                    }
                }

                $postComments = PostComment::where('post_id', $userPost->id)->get();
                if ($postComments) {
                    foreach ($postComments as $comments) {
                        $comments->delete();
                    }
                }

                $userPost->delete();

                return response()->json(['status' => true, 'message' => 'Post Data Deleted Successfully']);
            }
        }
    }
}
