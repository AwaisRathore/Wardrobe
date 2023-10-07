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
        $clusterWardrobeIds = join(',', array_column($this->db->query("SELECT uc.WardrobeId FROM `user_clusters` uc WHERE uc.ClusterId = $clusterId;")->getResultObject(), 'WardrobeId'));
        $sql = "SELECT a.*, b.Name as BrandName FROM `articles` a JOIN `brands` b ON a.Brand = b.Id WHERE a.WardrobeId in ($clusterWardrobeIds);";
        return $this->db->query($sql)->getResultObject();
        // return $articleModel->whereIn('WardrobeId', )->findAll();
    }
    public function getClusterArticlesByClusterIdExceptWardrobe($clusterId, $cWardrobeId)
    {

        $clusterWardrobeIds = array_column($this->db->query("SELECT uc.WardrobeId FROM `user_clusters` uc WHERE uc.ClusterId = $clusterId;")->getResultObject(), 'WardrobeId');
        if (($key = array_search($cWardrobeId, $clusterWardrobeIds)) !== false) {
            unset($clusterWardrobeIds[$key]);
        }
        $clusterWardrobeIds = join(',', $clusterWardrobeIds);
        $sql = "SELECT a.*, b.Name as BrandName FROM `articles` a JOIN `brands` b ON a.Brand = b.Id WHERE a.WardrobeId in ($clusterWardrobeIds);";
        return $this->db->query($sql)->getResultObject();
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
        $this->checkIfClusterHasNoUsersLeft($clusterId);
    }
    public function checkIfClusterHasNoUsersLeft($clusterId)
    {
        $sql = "SELECT * FROM `user_clusters` uc WHERE uc.ClusterId = $clusterId;";
        $result = $this->db->query($sql)->getResultObject();
        if (count($result) == 0) {
            $sql = "DELETE FROM `user_clusters` WHERE `ClusterId` = $clusterId";
            return $this->db->query($sql);
        }
    }
    public function getUserClusterInfo($userId)
    {
        $sql = "SELECT * FROM `user_clusters` uc WHERE uc.UserId = $userId;";
        $userClusterData = $this->db->query($sql)->getRowObject();
        if (!$userClusterData) {
            return;
        }
        $data['clusterUsers'] = $this->getClusterDataById($userClusterData->ClusterId);
        $data['clusterArticles'] = $this->getClusterArticlesByClusterId($userClusterData->ClusterId);
        // dd($data);
        return $data;
    }
}
