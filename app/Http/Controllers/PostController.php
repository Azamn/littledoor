<?php

namespace App\Http\Controllers;

use App\Models\PostLike;
use App\Models\UserPost;
use App\Models\PostComment;
use Illuminate\Http\Request;
use App\Http\Resources\UserPostResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PostCommentsResource;

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

                $postLikeExist = PostLike::where('post_id', $request->post_id)->where('user_id', $user->id)->first();
                if ($postLikeExist) {
                    $postLikeExist->post_like = $request->post_like;
                    $postLikeExist->update();
                } else {
                    $postLike = new PostLike();
                    $postLike->user_id = $user->id;
                    $postLike->post_id = $request->post_id;
                    $postLike->post_like = $request->post_like;
                    $postLike->save();
                }

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

            $perPage = 10;
            if ($request->has('per_page')) {
                $perPage = $request->per_page;
            }

            $allUserPost = UserPost::with('user', 'likes',)->orderBy('created_at', 'desc')
                ->paginate($perPage);

            if ($allUserPost) {
                return response()->json([
                    'status' => true,
                    'data' => UserPostResource::collection($allUserPost),
                    "current_page"  => $allUserPost->currentPage() ? $allUserPost->currentPage() : Null,
                    "last_page"     => $allUserPost->lastPage() ? $allUserPost->lastPage() : NULL,
                    "per_page"      => $allUserPost->perPage() ? $allUserPost->perPage() : NULL,
                    "total"         => $allUserPost->total() ? $allUserPost->total() : NULL,
                ]);
            }
        }
    }

    public function getUserPost(Request $request)
    {
        $user = $request->user();

        if ($user) {

            $perPage = 10;
            if ($request->has('per_page')) {
                $perPage = $request->per_page;
            }

            $allUserPost = UserPost::with('user', 'likes',)->orderBy('created_at', 'desc')->where('user_id', $user->id)
                ->paginate($perPage);

            if ($allUserPost) {
                return response()->json([
                    'status' => true,
                    'data' => UserPostResource::collection($allUserPost),
                    "current_page"  => $allUserPost->currentPage() ? $allUserPost->currentPage() : Null,
                    "last_page"     => $allUserPost->lastPage() ? $allUserPost->lastPage() : NULL,
                    "per_page"      => $allUserPost->perPage() ? $allUserPost->perPage() : NULL,
                    "total"         => $allUserPost->total() ? $allUserPost->total() : NULL,
                ]);
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

    public function getPostComment(Request $request)
    {
        $rules = [
            'post_id' => 'required|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        } else {

            $user = $request->user();

            if ($user) {

                $perPage = 10;
                if ($request->has('per_page')) {
                    $perPage = $request->per_page;
                }

                $postComment = PostComment::where('post_id', $request->post_id)->orderBy('created_at', 'desc')
                    ->paginate($perPage);

                if ($postComment) {
                    return response()->json([
                        'status' => true,
                        'data' => PostCommentsResource::collection($postComment),
                        "current_page"  => $postComment->currentPage() ? $postComment->currentPage() : Null,
                        "last_page"     => $postComment->lastPage() ? $postComment->lastPage() : NULL,
                        "per_page"      => $postComment->perPage() ? $postComment->perPage() : NULL,
                        "total"         => $postComment->total() ? $postComment->total() : NULL,
                    ]);
                }
            }
        }
    }
}
