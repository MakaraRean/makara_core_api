<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debtor extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "address",
        "sex"
    ];
    public function debts(){
        return $this->hasMany("App/Models/Debt");
    }
}
