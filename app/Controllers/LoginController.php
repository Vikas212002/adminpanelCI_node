<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin/login');
    }

    public function authenticate()
    {
        $session = session();
        $request = \Config\Services::request();

        // Here you would typically check the credentials against a database
        $username = $request->getPost('username');
        $password = $request->getPost('password');

        // For demonstration, let's assume the username is 'admin' and password is 'password'
        if ($username === 'admin' && $password === 'password') {
            $session->set('isLoggedIn', true);
            return redirect()->to('/admin');
        } else {
            $session->setFlashdata('msg', 'Invalid Credentials');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }

    
}