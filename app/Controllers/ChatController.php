<?php

namespace App\Controllers;


class ChatController extends BaseController
{
public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // $data['campaigns'] = $this->user->paginate(10);
        // $data['pager'] = $this->user->pager; // Add pagination links
        return view('chat/index');
    }
}