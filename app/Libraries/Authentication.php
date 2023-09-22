<?php

namespace App\Libraries;

class Authentication
{

    private $user = null;
    private $role = null;
    public function login($email, $password)
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->findUserByEmail($email);
        if ($user === null) {
            return false;
        }
        if (!$user->verifyPassword($password)) {
            return false;
        }
        $session = session();
        $session->regenerate();
        $session->set('user_id', $user->Id);
        $session->set('role_id', $user->RoleId);
        return true;
    }

    public function logout()
    {
        session()->destroy();
    }

    public function getCurrentUser()
    {
        if (!$this->isLoggedIn()) {
            return null;
        }
        if ($this->user === null) {
            $model = new \App\Models\UserModel();
            $this->user = $model->find(session()->get('user_id'));
        }
        return $this->user;
    }

    public function isLoggedIn()
    {
        return session()->has('user_id');
    }
    public function getUserRole()
    {
        if (!$this->isLoggedIn()) {
            return null;
        }
        if ($this->role === null) {
            $model = new \App\Models\RoleModel();
            $this->role = $model->find(session()->get('role_id'));
        }
        return $this->role;
    }
}
