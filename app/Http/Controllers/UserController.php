<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function index()
  {
    // $users = DB::table('users')->select()->get();
    $users = User::orderBy('first_name')->get();

    return view('users.index', compact('users'));
  }
  
  public function search(Request $request)
  {
    $names    = $request->input('names');
    $surnames = $request->input('surnames');
    $other    = $request->input('other');

    $users = DB::table('users')->select()
      ->where('first_name', '=', $names)
      ->orWhere('last_name', '=', $surnames)
      ->orWhere('email', 'LIKE','%'.$other.'%')
      ->get();

    return view('users.index', compact('users'));
  }

  public function create()
  {
  }
  
  public function store(Request $request)
  {
  }
  
  public function show(User $user)
  {
  }
  
  public function edit(User $user)
  {
  }
  
  public function update(Request $request, User $user)
  {
  }
  
  public function destroy(User $user)
  {
  }
}