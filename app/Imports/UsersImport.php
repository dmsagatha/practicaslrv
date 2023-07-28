<?php

namespace App\Imports;

use App\Models\{User, Area};
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\{Importable, SkipsFailures, SkipsErrors, SkipsOnError, SkipsOnFailure, WithUpserts};
use Maatwebsite\Excel\Concerns\{WithHeadingRow, WithBatchInserts, WithChunkReading, WithValidation};

class UsersImport implements ToModel, 
  WithHeadingRow, 
  SkipsOnError,
  SkipsOnFailure,
  WithValidation,
  WithUpserts,
  WithBatchInserts,
  WithChunkReading
{
  use Importable, SkipsErrors, SkipsFailures;

  private $areas;
  
  public function __construct()
  {
    $this->areas = Area::pluck('id', 'acronym');
  }

  public function model(array $row)
  {
    return new User([
      "first_name" => $row['first_name'],
      "last_name"  => $row['last_name'],
      "email"      => $row['email'],
      "password"   => Hash::make($row['password']),
      'area_id'   => $this->areas[$row['area']],
    ]);
  }

  // Nombres de los encabezados del archivo
  public function rules(): array
  {
    return [
      '*.email'      => 'required|email',
      '*.first_name' => 'required',
      '*.last_name'  => 'required',
      '*.area'       => 'required',
      '*.password'   => 'required',
    ];
  }

  // WithUpserts
  public function uniqueBy()
  {
    return 'email';
  }

  public function upsert(bool $keyByField = false): bool
  {
    return true;
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