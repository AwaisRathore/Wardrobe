<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'Id';
    protected $allowedFields = [
        'Role',
    ];
    protected $validationRules    = [
        'Role' => 'required|is_unique[roles.Role]',
    ];
    protected $validationMessages = [
        'Role' => [
            'required' =>  'Role is a required field.',
            'is_unique' => 'Role with this name already exists. Please choose a unique role name.',
        ],
    ];
    protected $returnType    = \App\Entities\Role::class;
}
