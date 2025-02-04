<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Crypt;
use App\Imports\UsersImport;


class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'Mobile', 'Role', 'Image', 'Created At'];
    }

    public function map($user): array
    {
        return [
            $user->id,
            Crypt::decryptString($user->name),
            Crypt::decryptString($user->email),
            Crypt::decryptString($user->mobile),
            $user->role,
            $user->image ? asset('storage/' . $user->image) : 'No Image',
            $user->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
