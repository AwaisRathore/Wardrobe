<?php

namespace App\Controllers;

use App\Models\WardrobeModel;
use App\Models\BrandsModel;

class Wardrobe extends BaseController
{
    private $wardrobeModel = null;
    private $brandsModel = null;
    public function __construct()
    {
        $this->wardrobeModel = new WardrobeModel();
        $this->brandsModel = new BrandsModel();
    }
    public function index()
    {
        $data = [];
        $data['wardrobes'] = $this->wardrobeModel->where('UserId', current_user()->Id)->findAll();
        return view('Wardrobe/index', $data);
    }
    public function new()
    {
        $data = [];
        if ($this->request->getMethod() == "post") {
            $requestData = new \App\Entities\Wardrobe($this->request->getPost());
            $requestData->UserId =  current_user()->Id;
            if ($this->wardrobeModel->insert($requestData)) {
                return redirect()->to('wardrobe/index')->with('success', 'New Virtual Wardrobe created successfully.');
            } else {
                return redirect()->back()->with('error', 'An error occured.')->withInput()->with('errors', $this->wardrobeModel->errors());
            }
        }
        return view('Wardrobe/new', $data);
    }
    public function delete($id)
    {
        if ($this->wardrobeModel->delete($id)) {
            return json_encode(true);
        } else {
            return json_encode(false);
        }
    }
    public function search_brands($userid, $brandid)
    {
        $data = [];
        $data['selectedBrand'] = $this->brandsModel->find($brandid);
        $data['clustering'] = $this->wardrobeModel->prepareClustersData($userid, $brandid);
        // $data['selectedWardrobe'] = $this->wardModel->find($brandid);
        // dd($data);
        return view('Wardrobe/clustering', $data);
    }
}
