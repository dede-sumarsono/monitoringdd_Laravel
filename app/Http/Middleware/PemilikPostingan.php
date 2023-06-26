<?php

namespace App\Http\Middleware;

use App\Models\Posts3;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PemilikPostingan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUser = Auth::user();
        //$post = Posts3::findOrFail($request->id);
        
        //return response()->json($currentUser);
        
        //if ($post->id_pembuat != $currentUser->id) {
        //    return response()->json(['message' => 'anda bukan admin']);
        //}
        if ($currentUser->level != 1) {
            return response()->json(['message' => 'anda bukan admin']);
        }

        return $next($request);
    }
}
