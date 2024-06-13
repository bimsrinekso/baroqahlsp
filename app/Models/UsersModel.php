<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'object';

   protected $allowedFields = 
    [
        'id',
        'username',
        'email',
        'avatar',
        'password',
        'role_id'
    ];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField  = 'createdAt';
    protected $updatedField  = 'updatedAt';
    protected $deletedField  = 'deletedAt';



}