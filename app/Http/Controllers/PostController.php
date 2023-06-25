<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailResource;
use App\Models\Posts3;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index() {
        $posts = Posts3::all();
        //return response()->json( ['data' => $posts]);

        //return PostResource::collection($posts); tanpa embell"
        //return PostDetailResource::collection($posts); tanpa embell"
        //return PostDetailResource::collection($posts->LoadMissing('writer:id,email,username,notelepon,level'));
    }

    public function show($id) {
        $post = Posts3::with('writer:id,email,username,notelepon,level')->findOrFail($id);
        //return response()->json( ['data' => $post]);

        //return new PostResource($post);
        return new PostDetailResource($post);
    }

    public function show2($id) {
        $post = Posts3::findOrFail($id);
        return new PostDetailResource($post);
    }

    function store(Request $request) {

        $validated = $request->validate([
            'id_untuk_user' => 'required',
            'jenis_layanan' => 'required',
            'jenis_pesanan' => 'required',
            'keterangan' => 'required',
        ]);
        
        $user = User::where('id', $request->id_untuk_user)->first();


        $request['id_pembuat'] = Auth::user()->id;        
        $request['username_untuk_user'] = $user->username;       
        $request['status'] = 'pendaftar baru';
        $post = Posts3::create($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,email,username,notelepon,level'));

    }

    function update(Request $request, $id) {
        dd('ini method update');
    }
}
