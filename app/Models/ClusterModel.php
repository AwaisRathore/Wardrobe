<?php

namespace App\Models;

use CodeIgniter\Model;

class ClusterModel extends Model
{
    protected $table = 'clusters';
    protected $allowedFields = ['IsActive'];
    protected $returnType    = \App\Entities\Cluster::class;
    protected $primaryKey = 'Id';
    public function getClusterDataById($clusterId)
    {
        $sql = "SELECT uc.*, u.username, u.email FROM `user_clusters` uc JOIN `clusters` c ON c.Id = uc.ClusterId JOIN `users` u ON uc.UserId = u.Id WHERE uc.ClusterId = $clusterId;";
        return $this->db->query($sql)->getResultObject();
    }
    public function addNewUserToCluster($wardrobeId, $userId, $newClusterId)
    {
        $sql = "INSERT INTO `user_clusters` (`ClusterId`, `UserId`, `WardrobeId`) VALUES ($newClusterId, $userId, $wardrobeId);";
        return $this->db->query($sql);
    }
    public function getClusterArticlesByClusterId($clusterId)
    {
        $articleModel = new ArticleModel();
        $clusterWardrobeIds = array_column($this->db->query("SELECT uc.WardrobeId FROM `user_clusters` uc WHERE uc.ClusterId = $clusterId;")->getResultObject(), 'WardrobeId');
        return $articleModel->whereIn('WardrobeId', $clusterWardrobeIds)->findAll();
    }
    
    public function getClusterIdByWardrobeId($wardrobeId)
    {
        $cluster = $this->db->query("SELECT * FROM `user_clusters` uc WHERE uc.WardrobeId = $wardrobeId;")->getResultObject();
        if (count($cluster) > 0) {
            return $cluster[0]->ClusterId;
        }
        return null;
    }
    public function deleteUserFromCluster($clusterId, $wardrobeId)
    {
        $sql = "DELETE FROM `user_clusters` WHERE `ClusterId` = $clusterId AND `WardrobeId` = $wardrobeId";
        return $this->db->query($sql);
    }
    public function getUserClusterInfo($userId)
    {
        $sql = "SELECT * FROM `user_clusters` uc WHERE uc.UserId = $userId;";
        $userClusterData = $this->db->query($sql)->getRowObject();
        if(!$userClusterData){
            return;
        }
        $data['clusterUsers'] = $this->getClusterDataById($userClusterData->ClusterId);
        $data['clusterArticles'] = $this->getClusterArticlesByClusterId($userClusterData->ClusterId);
        // dd($data);
        return $data;
    }
}
