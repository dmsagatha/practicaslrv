<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\UploadFileRequest;
use App\Imports\DatosImport;
use Spatie\SimpleExcel\SimpleExcelReader;

class UserController extends Controller
{
  public function datosImport(Request $request)
  {
    $file = $request->file('upload_file');

    // Excel::import(new DatosImport, $file);
    // (new DatosImport)->import($file); // Importable

    // SkipsOnError,  WithValidation, SkipsOnFailure
    $import = new DatosImport;
    $import->import($file);
    // dd($import->errors());

    return back()->with(['success' => "Registros importados exitosamente."]);
  }

  public function simpleExcel(UploadFileRequest $request)
  {
    $file = $request->file('upload_file');

    SimpleExcelReader::create($file, 'xlsx')->getRows()->each(function (array $row) {
      $userData = [
        "first_name" => $row['first_name'],
        "last_name"  => $row['last_name'],
        "email"      => $row["email"],
        "password"   => $row["password"]
      ];

      $checData = User::where("email", "=", $row["email"])->first();

      if (!is_null($checData))
      {
        User::where("email", "=", $row["email"])->update($userData);
      } else {
        User::create($userData);
      }
    });

    return back()->with(['success' => "Registros importados exitosamente."]);
  }

  public function uploadContent(Request $request)
  {
    $data = [];

    // Validación del archivo
    $request->validate([
      "uploaded_file" => "required",
    ]);

    $file = $request->file("uploaded_file");
    $csvData = file_get_contents($file);

    $rows = array_map("str_getcsv", explode("\n", $csvData));
    $header = array_shift($rows);

    foreach ($rows as $row)
    {
      if (isset($row[0]))
      {
        if ($row[0] != "")
        {
          $row = array_combine($header, $row);

          // Datos maestros de usuario
          $userData = [
            "first_name" => $row['first_name'],
            "last_name"  => $row['last_name'],
            "email"      => $row["email"],
            "password"   => $row["password"],
          ];

          // ----------- Comprobar si el correo electrónico ya existe ----------------
          $checData = User::where("email", "=", $row["email"])->first();

          if (!is_null($checData))
          {
            $updateUser = User::where("email", "=", $row["email"])->update($userData);

            if ($updateUser == true)
            {
              $data["status"]  = "failed";
              $data["message"] = "Registros actualizados exitosamente";
            }
          } else {
            $user = User::create($userData);

            if (!is_null($user))
            {
              $data["status"]  = "success";
              $data["message"] = "Registros importados exitosamente";
            }
          }
        }
      }
    }

    return back()->with($data["status"], $data["message"]);
  }

  public function uploadData(UploadFileRequest $request)
  {
    $file = $request->file('upload_file');

    $import = new UsersImport();
    $import->import($file);

    /* if ($import->failures()->isNotEmpty())
    {
      return back()->withFailures($import->failures());
    } */

    return to_route('users.filters')->with(['success' => "Registros importados exitosamente."]);
  }

  public function filters()
  {
    $users = User::orderBy('first_name')->get();

    return view('admin.users.index-filters', compact('users'));
  }

  public function index()
  {
    // $users = DB::table('users')->select()->get();
    $users = User::orderBy('first_name')->get();

    return view('admin.users.index', compact('users'));
  }

  public function search(Request $request)
  {
    $names = $request->input('names');
    $surnames = $request->input('surnames');
    // $other    = $request->input('other');

    $users = DB::table('users')->select()
      ->orWhere('first_name', '=', $names)
      ->orWhere('last_name', '=', $surnames)
    // ->orWhere('email', 'LIKE','%'.$other.'%')
      ->get();

    return view('admin.users.index', compact('users'));
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
        'success' => "Registros eliminados satisfactoriamente.",
      ], 200);
    }
    catch (\Exception$e)
    {
      report($e);
    }
  }
}