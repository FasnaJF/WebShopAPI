<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithBatchInserts, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public function model(array $row)
    {
        return new User([
            'job_title' => $row['job_title'],
            'email' => $row['email_address'],
            'name' => $row['firstname_lastname'],
            'registered_since' => date('Y-m-d H:i:s', strtotime($row['registered_since'])),
            'phone' => $row['phone'],
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function rules(): array
    {
        return [
            'email_address' => 'required|unique:users,email',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'email_address' => 'Email has to be unique and not empty',
        ];
    }
}
