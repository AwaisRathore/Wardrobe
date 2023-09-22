<?php

namespace App\Controllers;

use App\Models\WardrobeModel;
use App\Models\ArticleModel;

class Article extends BaseController
{
    private $wardrobeModel = null;
    private $articleModel = null;
    public function __construct()
    {
        $this->wardrobeModel = new WardrobeModel();
        $this->articleModel = new ArticleModel();
    }
    public function index($userid = null)
    {
        $data = [];
        if($userid == null) {

            $data['articles'] = $this->articleModel->getAllUserArticles(current_user()->Id);
        }else{
            $data['articles'] = $this->articleModel->getAllUserArticles($userid);

        }
        return view('Article/index', $data);
    }
    public function new()
    {
        $data = [];
        if ($this->request->getMethod() == "post") {
            $requestData = new \App\Entities\Article($this->request->getPost());
            if ($this->articleModel->insert($requestData)) {
                return redirect()->to('article')->with('success', 'New Article added successfully.');
            } else {
                return redirect()->back()->with('error', 'An error occured.')->withInput()->with('errors', $this->articleModel->errors());
            }
        }
        $data['wardrobes'] = $this->wardrobeModel->where('UserId', current_user()->Id)->findAll();
        if (count($data['wardrobes']) == 0) {
            return redirect()->to('wardrobe/new')->with('error', 'You have not created any wardrobe yet. Please create wardrobe to add articles.');
            
        }
        return view('Article/new', $data);
    }
    public function delete($id)
    {
        if ($this->articleModel->delete($id)) {
            return json_encode(true);
        } else {
            return json_encode(false);
        }
    }
}
