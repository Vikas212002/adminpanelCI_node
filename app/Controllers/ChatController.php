<?php

namespace App\Controllers;

use App\Models\RegisterModel;

class ChatController extends BaseController
{
    protected $userc;

    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $this->userc = new RegisterModel();
        $data = $this->userc->findAll();

        return view('chat/index', ['data' => $data]);
    }
    
}
