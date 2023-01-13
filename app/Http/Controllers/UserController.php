<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UploadFileRequest;
use Illuminate\Support\Facades\File;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function uploadData(UploadFileRequest $request)
  {
    $file = $request->file('upload_file');
    
    $uploadData = (new FastExcel)->import($file, function ($line) {
      // FUNCIONA
      /* return User::updateOrCreate(
        ['email' => $line['email']],
        [
          'email'      => $line['email'],
          'first_name' => $line['first_name'],
          'last_name'  => $line['last_name'],
          'password'   => bcrypt($line['password'])
        ]
      ); */
      // FUNCIONA
      return User::upsert(
        [
          'first_name' => $line['first_name'],
          'last_name'  => $line['last_name'],
          'email'      => $line['email'],
          'password'   => bcrypt($line['password'])
        ],
        ['email' => $line['email']]
      );
    });

    /* $filename = rand().$file->getClientOriginalName();
    $file->move('excelImport', $filename);

    (new FastExcel)->import(public_path('excelImport/'.$filename), function ($line) {
      // FUNCIONA
      return User::updateOrCreate(
        ['email' => $line['email']],
        [
          'email'      => $line['email'],
          'first_name' => $line['first_name'],
          'last_name'  => $line['last_name'],
          'password'   => bcrypt($line['password'])
        ]
      );
      // FUNCIONA
      return User::upsert(
        [
          'first_name' => $line['first_name'],
          'last_name'  => $line['last_name'],
          'email'      => $line['email'],
          'password'   => bcrypt($line['password'])
        ],
        ['email' => $line['email']]
      );
    });

    File::delete(public_path('excel/'.$filename)); */

    return to_route('users.filters')->with(['success' => "Registros importados exitosamente."]);
  }

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

  public function destroy(User $user)
  {
    $user->delete();

    return to_route('users.filters');
  }

  public function multipleDelete(Request $request)
  {
    $ids = $request->ids;

    try {
      User::whereIn('id', explode(",", $ids))->delete();

      return response()->json([
        'success' => "Registros eliminados satisfactoriamente."
      ],200);
    } catch(\Exception $e) {
      report($e);
    }
  }
}