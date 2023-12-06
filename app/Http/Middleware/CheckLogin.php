<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     if(Auth::check() == false)
    //         return redirect()->route('view-login');
    //     return $next($request);
    // }
    public function handle(Request $request, Closure $next, int $permission)
    {
        $userRole = \Auth::user()->role;

        if (in_array($permission, array_keys(User::$roles)) && $userRole >= $permission) {
            return $next($request);
        }

        return response()->json([
            'message' => 'Không có quyền truy cập vào trang này'
        ], Response::HTTP_FORBIDDEN);
    }
}
