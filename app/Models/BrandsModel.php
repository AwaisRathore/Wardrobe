<?php

namespace App\Models;

use CodeIgniter\Model;

class BrandsModel extends Model
{
    protected $table = 'brands';
    protected $allowedFields = ['Name'];
    protected $returnType    = \App\Entities\Brands::class;
    protected $primaryKey = 'Id';
    protected $validationRules    = [
        'Name' => 'required',
    ];
}
