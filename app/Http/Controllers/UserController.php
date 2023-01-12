<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Requests\UploadFileRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
  public function uploadData(UploadFileRequest $request)
  {
    $file = $request->file('upload_file');

    $nameFile = rand().$file->getClientOriginalName();
    $file->move('excelImport', $nameFile);

    (new FastExcel)->import(public_path('excelImport/'.$nameFile), function ($line) {
      return User::updateOrCreate(
        ['email' => $line['email']],
        [
          'email'      => $line['email'],
          'first_name' => $line['first_name'],
          'last_name'  => $line['last_name'],
          'password'   => bcrypt($line['claves'])
        ]
      );      
    });

    File::delete(public_path('excel/'.$nameFile));

    return to_route('users.filters');
  }

  public function import(UploadFileRequest $request)
  {
    $file = $request->file('upload_file');

    $file = fopen($request->upload_file->getRealPath(), 'r');

    while ($csvColumn = fgetcsv($file)) {
      // FUNCIONA
      /*User::updateOrCreate(
        ['email' => $csvColumn[1]],
        [
          'first_name' => $csvColumn[0],
          'last_name'  => $csvColumn[1],
          'email'      => $csvColumn[1],
          'password'   => bcrypt($csvColumn[2]),
        ]
      );*/
      // FUNCIONA
      User::upsert(
        [
          'first_name' => $csvColumn[0],
          'last_name'  => $csvColumn[1],
          'email'      => $csvColumn[2],
          'password'   => bcrypt($csvColumn[3]),
        ],
        ['email' => $csvColumn[2]],
      );
    }
    
    fclose($file);

    return to_route('users.filters');
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