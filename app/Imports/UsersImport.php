<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithUpserts, WithBatchInserts, WithChunkReading, WithValidation
// class UsersImport implements ToCollection, WithHeadingRow
{
  use Importable;

  // ToModel
  public function model(array $row)
  {
    return new User([
      'first_name' => $row['first_name'],
      'last_name'  => $row['last_name'],
      'email'      => $row['email'],
      'password'   => Hash::make($row['password'])
    ]);
  }

  public function rules(): array
  {
    return [
      '*.email'  => ['required', 'email', 'unique:users,email']
    ];
  }

  public function uniqueBy()
  {
    return 'email';
  }
    
  public function batchSize(): int
  {
    return 1000;
  }
    
  public function chunkSize(): int
  {
    return 1000;
  }

  // ToCollection
  /* public function collection(Collection $rows)
  {
    foreach ($rows as $row)
    {
      User::create([
        'email'      => $row['email'],
        'first_name' => $row['first_name'],
        'last_name'  => $row['last_name'],
        'password'   => Hash::make($row['password'])
      ]);
    }
  } */
}