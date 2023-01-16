<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\{Importable, SkipsFailures, SkipsErrors, SkipsOnError, SkipsOnFailure, ToCollection};
use Maatwebsite\Excel\Concerns\{WithBatchInserts, WithChunkReading, WithHeadingRow, WithValidation};

class UsersImport implements ToModel, 
  WithHeadingRow, 
  WithBatchInserts, 
  WithChunkReading, 
  WithValidation,
  SkipsOnError,
  SkipsOnFailure
/* class UsersImport implements ToCollection, 
    WithHeadingRow, 
    WithBatchInserts, 
    WithChunkReading, 
    WithValidation,
    SkipsOnError,
    SkipsOnFailure */
{
  use Importable, SkipsErrors, SkipsFailures;

  // ToModel
  public function model(array $row)
  {
    /* return new User([
      'first_name' => $row['first_name'],
      'last_name'  => $row['last_name'],
      'email'      => $row['email'],
      'password'   => Hash::make($row['password'])
    ]); */
    $user = User::updateOrCreate(
      ['email' => $row['email']],
      [
        'email'      => $row['email'],
        'first_name' => $row['first_name'],
        'last_name'  => $row['last_name'],
        'password'   => Hash::make($row['password'])
      ]
    );
  }

  // ToCollection
  /* public function collection(Collection $rows)
  {
    foreach ($rows as $row)
    {
      User::updateOrCreate(
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
        Rule::unique(User::class, 'email')
      ]
    ];
  }
    
  public function batchSize(): int
  {
    return 1000;
  }
    
  public function chunkSize(): int
  {
    return 1000;
  }
}