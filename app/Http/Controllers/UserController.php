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

    return view('admin.users.index', compact('users'));
  }
  
  public function search(Request $request)
  {
    $names    = $request->input('names');
    $surnames = $request->input('surnames');
    // $other    = $request->input('other');

    $users = DB::table('users')->select()
      ->orWhere('first_name', '=', $names)
      ->orWhere('last_name', '=', $surnames)
      // ->orWhere('email', 'LIKE','%'.$other.'%')
      ->get();

    return view('admin.users.index', compact('users'));
  }

  public function filters()
  {
    $users = User::orderBy('first_name')->get();

    return view('admin.users.index-filters', compact('users'));
  }

  /* public function multipleDelete(Request $request)
  {
    try {
      User::whereIn('id', $request->get('selected'))->delete();

      return response("Registros eliminados satisfactoriamente.", 200);
    } catch(\Exception $e) {
      report($e);
    }
  } */

  public function multipleDelete(Request $request)
  {
    $ids = $request->ids;

    try {
      User::whereIn('id', explode(",", $ids))->delete();

      return response("Registros eliminados satisfactoriamente.", 200);
      /* return response()->json([
        'success' => "Registros eliminados satisfactoriamente."
      ], 200); */
    } catch(\Exception $e) {
      report($e);
    }
  }
}