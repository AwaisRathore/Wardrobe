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
    // public function addArticle($article)
    // {
    //     //tackle new product added within a cluster 
    //     //
    //     $this->db->transStart();
    //     $clusterModel = new ClusterModel();
    //     $articleModel = new ArticleModel();
    //     $insertedArticleId = $this->insert($article, true);
    //     $insertedArticleWardrobeId = $article->WardrobeId;
    //     $insertedArticleBrandId = $article->Brand;
    //     $insertedArticleSize = $article->Size;
    //     $insertedArticleClusterId = $clusterModel->getClusterIdByWardrobeId($insertedArticleWardrobeId);


    //     if ($insertedArticleClusterId != null) {
    //         $clusterArticles = $clusterModel->getClusterArticlesByClusterId($insertedArticleClusterId);
    //         $clusterArticlesBrands = array_column($clusterArticles, 'Brands');
    //         if (in_array($insertedArticleBrandId, $clusterArticlesBrands)) {
    //             foreach ($clusterArticles as $cArticle) {
    //                 if ($cArticle->Brand == $insertedArticleBrandId) {
    //                     if ($cArticle->Size != $insertedArticleSize) {
    //                         $clusterModel->deleteUserFromCluster($insertedArticleClusterId, $article->WardrobeId);
    //                         break;
    //                     }
    //                 }
    //             }
    //         }
    //         $clusters = $clusterModel->whereNotIn('')->findAll();
    //         $isAddedToACluster = false;
    //         foreach ($clusters as $cluster) {
    //             $clusterInfo = $clusterModel->getClusterDataById($cluster->Id);
    //             $clusterArticles = $clusterModel->getClusterArticlesByClusterId($cluster->Id);
    //             $insertedWardrobeArticles = $articleModel->where('WardrobeId', $insertedArticleWardrobeId)->findAll();
    //             foreach ($clusterArticles as $clsArticle) {
    //                 foreach ($insertedWardrobeArticles as $wArticle) {
    //                     if ($clsArticle->Brand == $wArticle->Brand) {
    //                         if ($clsArticle->Size == $wArticle->Size) {
    //                             $clusterModel->addNewUserToCluster($wArticle->WardrobeId, current_user()->Id, $cluster->Id);
    //                             $isAddedToACluster = true;
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //         if (!$isAddedToACluster) {
    //             $newClusterId =  $clusterModel->insert(['IsActive' => '1'], true);
    //             $clusterModel->addNewUserToCluster($insertedArticleWardrobeId, current_user()->Id, $newClusterId);
    //         }
    //     } else {
    //         $clusters = $clusterModel->where('IsActive', 1)->findAll();
    //         if (count($clusters) > 0) {
    //             $isAddedToACluster = false;
    //             foreach ($clusters as $cluster) {
    //                 $clusterInfo = $clusterModel->getClusterDataById($cluster->Id);
    //                 $clusterArticles = $clusterModel->getClusterArticlesByClusterId($cluster->Id);
    //                 foreach ($clusterArticles as $clsArticle) {
    //                     if ($clsArticle->Brand == $insertedArticleBrandId) {
    //                         if ($clsArticle->Size == $insertedArticleSize) {
    //                             $clusterModel->addNewUserToCluster($insertedArticleWardrobeId, current_user()->Id, $cluster->Id);
    //                             $isAddedToACluster = true;
    //                         }
    //                     }
    //                 }
    //             }
    //             if (!$isAddedToACluster) {
    //                 $newClusterId =  $clusterModel->insert(['IsActive' => '1'], true);
    //                 $clusterModel->addNewUserToCluster($insertedArticleWardrobeId, current_user()->Id, $newClusterId);
    //             }
    //         } else {
    //             $newClusterId =  $clusterModel->insert(['IsActive' => '1'], true);
    //             $clusterModel->addNewUserToCluster($article->WardrobeId, current_user()->Id, $newClusterId);
    //         }
    //     }
    //     $this->db->transComplete();
    //     if ($this->db->transStatus() === false) {
    //         return false;
    //     }
    //     return true;
    // }

    public function addArticle($article)
    {
        $this->db->transStart();

        $clusterModel = new ClusterModel();
        $insertedArticleId = $this->insert($article, true);
        $insertedArticleWardrobeId = $article->WardrobeId;
        $insertedArticleBrandId = $article->Brand;
        $insertedArticleSize = $article->Size;
        $insertedArticleClusterId = $clusterModel->getClusterIdByWardrobeId($insertedArticleWardrobeId);
        if ($insertedArticleClusterId) {
            $this->handleArticleInCluster($article, $insertedArticleClusterId, $clusterModel);
        } else {
            $this->handleArticleNotInCluster($article, $clusterModel);
        }
        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            return false;
        }

        return true;
    }

    private function handleArticleInCluster($article, $insertedArticleClusterId, $clusterModel)
    {
        $clusterBroken = false;
        $this->shouldBreakCluster($article, $insertedArticleClusterId, $clusterModel);
        if ($this->shouldBreakCluster($article, $insertedArticleClusterId, $clusterModel)) {
            $clusterModel->deleteUserFromCluster($insertedArticleClusterId, $article->WardrobeId);
            $clusterBroken = true;
        }
        if ($clusterBroken) {
            $isAddedToACluster =  $this->handlePotentialClusterMerge($article, $clusterModel);
            if (!$isAddedToACluster) {
                $newClusterId = $clusterModel->insert(['IsActive' => '1'], true);
                $clusterModel->addNewUserToCluster($article->WardrobeId, current_user()->Id, $newClusterId);
            }
        }
    }

    private function handleArticleNotInCluster($article, $clusterModel)
    {
        $isAddedToACluster = $this->handlePotentialClusterMerge($article, $clusterModel);
        if (!$isAddedToACluster) {
            $newClusterId = $clusterModel->insert(['IsActive' => '1'], true);
            $clusterModel->addNewUserToCluster($article->WardrobeId, current_user()->Id, $newClusterId);
        }
    }

    private function shouldBreakCluster($article, $insertedArticleClusterId, $clusterModel)
    {
        $clusterArticles = $clusterModel->getClusterArticlesByClusterId($insertedArticleClusterId);
        foreach ($clusterArticles as $cArticle) {
            if ($cArticle->Brand == $article->Brand && $cArticle->Size != $article->Size) {
                return true;
            }
        }
        return false;
    }

    private function handlePotentialClusterMerge($article, $clusterModel)
    {
        $clusters = $clusterModel->where('IsActive', 1)->findAll();
        $isAddedToACluster = false;
        foreach ($clusters as $cluster) {
            $clusterArticles = $clusterModel->getClusterArticlesByClusterId($cluster->Id);
            foreach ($clusterArticles as $clsArticle) {
                if ($clsArticle->WardrobeId != $article->WardrobeId) {
                    if ($clsArticle->Brand == $article->Brand && $clsArticle->Size == $article->Size) {
                        $clusterModel->addNewUserToCluster($article->WardrobeId, current_user()->Id, $cluster->Id);
                        $isAddedToACluster = true;
                        break 2; // Break out of both loops
                    }
                }
            }
        }

        return $isAddedToACluster;
    }
}
