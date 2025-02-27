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
        'sahirrp',
        'saldoblok',
        'angsmdl',
        'angsmgn',
        'angsttl',
        'tgleff',
        'sertiftrn',
        'termin',
        'tfangs',
        'tfnsbh',
        'sahiratm',
        'rekpend',
        'bank',
        'kdaoh',
        'kdcab',
        'colbaru',
        'tgl',
        'userinput',
        'userupdate',
        'sts'
    ];
}
