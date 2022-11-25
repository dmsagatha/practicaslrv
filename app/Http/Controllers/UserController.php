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
    $names = $request->input('names');

    $users = DB::table('users')->select()
      ->where('first_name', '=', $names)
      ->get();
    // dd($users);

    return view('users.index', compact('users'));
  }

  /* public function ajax()
  {
    $users = User::all();
    $first_names = $users->sortBy('first_name')->pluck('first_name')->unique();
    $last_names  = $users->sortBy('last_name')->pluck('last_name')->unique();

    return view('users.ajax', compact('first_names', 'last_names'));
  } */

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