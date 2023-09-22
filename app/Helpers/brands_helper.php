<?php

use App\Models\BrandsModel;

if (!function_exists('get_all_brands')) {
    function get_all_brands()
    {
        $brandModel = new BrandsModel();
        return $brandModel->findAll();
    }
}
