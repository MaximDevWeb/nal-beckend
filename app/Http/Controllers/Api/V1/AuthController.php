<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'password_repeat' => 'required|same:password',
            'accept' => 'accepted',
        ]);

        User::create($request->all());

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return response()->json([
                'status' => 'success',
                'token' => $user->createToken('auth')->plainTextToken,
            ]);
        }

        throw ValidationException::withMessages([
            'email' => ['email and password don`t match'],
        ]);
    }

    /**
     * Method for obtaining user data after authorization
     *
     * @return JsonResponse
     */
    public function user(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'user' => User::find(Auth::id()),
        ]);
    }

    /**
     * Method for logout on the site
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json(['status' => 'success']);
    }
}
