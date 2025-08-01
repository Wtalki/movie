<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'user',
            'is_active' => true,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];

        return $this->sendResponse($data, 'User registered successfully');
    }

    /**
     * Login user.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->sendError('Invalid credentials', [], 401);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user->is_active) {
            return $this->sendError('Account is not active', [], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $data = [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ];

        return $this->sendResponse($data, 'User logged in successfully');
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse([], 'User logged out successfully');
    }

    /**
     * Get authenticated user profile.
     */
    public function profile(Request $request)
    {
        return $this->sendResponse($request->user(), 'User profile retrieved successfully');
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $request->user()->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'sometimes|required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendValidationError($validator->errors());
        }

        $user = $request->user();
        $data = $request->only(['name', 'email', 'phone']);

        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return $this->sendResponse($user, 'Profile updated successfully');
    }
}