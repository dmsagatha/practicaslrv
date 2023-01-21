<?php

namespace App\Imports;

use Throwable;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DatosImport implements ToModel, 
  WithHeadingRow, 
  SkipsOnError, 
  WithValidation,
  SkipsOnFailure,
  WithUpserts,
  // WithUpsertColumns,
  WithBatchInserts,
  WithChunkReading
{
  use Importable, SkipsErrors, SkipsFailures;

  public function model(array $row)
  {
    /**
     * Opción 1 - Funciona
     * Laravel Excel y hacer la vericiación en el controldor
     */
    return new User([
      "first_name" => $row['first_name'],
      "last_name"  => $row['last_name'],
      "email"      => $row['email'],
      "password"   => Hash::make($row['password'])
    ]);

    /**
     * Opción 2- Funciona
     * Verificar que si el correo electrónico ya existe, actualizar los datos
     * de lo contrario crearlos
     */
    /* $userData = [
      "first_name" => $row['first_name'],
      "last_name"  => $row['last_name'],
      "email"      => $row["email"],
      "password"   => Hash::make($row['password'])
    ];
    $checData = User::where("email", "=", $row["email"])->first();

    if (!is_null($checData))
    {
      User::where("email", "=", $row["email"])->update($userData);
    } else {
      User::create($userData);
    } */
  }

  public function rules(): array
  {
    return [
      // '*.email'  => ['required', 'email', 'unique:users,email']
      '*.email'  => [
        'required', 'email', 
        // Rule::unique(User::class, 'email')
      ]
    ];
  }

  /* public function onFailure(Failure ...$failure)
  {
  } */

  public function uniqueBy()
  {
    return 'email';
  }

  public function upsert(bool $keyByField = false): bool
  {
    return true;
  }

  /* public function upsertColumns()
  {
    return ['first_name', 'last_name', 'password'];
  } */

  public function batchSize(): int
  {
      return 1000;
  }

  public function chunkSize(): int
  {
      return 1000;
  }
}