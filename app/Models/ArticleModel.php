<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table = 'articles';
    protected $allowedFields = ['Brand', 'Model', 'Size', 'WardrobeId'];
    protected $returnType    = \App\Entities\Article::class;
    protected $primaryKey = 'Id';
    protected $validationRules    = [
        'Brand' => 'required',
        'Model' => 'required',
        'Size' => 'required',
        'WardrobeId' => 'required',
    ];
    public function getAllUserArticles($userid)
    {
        $sql = "SELECT a.*, w.Title as Wardrobe, b.Name as Brand FROM `articles` a JOIN `wardrobes` w ON a.WardrobeId = w.Id JOIN `brands` b ON a.Brand = b.Id WHERE w.UserId = $userid;";
        return $this->db->query($sql)->getResultObject();
    }
    public function getAllArticlesByWardrobeId($wardrobeId)
    {
        $sql = "SELECT a.*, b.Name as BrandName FROM `articles` a JOIN `brands` b ON a.Brand = b.Id WHERE a.WardrobeId = $wardrobeId;";
        return $this->db->query($sql)->getResultObject();
    }
}
