<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken('user login')->plainTextToken;

        
        
    }

    function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
    }

    function me(Request $request){
        //$user = Auth::user();
        //$post = Post::where('user',$user->id);
        return response()->json(Auth::user());
    }

    public function register(Request $request)
    {
        /*$validated = $request->validate([
            'username' => 'required|unique:posts|max:255',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
        ]);*/

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required',
            'notelepon' => 'required',
        ]);

        if ($validator->fails()) {
            /*return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();*/
            return response()->json([
               'message'=>'Validation Error',
               'errors' => $validator->errors()
                ],422);

        }

        $user = User::create([
            'email'=>$request->email,
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
            'notelepon'=>$request->notelepon,
            'level'=>'2'
            
        ]);

        return response()->json([
            'message'=>'Registrasi Sukses',
            'data' => $user
             ],200);

        
    }


    function getalluser(){
        
        $userall = User::where('level','=',2)->get();
        return response()->json( ['data' => $userall]);


    }

    function updatelevel($id){
        
        //$userUpdate = User::findOrFail($id);
        //$userUpdate->update($request->all());
        $userUpdate= User::where('id', $id)->update(array('level' => '1'));
        return response()->json(['data' => "Sudah Terupdate"]);
    }

    function deleteuser ($id){
        
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['data' => "Akun Berhasil dihapus"]);
    }

    
}
