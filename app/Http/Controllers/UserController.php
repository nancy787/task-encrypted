<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Imports\UsersImport;


class UserController extends Controller
{
    public function create()
    {
        return view('add-user');
    }

    public function store(Request $request)
    {
        $users = json_decode($request->input('users'), true);
        if (empty($users)) {
            // Handle the case where no users are provided
            return redirect()->route('user.create')->with('error', 'No users data provided.');
        }
        
        foreach ($users as $user) {
            User::create([
                'name' => Crypt::encryptString($user['name']),
                'email' => Crypt::encryptString($user['email']),
                'password' => bcrypt($user['password']),
                'mobile' => Crypt::encryptString($user['mobile']),
                'role' => $user['role'],
                'image' => $user['image'] ?? null,
            ]);
        }
        return redirect()->route('user.create')->with('success', 'Users saved successfully!');
    }

    public function exportUsers()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    
    public function importUsers(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);
    
        Excel::import(new UsersImport, $request->file('file'));
    
        return back()->with('success', 'Users imported successfully!');
    }
    
}
