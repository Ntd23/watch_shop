<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
  /**
   * Register api
   * @return \Illuminate\Http\Response
   */
  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email',
      'password' => 'required',
      'c_password' => 'required|same:password',
    ]);
    if ($validator->fails()) {
      return $this->sendError('Validation Error!', $validator->errors());
    }
    $input = $request->all();
    $input['password'] = bcrypt($input['password']);
    $user = User::create($input);
    $success['token'] = $user->createToken('personal access token')->accessToken;
    $success['name'] = $user->name;

    return $this->sendResponse($success, 'User register successfully!');
  }
  public function login(Request $request)
  {
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
      $user = Auth::user();
      $success['token'] =  $user->createToken('personal access token')->accessToken;
      $success['name'] =  $user->name;
      return $this->sendResponse($success, 'User login successfully.');
    } else {
      return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
    }
  }
  public function logout()
  {
    if (Auth::guard('api')->check()) {
      auth()->user()->tokens()->delete();
      return $this->sendResponse('success', 'User login successfully.');
    }
    return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
  }
}
