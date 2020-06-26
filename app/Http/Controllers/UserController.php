<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  //
  public function getUserProfile($id)
  {
    $user = User::findOrFail($id);
    print_r($user);
    exit();
  }
  public function getUsers()
  {
    //  echo "inside get users";
    return view('admin.users');
    exit();
  }
  public function getProfile($id)
  {
    $user = User::findOrFail($id);
    return view('admin.profile', ["user" => $user]);
  }
  public function saveProfile(Request $request)
  {
    $admin_profile = User::findOrFail($request->input('id'));
    $admin_profile->name = $request->name;
    $url = $request->file('userImage');
    if (isset($url) && $url != '') {
      $files = $request->file('userImage');
      $folder = 'images/posts/' . Auth::user()->id . '/';
      $filename = time() . $files->getClientOriginalName();
      $path = $request->file('userImage')->storeAs(
        $folder,
        $filename
      );

      $admin_profile->url =  $path;
    }
    $result = $admin_profile->save();
    if ($result == 1) {
      $message = array('message' => 'You have successfully updated Admin-Profile!');
      return json_encode($message);
    }
  }
  public function getPasswordView($id)
  {
    $user = User::findOrFail($id);
    return view('admin.editpassword',["user" => $user]);
  }
  public function savePassword(Request $request)
  {
    //print_r($request->input());
    //exit();
    $user = User::findOrFail($request->input('id'));
    $user->password = Hash::make($request->input('password'));
    $result = $user->save();
    if ($result == 1) {
      $message = array('message' => 'You have successfully updated Admin-Password!');
      return json_encode($message);
    }
  }
}
