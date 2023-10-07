<?php

namespace App\Controllers;

use App\Models\WardrobeModel;
use App\Models\ArticleModel;
use App\Models\ClusterModel;

class Article extends BaseController
{
    private $wardrobeModel = null;
    private $articleModel = null;
    private $clusterModel = null;
    public function __construct()
    {
        $this->wardrobeModel = new WardrobeModel();
        $this->articleModel = new ArticleModel();
        $this->clusterModel = new ClusterModel();
    }
    public function index($userid = null)
    {
        $data = [];
        if ($userid == null) {
            $data['articles'] = $this->articleModel->getAllUserArticles(current_user()->Id);
            $data['clusterInfo'] = $this->clusterModel->getUserClusterInfo(current_user()->Id);
        } else {
            $data['articles'] = $this->articleModel->getAllUserArticles($userid);
            $data['clusterInfo'] = $this->clusterModel->getUserClusterInfo($userid);
        }
        if (isset($data['clusterInfo']['clusterUsers'])) {
            $checkedUserIds = [];

            // Use array_filter to remove duplicates
            $uniqueUsers = array_filter($data['clusterInfo']['clusterUsers'], function ($user) use (&$checkedUserIds) {
                if (in_array($user->UserId, $checkedUserIds)) {
                    return false;
                } else {
                    $checkedUserIds[] = $user->UserId;
                    return true;
                }
            });
            $data['clusterInfo']['clusterUsers'] = $uniqueUsers;
        }
        // dd($data);
        return view('Article/index', $data);
    }
    public function new()
    {
        $data = [];
        if ($this->request->getMethod() == "post") {
            $requestData = new \App\Entities\Article($this->request->getPost());
            if ($this->articleModel->addArticle($requestData)) {
                return redirect()->to('article')->with('success', 'New Article added successfully.');
            } else {
                dd($this->articleModel->errors());
                return redirect()->back()->with('error', 'An error occured.')->withInput()->with('error', $this->articleModel->errors());
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