<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $fillable = [
        'debtor_id',
        'amount',
        'note',
        ];
    public function debtor(){
        return $this->belongsTo("App\Models\Debtor");
    }
}
