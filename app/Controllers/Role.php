<?php

namespace App\Controllers;

use App\Models\RoleModel;

class Role extends BaseController
{
    private $roleModel = null;
    public function __construct()
    {
        $this->roleModel = new RoleModel();
    }
}
