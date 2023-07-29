<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\ReCaptcha;

class AuthController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }


  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    return view('home');
  }

  function login()
  {
    Auth::user();
    return redirect('/home');
  }

  public function login_proses(Request $request)
  {
    $input_request = $request->input();
    $validator = Validator::make($input_request, [
      'email'   => 'required|email',
      'password' => 'required|min:5',
      'g-recaptcha-response' => ['required', new ReCaptcha]
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors());
    }

    dd($input_request);
  }

  public function destroy(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
  }
}
