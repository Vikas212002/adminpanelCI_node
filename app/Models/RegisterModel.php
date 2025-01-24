<?php 

namespace App\Models;
use CodeIgniter\Model;

class RegisterModel extends Model{
    protected $table = 'chatusers';
    protected $primaryKey = 'id';
    protected $allowedFields = [   
        'name',
        'username',
        'password'
    ];

}

?>