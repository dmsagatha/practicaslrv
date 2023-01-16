<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\{Importable, SkipsFailures, SkipsErrors, SkipsOnError, SkipsOnFailure, WithUpserts};
use Maatwebsite\Excel\Concerns\{WithBatchInserts, WithChunkReading, WithHeadingRow, WithValidation};

class DataImport implements ToModel,
  WithHeadingRow, 
  WithBatchInserts, 
  WithChunkReading, 
  SkipsOnError,
  SkipsOnFailure,
  WithUpserts
{
  use Importable, SkipsErrors, SkipsFailures;
  
  public function model(array $row)
  {
    // pleannon@example.com
    return new User([
      'first_name' => $row['first_name'],
      'last_name'  => $row['last_name'],
      'email'      => $row['email'],
      'password'   => Hash::make($row['password'])
    ]);
  }

  /* public function rules(): array
  {
    return [
      // '*.email'  => ['required', 'email', 'unique:users,email']
      '*.email'  => [
        'required', 'email', 
        Rule::unique(User::class, 'email')
      ]
    ];
  } */
  
  public function uniqueBy()
  {
    return 'email';
  }

  public function upsertColumns()
  {
    return ['first_name', 'last_name', 'password'];
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