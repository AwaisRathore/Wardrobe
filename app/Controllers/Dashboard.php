<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [];
        
        // dd(session()->has('user_id'));
        return view('Dashboard/index', $data);
    }
}
