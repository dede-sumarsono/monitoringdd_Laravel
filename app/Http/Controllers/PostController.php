<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Post3;
use App\Models\Posts3;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts = Posts3::all();
        //return response()->json( ['data' => $posts]);

        return PostResource::collection($posts);

    }

    public function show($id) {
        $post = Posts3::findOrFail($id);
        //return response()->json( ['data' => $post]);

        return new PostResource($post);
    }
}
