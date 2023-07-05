<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'address',
        'website'
    ];

    //function relationship Company to Contacts
    function contacts(){
        return $this->hasMany(Contact::class);
    }
}
