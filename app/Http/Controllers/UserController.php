<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
  public function register(Request $request)
  {
      $this->validate($request, [
          'email' => 'required|unique:users|email',
          'username' => 'required|unique:users',
          'password' => 'required',
          'referrer' => 'nullable'
      ]);

      $email = $request->input('email');
      $username = $request->input('username');
      $password = Hash::make($request->input('password'));
      $reff = $request->input ('referrer');
      $referrer = User::where('username', $reff)->first();
      

            if ($reff && !$referrer) {
                return response()->json([
                    'message' => 'Referrer / Username teu kaapalan',
                ], 404);
            }

      $user = User::create([
          'email' => $email,
          'username' => $username,
          'password' => $password,
          'referrer' => $reff
      ]);

      return response()->json(['message' => 'Data sukses di inputkeun!'], 201);
  }
} 