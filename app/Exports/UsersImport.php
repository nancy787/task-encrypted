<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    public function model(array $row)
    {
        return new User([
            'name' => Crypt::encryptString($row[0]),
            'email' => Crypt::encryptString($row[1]),
            'password' => bcrypt($row[2]),
            'mobile' => Crypt::encryptString($row[3]),
            'role' => $row[4],
            'image' => $row[5] ?? null,
        ]);
    }
}
