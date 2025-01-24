<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'name',
        'phone',
        'dob',
        'role', 
    ];

}

?>