<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Requests\UploadFileRequest;
use App\Imports\UsersImport;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\SimpleExcel\SimpleExcelReader;

class UserController extends Controller
{
  public function filters()
  {
    $users = User::orderBy('last_name')->get();

    return view('admin.users.index-filters', compact('users'));
  }

  public function index()
  {
    // $users = DB::table('users')->select()->get();
    $users = User::orderBy('last_name')->get();

    return view('admin.users.index', compact('users'));
  }

  protected function form($view, User $user)
  {
    return view($view, ['user' => $user]);
  }

  public function create(): Renderable
  {
    return $this->form('admin.users.createUpdate', new User);
  }

  public function store(Request $request)
  {
    if ($request->hasFile('image')) {
      $image     = $request->file('image');
      $file_name = $image->getClientOriginalName();
      $folder    = uniqid('user', true);
      $image->storeAs('users/tmp/' . $folder, $file_name);

      User::create([
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'email'      => $request->email,
        'password'   => Hash::make($request['password']),
        'image'      => $folder . '/' . $file_name
      ]);

      return to_route('users.filters')->with(['success' => "Registro creado exitosamente."]);
    }

    return redirect('/')->with(['danger' => "Por favor cargue la imagen."]);
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

  // Importar datos - Laravel Excel
  public function uploadData(UploadFileRequest $request)
  {
    $file = $request->file('upload_file');

    /**
     * Opción 1 - Funciona
     * Laravel Excel y hacer la vericiación en el controldor
     */

    // Excel::import(new UsersImport, $file);
    // (new UsersImport)->import($file); // Importable

    // SkipsOnError,  WithValidation, SkipsOnFailure
    /* $import = new UsersImport;
    $import->import($file); */
    // dd($import->errors());

    // DESDE AQUÍ
    // SkipsOnError,  WithValidation, SkipsOnFailure, SkipsOnFailure
    // use Importable, SkipsErrors, SkipsFailures;
    /* $import = new UsersImport;
    $import->import($file);

    if ($import->failures()->isNotEmpty()) {
    return back()->withFailures($import->failures());
    }
    // dd($import->failures());

    collect(head($import))->each(function ($row, $key) {
    DB::table('users')
    ->where('email', $row['email'])
    ->update(Arr::except($row, ['email']));
    }); */

    /**
     * Opción 2- Funciona
     * UsersImport => Verificar que si el correo electrónico ya existe,
     * actualizar los datos de lo contrario crearlos
     */
    $import = new UsersImport;
    $import->import($file);

    if ($import->failures()->isNotEmpty())
    {
      return back()->withFailures($import->failures());
    }

    return back()->with(['success' => "Registros importados exitosamente."]);
  }

  // https://github.com/spatie/simple-excel
  public function simpleExcel(UploadFileRequest $request)
  {
    $file = $request->file('upload_file');

    /* SimpleExcelReader::create($file, 'xlsx')->getRows()->each(function (array $row) {
    $userData = [
    "first_name" => $row['first_name'],
    "last_name"  => $row['last_name'],
    "email"      => $row["email"],
    "password"   => Hash::make($row['password'])
    ];

    $checkData = User::where("email", "=", $row["email"])->first();

    if (!is_null($checkData))
    {
    User::where("email", "=", $row["email"])->update($userData);
    } else {
    User::create($userData);
    }
    }); */

    // https://www.csrhymes.com/2021/01/31/testing-a-laravel-console-command.html
    $rows = SimpleExcelReader::create($file, 'xlsx')->getRows();
    $rows->each(function (array $row)
    {
      User::updateOrCreate(
        ['email' => $row['email']],
        [
          'first_name' => $row['first_name'],
          'last_name'  => $row['last_name'],
          'password'   => Hash::make($row['password']),
        ]
      );
      // $this->info("Imported {$row['email']}");
    });

    return back()->with(['success' => "Registros importados exitosamente."]);
  }

  // Importar datos
  public function uploadContent(Request $request)
  {
    $data = [];

    // Validación del archivo
    $request->validate([
      "uploaded_file" => "required",
    ]);

    $file    = $request->file("uploaded_file");
    $csvData = file_get_contents($file);

    $rows   = array_map("str_getcsv", explode("\n", $csvData));
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
          $checkData = User::where("email", "=", $row["email"])->first();

          if (!is_null($checkData))
          {
            $updateUser = User::where("email", "=", $row["email"])->update($userData);

            if ($updateUser == true)
            {
              $data["status"]  = "failed";
              $data["message"] = "Registros actualizados exitosamente";
            }
          }
          else
          {
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
}