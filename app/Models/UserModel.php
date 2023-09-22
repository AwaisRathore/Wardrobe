<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $allowedFields = ['username', 'email', 'password'];
    protected $returnType    = \App\Entities\User::class;
    protected $beforeInsert = ['hashPassword'];
    protected $primaryKey = 'Id';
    protected $validationRules    = [
        'username' => 'required',

        'email' => 'required|valid_email|is_unique[users.email, Id, {user_id}]',
        'password' => 'required',
    ];
    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required.'
        ],
        'email'  => [
            'required' => 'Email Address is required.',
            'valid_email' => 'Email address is invalid.',
            'is_unique' => 'Sorry. That email has already been taken. Please choose another.',
        ],
        'password' => [
            'required' => 'Password is required.',
            
        ],
    ];

    public function findUserByEmail($email)
    {
        $user = $this->where('email', $email)->first();
        return $user;
    }
    protected function hashPassword(array $data)
    {
        // dd($data);
        if (!isset($data['data']['password'])) {
            return $data;
        }
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        // unset($data['data']['password']);
        return $data;
    }

    public function updatePassword($id, $password)
    {
        $sql = "UPDATE users SET password = '{$password}' WHERE Id = $id";
        $result =  $this->db->query($sql);
        return $result;
    }
    public function setToken($email, $token)
    {
        $sql = "UPDATE users SET `token` = '$token' WHERE `email` = '$email'";
        $result =  $this->db->query($sql);
        return $result;
    }
    public function verifyToken($token)
    {
        $sql = "SELECT * FROM users WHERE `token` = '$token'";
        $result =  $this->db->query($sql)->getRowObject();
        return $result;
    }
}
