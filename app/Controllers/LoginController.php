<?php

namespace App\Controllers;

use App\Models\RegisterModel;
use CodeIgniter\Controller;

class LoginController extends Controller
{
    protected $userc;

    public function index()
    {
        return view('admin/login');
    }

    public function authenticate()
    {
        $session = session();
        $request = \Config\Services::request();
        $this->userc = new RegisterModel();

        $username = $request->getPost('username');
        $password = $request->getPost('password');

        $user = $this->userc->where('username', $username)->first();

        if ($user && $password == $user['password']) {
            $session->set([
                'isLoggedIn'=> true,
                'username' => $username,
                'name' => $user['name']
            ]);
            return redirect()->to('/admin');
        } else {
            $session->setFlashdata('msg', 'Invalid Credentials');
            return redirect()->to('/login');
        }
    }

    public function register()
    {
        $this->userc = new RegisterModel();
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required',
            'username' => 'required|is_unique[chatusers.username]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setStatusCode(400)->setJSON([
                'errors' => $validation->getErrors(),
            ]);
        }


        $this->userc->save([
            'name' => $this->request->getPost('name'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
        ]);

        return redirect()->to('/login')->with('success', 'User registered successfully');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}
