<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\{Importable, SkipsFailures, SkipsErrors, SkipsOnError, SkipsOnFailure, WithUpserts};
use Maatwebsite\Excel\Concerns\{WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation};

class UsersImport implements ToModel, 
  WithHeadingRow, 
  SkipsOnError,
  SkipsOnFailure,
  WithValidation,
  WithUpserts, 
  // WithUpsertColumns,
  WithBatchInserts, 
  WithChunkReading
/* class UsersImport implements ToCollection, 
  WithHeadingRow, 
  SkipsOnError,
  SkipsOnFailure,
  WithValidation,
  WithUpserts, 
  WithBatchInserts, 
  WithChunkReading */
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
    $checkData = User::where("email", "=", $row["email"])->first();

    if (!is_null($checkData))
    {
      User::where("email", "=", $row["email"])->update($userData);
    } else {
      User::create($userData);
    } */
  }

  // ToCollection
  /* public function collection(Collection $rows)
  {
    foreach ($rows as $row)
    {
      User::firstOrCreate(
      // User::updateOrCreate(
        ['email' => $row['email']],
        [
          'email'      => $row['email'],
          'first_name' => $row['first_name'],
          'last_name'  => $row['last_name'],
          'password'   => Hash::make($row['password'])
        ]
      );
    }
  } */
  /* public function collection(Collection $collection)
  {
    $collection->each(function($row) {
      User::query()
          ->updateOrCreate(
            ['email' => $row['email']],
            [
              'email'      => $row['email'],
              'first_name' => $row['first_name'],
              'last_name'  => $row['last_name'],
              'password'   => Hash::make($row['password'])
            ]
          );
    });
  } */

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