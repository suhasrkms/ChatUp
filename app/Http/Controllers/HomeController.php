<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\FirebaseException;
use Session;

class HomeController extends Controller
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
      // FirebaseAuth.getInstance().getCurrentUser();
      try {
        $uid = Session::get('uid');
        $user = app('firebase.auth')->getUser($uid);
        $users = app('firebase.auth')->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
        $msgUser = NULL;
        return view('home',compact('users','uid','msgUser'));
      } catch (\Exception $e) {
        return $e;
      }
    }

    public function update(Request $request, $msgID)
    {
        try {
          $uid = Session::get('uid');
          $user = app('firebase.auth')->getUser($uid);
          $users = app('firebase.auth')->listUsers($defaultMaxResults = 1000, $defaultBatchSize = 1000);
          $msgUser = app('firebase.auth')->getUser($msgID);
          return view('home',compact('users','uid','msgUser'));
        } catch (\Exception $e) {
          return $e;
        }
    }

    public function customer()
    {
      $userid = Session::get('uid');
      return view('customers',compact('userid'));
    }
}
