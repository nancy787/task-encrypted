<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'mobile', 'role', 'image'];

    protected $appends = ['decrypted_name', 'decrypted_email', 'decrypted_mobile'];

    public function getDecryptedNameAttribute()
    {
        return \Crypt::decryptString($this->name);
    }

    public function getDecryptedEmailAttribute()
    {
        return \Crypt::decryptString($this->email);
    }

    public function getDecryptedMobileAttribute()
    {
        return \Crypt::decryptString($this->mobile);
    }
}
