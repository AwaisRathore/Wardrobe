<?php

namespace App\Models;

use CodeIgniter\Model;

class WardrobeModel extends Model
{
    protected $table = 'wardrobes';
    protected $allowedFields = ['Title', 'UserId'];
    protected $returnType    = \App\Entities\Wardrobe::class;
    protected $primaryKey = 'Id';
    protected $validationRules    = [
        'Title' => 'required',
        'UserId' => 'required',
    ];
    public function getUserByWardrobeId($wardrobeId)
    {
        return $this->find($wardrobeId)->UserId;
    }
    public function prepareClustersData($userid, $requestedBrand)
    {
        $articleModel = new ArticleModel();
        $all_wardrobes = $this->findAll();
        $user_wardrobes = $this->where(['userid' => $userid])->findAll();
        $userwardrobe_ids = array_column($user_wardrobes, 'Id');
        foreach ($all_wardrobes as $key => $wardrobe) {
            if (!in_array($wardrobe->Id, $userwardrobe_ids)) {
                $wardrobeArticles = $articleModel->getAllArticlesByWardrobeId($wardrobe->Id);
                $wardrobe->Articles = $wardrobeArticles;
            } else {
                unset($all_wardrobes[$key]);
            }
        }
        foreach ($user_wardrobes as $wardrobe) {
            $wardrobeArticles = $articleModel->getAllArticlesByWardrobeId($wardrobe->Id);
            $wardrobe->Articles = $wardrobeArticles;
        }
        foreach ($user_wardrobes as $u_wardrobe) {
            $u_brands = array_column($u_wardrobe->Articles, 'Brand');
            foreach ($all_wardrobes as $wkey => $wardrobe) {
                $wardrobe_brands = array_column($wardrobe->Articles, 'Brand');
                if (in_array($requestedBrand, $wardrobe_brands)) {
                    $matched_brands = array_intersect($u_brands, $wardrobe_brands);
                    // $match_percentage =  (count($matched_brands) / count($u_brands) * 100);
                    $match_percentage =  $this->calculateMatchPercentage($u_wardrobe, $wardrobe, $matched_brands);
                    $wardrobe->MatchPercentage = round($match_percentage, 3);
                    // if ($match_percentage > 0) {
                    //     foreach ($u_wardrobe->Articles as $uArticle) {
                    //         if (in_array($uArticle->Brand, $matched_brands)) {
                    //             $uArticle->Matched = 1;
                    //         } else {
                    //             $uArticle->Matched = 0;
                    //         }
                    //     }
                    //     foreach ($wardrobe->Articles as $wArticle) {
                    //         if (in_array($wArticle->Brand, $matched_brands)) {
                    //             $wArticle->Matched = 1;
                    //         } else {
                    //             $wArticle->Matched = 0;
                    //         }
                    //         // dd($u_brands, $wardrobe_brands, $matched_brands, $match_percentage);
                    //     }
                    // }
                } else {
                    unset($all_wardrobes[$wkey]);
                }
            }
        }
        // dd($all_wardrobes, $user_wardrobes);
        return [
            "all_wardrobes" => $all_wardrobes,
            "user_wardrobes" => $user_wardrobes
        ];
    }
    public function calculateMatchPercentage($u_wardrobe, $wardrobe, $matched_brands)
    {
        $cluster = array();
        foreach ($u_wardrobe->Articles as $key => $u_Article) {
            if (in_array($u_Article->Brand, $matched_brands)) {
                foreach ($wardrobe->Articles as $key => $w_Article) {
                    if ($w_Article->Brand == $u_Article->Brand) {
                        if ($w_Article->Size == $u_Article->Size) {
                            array_push($cluster, 1);
                        } else {
                            array_push($cluster, 0);
                        }
                    }
                }
            }
        }
        $matched =  array_filter($cluster, function ($val) {
            return $val === 1;
        });
        // dd($matched);
        return count($matched) / count($cluster) * 100;
    }
}
