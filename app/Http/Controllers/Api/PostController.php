<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Services\ImageUploadService;
use App\Models\Post;
use App\Models\User;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use Auth;

class PostController extends Controller
{
    public function store(StorePostRequest $request)
    {
        try {

            $post = Post::create(array_merge($request->validated() ,['user_id' => Auth::id()]));

            (new ImageUploadService($post, $request->file('image'), 'post_images'))->uploadImage()->storeImageDB('image');

            $post->save();

            return response()->success(['message' => 'Post Created Successfully']);

        } catch (\Throwable $th) {
            
            return response()->ExceptionError(['Some Error Occured'],500);
        }
    }

    public function update(StorePostRequest $request,Post $post)
    {
        try {
        
            $post->update($request->only(['name', 'description']));

            if (request()->hasFile('image') && request('image') != '') {
                
                $imageService = new ImageUploadService($post, $request->image, 'post_images');
                $imageService->deleteImage('image')->uploadImage()->storeImageDB('image');

                $post->update();
                
            }
            
            return response()->success(['message' => 'Post Updated Successfully']);
        
        } catch (\Throwable $th) {

            return response()->ExceptionError(['Some Error Occured'],500);
        }
    }

    public function destroy(Request $request, Post $post)
    {
        try {

            (new ImageUploadService($post, null, null))->deleteImage('image');

            if ($post->user_id !== Auth::id()) {

                return response()->unauthorized('You are not authorized to delete this post.');
            }

            $post->delete();
    
            return response()->success(['message' => 'Post Deleted Successfully']);
            
        } catch (\Throwable $th) {

            return response()->ExceptionError(['Some Error Occured'],500);
        }
    }

    public function searchPost(Request $request)
    {
        $post = Post::HasLikedByUser(Auth::id())->SortBy($request->sortby)->Search($request->q)->paginate(2);

        return PostResource::collection($post);
    }

    public function likePost(Request $request,Post $post)
    {
        $post->like();

        return response()->json(['likesCount' => $post->likes()->count(),'data' => $post]);
    }
}