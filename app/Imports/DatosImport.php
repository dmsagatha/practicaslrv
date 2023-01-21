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
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DatosImport implements ToModel, 
  WithHeadingRow, 
  SkipsOnError, 
  WithValidation,
  SkipsOnFailure
{
  use Importable, SkipsErrors;

  public function model(array $row)
  {
    return new User([
      "first_name" => $row['first_name'],
      "last_name"  => $row['last_name'],
      "email"      => $row["email"],
      "password"   => Hash::make($row["password"])
    ]);
  }

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

  public function onFailure(Failure ...$failure)
  {
  }
}