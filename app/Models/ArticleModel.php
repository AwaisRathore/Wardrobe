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
        $insertedArticleClusterId = $clusterModel->getClusterIdByWardrobeId($insertedArticleWardrobeId);

        if ($insertedArticleClusterId) {
            $this->handleArticleInCluster($article, $insertedArticleClusterId, $clusterModel);
        } else {
            $this->handleArticleNotInCluster($article, $clusterModel);
        }

        $this->db->transComplete();

        return $this->db->transStatus() !== false;
    }
    private function handleArticleInCluster($article, $insertedArticleClusterId, $clusterModel)
    {
        $conflictWardrobeId = $this->findConflict($article, $insertedArticleClusterId, $clusterModel);
        $wardrobeModel = new WardrobeModel();
        if ($conflictWardrobeId) {
            $conflictUserId = $wardrobeModel->getUserByWardrobeId($conflictWardrobeId);
            $clusterArticles = $clusterModel->getClusterArticlesByClusterIdExceptWardrobe($insertedArticleClusterId, $article->WardrobeId); // Fetch the articles of the cluster except the wardrobe to be removed
            if (!$this->isClusterValid($clusterArticles)) {
                $clusterModel->deleteUserFromCluster($insertedArticleClusterId, $conflictWardrobeId);
                // Attempt to merge the broken wardrobe with existing clusters
                $brokenWardrobeArticles = $this->where('WardrobeId', $conflictWardrobeId)->findAll();
                $merged = false;

                $clusters = $clusterModel->where('IsActive', 1)->findAll();
                foreach ($clusters as $cluster) {
                    if ($this->canMerge($brokenWardrobeArticles, $cluster->Id, $clusterModel)) {
                        $clusterModel->addNewUserToCluster($conflictWardrobeId, $conflictUserId, $cluster->Id);
                        $merged = true;
                        break;
                    }
                }
                // If not merged with any cluster, create a new cluster
                if (!$merged) {
                    $newClusterId = $clusterModel->insert(['IsActive' => '1'], true);
                    $clusterModel->addNewUserToCluster($conflictWardrobeId, $conflictUserId, $newClusterId);
                }
            } else {
                $clusterModel->deleteUserFromCluster($insertedArticleClusterId, $article->WardrobeId);
                $brokenUserId = $wardrobeModel->getUserByWardrobeId($article->WardrobeId);
                // Attempt to merge the broken wardrobe with existing clusters
                $brokenWardrobeArticles = $this->where('WardrobeId', $article->WardrobeId)->findAll();
                $merged = false;

                $clusters = $clusterModel->where('IsActive', 1)->findAll();
                foreach ($clusters as $cluster) {
                    if ($this->canMerge($brokenWardrobeArticles, $cluster->Id, $clusterModel)) {
                        $clusterModel->addNewUserToCluster($article->WardrobeId, $brokenUserId, $cluster->Id);
                        $merged = true;
                        break;
                    }
                }
                // If not merged with any cluster, create a new cluster
                if (!$merged) {
                    $newClusterId = $clusterModel->insert(['IsActive' => '1'], true);
                    $clusterModel->addNewUserToCluster($article->WardrobeId, $brokenUserId, $newClusterId);
                }
            }
        } else {
            // If no conflict, check if this article can cause a merge with another cluster
            $clusters = $clusterModel->where('IsActive', 1)->findAll();
            foreach ($clusters as $cluster) {
                if ($cluster->Id != $insertedArticleClusterId) { // Ensure we're not checking the current cluster
                    $clusterArticles = $clusterModel->getClusterArticlesByClusterId($cluster->Id);
                    foreach ($clusterArticles as $clsArticle) {
                        if ($clsArticle->Brand == $article->Brand && $clsArticle->Size == $article->Size) {
                            // Found a matching article in another cluster
                            // Now, check if the entire cluster can be merged
                            $currentClusterArticles = $clusterModel->getClusterArticlesByClusterId($insertedArticleClusterId);
                            if ($this->canMerge($currentClusterArticles, $cluster->Id, $clusterModel)) {
                                $this->mergeClusters($insertedArticleClusterId, $cluster->Id, $clusterModel);
                                break 2; // Break out of both loops
                            }
                        }
                    }
                }
            }
        }
    }

    private function findConflict($article, $clusterId, $clusterModel)
    {
        $clusterArticles = $clusterModel->getClusterArticlesByClusterId($clusterId);
        foreach ($clusterArticles as $cArticle) {
            if ($cArticle->Brand == $article->Brand && $cArticle->Size != $article->Size) {
                return $cArticle->WardrobeId;
            }
        }
        return null;
    }

    private function handleArticleNotInCluster($article, $clusterModel)
    {
        $clusters = $clusterModel->where('IsActive', 1)->findAll();
        $newClusterArticles = $this->where('WardrobeId', $article->WardrobeId)->findAll(); // Fetch all articles from the new wardrobe

        foreach ($clusters as $cluster) {
            if ($this->canMerge($newClusterArticles, $cluster->Id, $clusterModel)) {
                $clusterModel->addNewUserToCluster($article->WardrobeId, current_user()->Id, $cluster->Id);
                return;
            }
        }

        $newClusterId = $clusterModel->insert(['IsActive' => '1'], true);
        $clusterModel->addNewUserToCluster($article->WardrobeId, current_user()->Id, $newClusterId);
    }


    private function removeWardrobeFromCluster($wardrobeId, $clusterId, $clusterModel)
    {
        $clusterModel->deleteUserFromCluster($clusterId, $wardrobeId);
        return $clusterModel->getClusterArticlesByClusterId($clusterId);
    }
    private function isClusterValid($clusterArticles)
    {
        $wardrobeArticleMap = [];

        // Group articles by their wardrobes
        foreach ($clusterArticles as $article) {
            $wardrobeArticleMap[$article->WardrobeId][] = $article;
        }

        foreach ($wardrobeArticleMap as $wardrobeId => $articles) {
            $hasMatchingArticle = false;

            foreach ($articles as $articleA) {
                foreach ($wardrobeArticleMap as $otherWardrobeId => $otherArticles) {
                    if ($wardrobeId != $otherWardrobeId) { // Ensure we're not checking the same wardrobe
                        foreach ($otherArticles as $articleB) {
                            if ($articleA->Brand == $articleB->Brand && $articleA->Size == $articleB->Size) {
                                $hasMatchingArticle = true;
                                break 3; // Break out of all loops
                            }
                        }
                    }
                }
            }

            if (!$hasMatchingArticle) {
                return false; // Found a wardrobe without a matching article in other wardrobes
            }
        }

        return true; // All wardrobes have at least one matching article with another wardrobe
    }

    private function dfs($wardrobe, $wardrobeMatches, &$visited)
    {
        if (!in_array($wardrobe, $visited)) {
            $visited[] = $wardrobe;
            if (isset($wardrobeMatches[$wardrobe])) { // Ensure there are neighbors to visit
                foreach ($wardrobeMatches[$wardrobe] as $neighbour) {
                    $this->dfs($neighbour, $wardrobeMatches, $visited);
                }
            }
        }
    }
    private function canMerge($newClusterArticles, $existingClusterId, $clusterModel)
    {
        $existingClusterArticles = $clusterModel->getClusterArticlesByClusterId($existingClusterId);
        $hasCommonArticle = false;

        foreach ($newClusterArticles as $newArticle) {
            foreach ($existingClusterArticles as $existingArticle) {
                if ($newArticle->Brand == $existingArticle->Brand) {
                    if ($newArticle->Size != $existingArticle->Size) {
                        return false; // Conflict found
                    } else {
                        $hasCommonArticle = true; // Found a common article
                    }
                }
            }
        }

        return $hasCommonArticle; // Only return true if there's at least one common article
    }


    private function mergeClusters($clusterIdA, $clusterIdB, $clusterModel)
    {
        $articlesFromClusterA = $clusterModel->getClusterArticlesByClusterId($clusterIdA);
        $articlesFromClusterB = $clusterModel->getClusterArticlesByClusterId($clusterIdB);

        // Check for "same brand, different size" conflict before merging
        foreach ($articlesFromClusterA as $articleA) {
            foreach ($articlesFromClusterB as $articleB) {
                if ($articleA->Brand == $articleB->Brand && $articleA->Size != $articleB->Size) {
                    // Conflict found, abort the merge
                    return false;
                }
            }
        }

        // If no conflict, proceed with the merge
        $usersFromClusterB = $clusterModel->getClusterDataById($clusterIdB);

        // Add all users from cluster B to cluster A
        foreach ($usersFromClusterB as $user) {
            $clusterModel->addNewUserToCluster($user->WardrobeId, $user->UserId, $clusterIdA);
            $clusterModel->deleteUserFromCluster($clusterIdB, $user->WardrobeId);
        }

        // Deactivate cluster B (or delete, based on your requirement)
        $clusterModel->update($clusterIdB, ['IsActive' => 0]);

        return true;
    }
}
