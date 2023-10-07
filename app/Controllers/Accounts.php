<?php

namespace App\Controllers;

use App\Models\UserModel;

class Accounts extends BaseController
{
    private $auth = null;
    private $userModel = null;
    public function __construct()
    {
        $this->auth = service('auth');
        $this->userModel = new UserModel();
    }
    public function index()
    {
        if ($this->request->getMethod() == 'post') {
            $email = $this->request->getPost('Email');
            $password = $this->request->getPost('Password');
            $auth = service('auth');
            if ($auth->login($email, $password)) {
                return redirect()->to("Dashboard");
            } else {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->userModel->errors())
                    ->with('warning', 'Invalid credentials.');
            }
        }
        return view("Accounts/login");
    }
    public function signup()
    {
        if ($this->request->getMethod() == 'post') {
            $user = new \App\Entities\User($this->request->getPost());
            // dd($user);
            $user->RoleId = 2;
            $userModel = new UserModel();
            $insertId = $userModel->insert($user, true);
            if ($insertId) {
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');
                if ($this->auth->login($email, $password)) {
                    return redirect()->to("Dashboard");
                }
            } else {
                return redirect()->back()
                    ->with('errors', $userModel->errors())
                    ->with("warning", "An error occured.")
                    ->withInput();
            }
        }
        return view("Accounts/signup");
    }
    public function logout()
    {
        $auth = service('auth');
        $auth->logout();
        return redirect()->to("Accounts");
    }

    public function forgotPassword()
    {
        $data = [];
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'Email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'This field is required.',
                        'valid_email' => 'Enter a valid email address.'
                    ]
                ],
            ];
            if ($this->validate($rules)) {
                $email = $this->request->getVar('Email', FILTER_SANITIZE_EMAIL);
                $userModel = new UserModel();
                $result = $userModel->findUserByEmail($email);
                if ($result != null) {
                    $token = md5(uniqid($email, true));
                    $result = $userModel->setToken($email, $token);
                    if ($result) {
                        $message = "You have requested to reset your password. Click <a href='" . site_url('accounts/resetPassword/' . $token) . "'>here</a> to reset your password.";
                        $mailService = \Config\Services::email();
                        $mailService->setTo($email);
                        $mailService->setSubject('Password Reset');
                        $mailService->setMessage($message);
                        if ($mailService->send()) {
                            return redirect()->to(current_url())->with('success', 'Password reset link has been sent successfully.');
                        } else {
                            return redirect()->back()->with('errors', 'Failed. Password reset link could not be sent.');
                        }
                    }
                } else {
                    return redirect()->back()->with('errors', 'This email is not registered.');
                }
            } else {
                session()->setFlashdata('error', 'Please fix the errors.');
                $data['validation'] = $this->validator;
            }
        }
        return view('Accounts/forgotpassword', $data);
    }
    public function resetPassword($token = null)
    {
        if (!isset($token)) {
            return redirect()->back()->with('errors', 'Please provide a valid token.');
        }
        $userModel = new UserModel();
        if (!empty($token)) {
            $result = $userModel->verifyToken($token);
            if ($result) {
                $userId = $result->Id;
                if ($this->request->getMethod() == 'post') {
                    $rules = [
                        'Password' => [
                            'label' => 'Password',
                            'rules' => 'required'
                        ],
                        'confirmPassword' => [
                            'label' => 'confirmPassword',
                            'rules' => 'required|matches[Password]'
                        ]

                    ];
                    if ($this->validate($rules)) {
                        $password = $this->request->getVar('Password');
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);
                        $result = $userModel->updatePassword($userId, $password_hash);
                        if ($result) {
                            return redirect()->to('accounts')->with('success', 'Password changed successfuly.');
                        } else {
                            return redirect()->back()->with('errors', 'Password could not be changed.');
                        }
                    } else {
                        return redirect()->back()->with('errors', json_encode($this->validator->listErrors()));
                    }
                }
            } else {
                return redirect()->back()->with('errors', 'Invalid token.');
            }
        } else {
            return redirect()->back()->with('errors', 'Token not found.');
        }
        return view('Accounts/resetpassword');
    }
}
