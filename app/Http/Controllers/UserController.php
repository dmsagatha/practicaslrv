<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\SimpleExcel\SimpleExcelReader;

class UserController extends Controller
{
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
          $checkUser = User::where("email", "=", $row["email"])->first();

          if (!is_null($checkUser))
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

  public function simpleExcel(Request $request)
  {
    $this->validate($request, [
    'fichier' => 'bail|required|file|mimes:xlsx'
    ]);

    /* $fichier = $request->fichier->move(public_path(), $request->fichier->hashName());
    $reader  = SimpleExcelReader::create($fichier);
    //$rows = $reader->getRows();
    $rows    = $reader->getRows()->filter(function ($ligne) {
    return filter_var($ligne['email'], FILTER_VALIDATE_EMAIL) === true;
    });

    $status = User::insert($rows->toArray());

    if ($status) {
    $reader->close(); // On ferme le $reader
    unlink($fichier);

    return back()->withMsg("Importation réussie !");
    } else { abort(500); } */

    SimpleExcelReader::create($request->fichier, 'xlsx')->getRows()->each(function (array $row) {
      $checkUser = User::where("email", "=", $row["email"])->first();

      if (!is_null($checkUser))
      {
        $updateUser = User::where("email", "=", $row["email"])->update(
          [
            "first_name" => $row['first_name'],
            "last_name"  => $row['last_name'],
            "email"      => $row["email"],
            "password"   => $row["password"],
          ]
        );

        if ($updateUser == true)
        {
          $data["status"]  = "failed";
          $data["message"] = "Registros actualizados exitosamente";
        }
      } else {
        $user = User::create(
          [
            "first_name" => $row['first_name'],
            "last_name"  => $row['last_name'],
            "email"      => $row["email"],
            "password"   => $row["password"],
          ]);

        if (!is_null($user))
        {
          $data["status"]  = "success";
          $data["message"] = "Registros importados exitosamente";
        }
      }
      
      /* if (!User::where('email', $row['email'])->exists()) {
        User::firstOrCreate($row);
      } */
    });

    /* if (!$request->file('fichier'))
    {
      return response()->json('You need to upload an excel file!', 400);
    } */

    // $data = SimpleExcelReader::create($request->file('fichier'), 'csv')->getRows();
    /* SimpleExcelReader::create($request->file('fichier'), 'csv')
      ->getRows()
      ->each(function (array $row)
    {
        // return User::firstWhere('email', $row['email'])->update(
        return User::upsert(
          [
            'email'      => $row['email'],
            'first_name' => $row['first_name'],
            'last_name'  => $row['last_name'],
            'password'   => Hash::make($row['password']),
          ], ['email' => $row['email']]
        );
      }); */
    /* $data->each(function ($row) {
    return User::firstOrCreate(
    ['email' => $row['email']],
    [
    'email'      => $row['email'],
    'first_name' => $row['first_name'],
    'last_name'  => $row['last_name'],
    'password'   => Hash::make($row['password'])
    ]
    );
    }); */

    return back()->withMsg("Importation réussie !");
  }

  public function uploadData(UploadFileRequest $request)
  {
    $file = $request->file('upload_file');

    $import = new UsersImport();
    $import->import($file);

    if ($import->failures()->isNotEmpty())
    {
      return back()->withFailures($import->failures());
    }

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