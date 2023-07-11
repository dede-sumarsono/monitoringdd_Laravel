<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostDetailResource;
use App\Http\Resources\postStatusResource;
use App\Models\Posts3;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index() {
        $posts = Posts3::all();
        //return response()->json( ['data' => $posts]);

        //return PostResource::collection($posts); tanpa embell"
        //return PostDetailResource::collection($posts); tanpa embell"
        return PostDetailResource::collection($posts->LoadMissing('writer:id,email,username,notelepon,level'));
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

       //return $request->file;

        $validated = $request->validate([
            'id_untuk_user' => 'required',
            'jenis_layanan' => 'required',
            'jenis_pesanan' => 'required',
            'keterangan' => 'required',
        ]);

        ///////////////upload file
        $dokumen = null;
        if ($request->file) {
            $filename = $this->generateRandomString();
            $extension = $request->file->extension();
            $dokumen = $filename.'.'.$extension;
            
            Storage::putFileAs('dokumen',$request->file,$filename.'.'.$dokumen);
        }
        $request['dokumen'] = $dokumen;

        //////////////end upload file
        
        $user = User::where('id', $request->id_untuk_user)->first();


        $request['id_pembuat'] = Auth::user()->id;        
        $request['username_untuk_user'] = $user->username;       
        $request['status'] = 'pendaftar baru';
        $request['status_number'] = 0;
        $post = Posts3::create($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,email,username,notelepon,level'));

    }

    function update(Request $request, $id) {
        $validated = $request->validate([
            'id_untuk_user' => 'required',
            'jenis_layanan' => 'required',
            'jenis_pesanan' => 'required',
            'keterangan' => 'required',
        ]);

        $user = User::where('id', $request->id_untuk_user)->first();       
        $request['username_untuk_user'] = $user->username;       
        $request['status'] = 'pendaftar update';

        $post = Posts3::findOrFail($id);
        $post->update($request->all());

        return new PostDetailResource($post->loadMissing('writer:id,email,username,notelepon,level'));

    }

    function destroy($id) {
        $post = Posts3::findOrFail($id);
        $post->delete();
        return new PostDetailResource($post->loadMissing('writer:id,email,username,notelepon,level'));


    }

    public function userorder($id) {
        //$posts = Posts3::all();
        //return response()->json( ['data' => $posts]);
        $posts = Posts3::where('id_untuk_user','=',$id)->get();
        //return PostResource::collection($posts); tanpa embell"
        //return PostDetailResource::collection($posts); tanpa embell"
        return PostDetailResource::collection($posts->LoadMissing('writer:id,email,username,notelepon,level'));
    }

    public function userordertotal($id) {
        
        
        $posts = Posts3::where('id_untuk_user','=',$id)
                    ->where('status_number','<',5)
                    ->get();
        $postsCount = count($posts);
        return response()->json( ['data' => $postsCount]);
        //return PostDetailResource::collection($posts->LoadMissing('writer:id,email,username,notelepon,level'));
    }

    public function userordertotal2($id) {
        
        
        $posts = Posts3::where('id_untuk_user','=',$id)
                    ->where('status_number','>',4)
                    ->get();
        $postsCount = count($posts);
        return response()->json( ['data' => $postsCount]);
        //return PostDetailResource::collection($posts->LoadMissing('writer:id,email,username,notelepon,level'));
    }

    public function jumlahstatuspesanan() {
        
        
        $posts = Posts3::where('status_number','=',0)->get();
        $posts2 = Posts3::where('status_number','=',1)->get();
        $posts3 = Posts3::where('status_number','=',2)->get();
        $posts4 = Posts3::where('status_number','=',3)->get();
        $posts5 = Posts3::where('status_number','=',4)->get();
        $posts6 = Posts3::where('status_number','=',5)->get();
        $posts7 = Posts3::where('status_number','=',6)->get();
        $posts8 = Posts3::where('status_number','=',7)->get();
        $posts9 = Posts3::where('status_number','=',8)->get();
        $posts10 = Posts3::where('status_number','=',9)->get();
        $posts11 = Posts3::where('status_number','=',10)->get();
        $posts12 = Posts3::where('status_number','=',11)->get();
                    
        $postsCount = count($posts);
        $postsCount2 = count($posts2);
        $postsCount3 = count($posts3);
        $postsCount4 = count($posts4);
        $postsCount5 = count($posts5);
        $postsCount6 = count($posts6);
        $postsCount7 = count($posts7);
        $postsCount8 = count($posts8);
        $postsCount9 = count($posts9);
        $postsCount10 = count($posts10);
        $postsCount11 = count($posts11);
        $postsCount12 = count($posts12);
        

        return response()->json( ['data' => 
        ['Pendaftar Baru'=>$postsCount,
        'Verifikasi Dokumen'=>$postsCount2,
        'Pendaftaran Pajak Oleh Notaris'=>$postsCount3,
        'Pendaftaran Selesai'=>$postsCount4,
        'Proses Real'=>$postsCount5,
        'Proses Pajak'=>$postsCount6,
        'Proses Validasi'=>$postsCount7,
        'Proses Checking'=>$postsCount8,
        'Proses Balik Nama'=>$postsCount9,
        'Proses Peningkatan'=>$postsCount10,
        'Proses HT'=>$postsCount11,
        'Sertifikat Sudah Keluar'=>$postsCount12,
        
        
        ]]);
        
        
        
        //return postStatusResource::collection([$postsCount,$postsCount2]);
        //return postStatusResource::collection($postsCount);
    
    }

    


    










    ////////////////////////Generate random string for upload file
    function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    /////////////////////////End Generate random string
}
