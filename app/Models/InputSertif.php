<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InputSertif extends Model
{
    use HasFactory;
    protected $fillable = [
        'nokontrak',
        'nama',
        'notab',
        'acdrop',
        'sahir',
        'saldoblok',
        'angsmdl',
        'angsmgn',
        'tgleff',
        'tfangs',
        'tfnsbh',
        'sahiratm',
        'rekpend',
        'bank',
        'kdaoh',
        'userinput'
    ];
}
