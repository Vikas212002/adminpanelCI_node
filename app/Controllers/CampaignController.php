<?php

namespace App\Controllers;

use App\Models\CampaignModel;

class CampaignController extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new CampaignModel();
    }

    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data['campaigns'] = $this->user->paginate(10);
        $data['pager'] = $this->user->pager; // Add pagination links
        return view('campaigns/home', $data);
    }

    public function filter()
    {
        // Handle filtering functionality
        $filterParams = array();
        $filterParams['id'] = $this->request->getPost('id');
        $filterParams['campaign_name'] = $this->request->getPost('campaign_name');
        $filterParams['description'] = $this->request->getPost('description');
        
    
        // Default to all users
        $query = $this->user;
    
        if (!empty($filterParams)) {
            if ($filterParams['id']) {
                $query = $query->where('id', $filterParams['id']);
            }
            if ($filterParams['campaign_name']) {
                $query = $query->where('campaign_name', $filterParams['campaign_name']);
            }
            
            if ($filterParams['description']) {
                $query = $query->where('description', $filterParams['description']);
            }
        }
    
        $data['campaigns'] = $query->paginate(10); // Apply pagination to the filtered results
        $data['pager'] = $this->user->pager; // Add pagination links
        return view('campaigns/home', $data);
    }

    public function addData()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Debugging: Log the incoming data
        log_message('debug', 'Adding new user data: ' . json_encode($this->request->getPost()));

        // Validate form input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'campaign_name' => 'required|min_length[3]',
            'description' => 'required',
            
        ]);

        if (!$this->validate($validation->getRules())) {
            log_message('debug', 'Validation errors: ' . json_encode($this->validator->getErrors()));
            return redirect()->to('/campaigns/home')->withInput()->with('errors', $this->validator->getErrors());
        }

        
        

        // Insert data into the database
        $this->user->insert([
            'campaign_name' => $this->request->getPost('campaign_name'),
            'description' => $this->request->getPost('description'),
            
        ]);

        return redirect()->to('/campaigns/home')->with('success', 'User added successfully');
    }


    public function edit($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $user = $this->user->find($id);
        if (!$user) {
            return redirect()->to('/campaign/home')->with('errors', ['User not found.']);
        }

        return view('campaign/edit', ['user' => $user]);
    }

    public function updateData()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Debugging: Log the incoming data
        log_message('debug', 'Updating user data: ' . json_encode($this->request->getPost()));

        // Validate form input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'campaign_name' => 'required|min_length[3]',
            'description' => 'required',
        ]);

        if (!$this->validate($validation->getRules())) {
            log_message('debug', 'Validation errors: ' . json_encode($this->validator->getErrors()));
            return redirect()->to('/campaigns/home')->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update data in the database
        $this->user->update($this->request->getPost('id'), [
            'campaign_name' => $this->request->getPost('campaign_name'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/campaigns/home')->with('success', 'Campaign updated successfully');
    }

    public function delete($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $this->user->delete($id);
        return redirect()->to('/campaigns/home')->with('success', 'User deleted successfully');
    }

}