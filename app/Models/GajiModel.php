<?php

namespace App\Models;

use CodeIgniter\Model;

class GajiModel extends Model
{
    protected $table      = 'gaji';
    protected $primaryKey = 'id';
    protected $returnType = 'object';

   protected $allowedFields = 
    [
        'karyawanId',
        'bulanGaji',
        'gajiPokok',
        'totalBonus',
        'totalPotongan',
        'totalGaji',
    ];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField  = 'createdAt';
    protected $updatedField  = 'updatedAt';
    protected $deletedField  = 'deletedAT';
}