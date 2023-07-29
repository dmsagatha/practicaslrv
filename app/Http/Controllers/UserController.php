<?php

namespace App\Http\Controllers;

use App\Models\{User, Area};
use App\Http\Requests\UploadFileRequest;
use App\Imports\UsersImport;
use App\Mail\UserMail;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\SimpleExcel\SimpleExcelReader;

class UserController extends Controller
{
  /**
   * Filtros - https://www.laravelia.com/post/dropdown-search-filter-in-laravel-10-tutorial
   * 
   * Laravel Advance Filter | Multiple Filters | whereHas filter using Relatioship | Eloquent Query
   * https://www.youtube.com/watch?v=PBSiQLPQDmQ&ab_channel=CodeOnline
   */
  public function indexFilters(Request $request)
  {
    // FIRST OPTION
    /* $query = User::query()->with('area')->orderBy('last_name');

    if (isset($request->lastName) && $request->lastName !== null) {
      $query->where('last_name', $request->lastName);
    }

    if (isset($request->area) && $request->area !== null) {
      $query->whereHas('area', function($q) use ($request) {
        $q->where('name', $request->area);
      });
    }

    $users = $query->get(); */

    // SECOND OPTION
    $users = User::list();
    
    return view('admin.users.indexFilters', [
      'users'      => $users,
      'areas'      => Area::orderBy('name')->get(),
      'last_names' => User::orderBy('last_name')->pluck('last_name')->unique(),
      'request'    => $request,
    ]);
  }

  public function index()
  {
    // $users = DB::table('users')->select()->get();
    $users = User::orderBy('last_name')->get();

    return view('admin.users.index', compact('users'));
  }

  protected function form($view, User $user)
  {
    return view($view, [
      'user'  => $user,
      'areas' => Area::orderBy('name')->get()
    ]);
  }

  public function create(): Renderable
  {
    return $this->form('admin.users.createUpdate', new User);
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'first_name' => 'required',
      'last_name'  => 'required',
      'email'      => 'required|email|unique:users',
      'password'   => 'required',
      'image'      => 'nullable',
      'area_id'    => 'required|exists:areas,id',
    ]);

    // User::create($request->all());

    $user = new User();
    // dd($request->all());

    $user->first_name = $request['first_name'];
    $user->last_name  = $request['last_name'];
    $user->email      = $request['email'];
    $user->image      = $request['image'];
    $user->password   = Hash::make($request['password']);
    $user->area_id    = $request['area_id'];
    $user->save();

    return to_route('users.filters')->with(['success' => "Registro creado exitosamente."]);
  }

  public function dropzoneStore(Request $request)
  {
    $image = $request->file('image');

    if ($request->hasFile(('image'))) {
      foreach ($image as $images) {
        $imagename = uniqid() . "-" . time() . "." . $images->getClientOriginalExtension();
        // $images->move(public_path('users'), $imagename);
        // $images->move(storage_path('users'), $imagename);
        $images->storeAs('users', $imagename);
      }

      return $imagename;
    }
  }

  public function removefile(Request $request)
  {
    $image = $request['removeimageName'];
    $imagepath=storage_path('dropzone/');
    unlink($imagepath.$request['removeimageName']);

    return $image;
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
  
  /**
   * Importar Usuarios: Si la Area no existe, se crea -> getAreaId()
   */
  public function importUsers(UploadFileRequest $request)
  {
    $arrays = collect(array_map('str_getcsv', file($request->file('upload_file')->getRealPath())));
    
    $headerRow = $arrays->shift();
    
    foreach ($arrays as $array)
    {
      $array = array_combine($headerRow, $array);
      
      User::updateOrCreate(
        ['email' => $array['email']],
        [
          'first_name' => $array['first_name'],
          'last_name'  => $array['last_name'],
          'email'      => $array['email'],
          'password'   => Hash::make($array['password']),
          'area_id' 	 => $this->getAreaId($array['area']),
        ]
      );
    }

    return back()->with(['success' => "Registros importados exitosamente."]);
  }

  public function getAreaId($areaName)
  {
    $area = Area::whereName($areaName)->first();
    
    if ($area) {
      return $area->id;
    }
    
    $area = new Area();
    $area->name = $areaName;
		$area->save();

    return $area->id;
  }

  public function sendMail(Request $request)
  {
    $users = User::whereIn('id', $request->ids)->get();

    if ($users->count() > 0) {
      foreach($users as $key => $value) {
        if (!empty($value->email)) {
          $to = [
            [
              'email' => $value->email, 
              'name'  => $value->first_name,
            ]
          ];
          $details = [
            'subject' => 'Envío de correos masivos',
          ];

          // Mail::to($value->email)->send(new UserMail($details));
          Mail::to($to)->send(new UserMail($details, $value));
        }
      }
    }

    $data = [
      'success' => true
    ];

    return response()->json($data);

    // return response()->json(['Enviados']);
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

  // Importar datos - Laravel Excel
  public function uploadData(UploadFileRequest $request)
  {
    $file = $request->file('upload_file');
    
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
}