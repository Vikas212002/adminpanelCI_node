<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\CampaignModel;
use mysqli;

class AdminController extends BaseController
{
    protected $user;
    protected $campaign;

    public function __construct()
    {
        $this->user = new AdminModel();
        $this->campaign = new CampaignModel();
    }

    public function index()
    {
        $session = session();

        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        $data['users'] = $this->user->paginate(10);
        $data['pager'] = $this->user->pager; // Add pagination links
        
        session()->remove('filterParams');

        return view('admin/index', $data);
    }

    public function filter()
    {
        $session = session();
      
        // Store filter parameters in session
        $filterParams = [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'dob' => $this->request->getPost('dob'),
            'role' => $this->request->getPost('category'),
        ];
        
        $session->set('filterParams', $filterParams);

        // Default to all users
        $query = $this->user;

        if (!empty($filterParams)) {
            if ($filterParams['name']) {
                $query = $query->like('name', $filterParams['name']);
            }
            if ($filterParams['phone']) {
                $query = $query->like('phone', $filterParams['phone']);
            }
            if ($filterParams['dob']) {
                // Convert the date from 'YYYY-MM-DD' to 'd/m/Y' format
                $dobFormatted = \DateTime::createFromFormat('Y-m-d', $filterParams['dob']);
                if ($dobFormatted) {
                    $query = $query->where('dob', $dobFormatted->format('d/m/Y'));
                }
            }
            if ($filterParams['role']) {
                $query = $query->where('role', $filterParams['role']);
            }
        }

        $data['users'] = $query->paginate(10); // Apply pagination to the filtered results
        $data['pager'] = $this->user->pager; // Add pagination links
        return view('admin/index', $data);
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
            'name' => 'required|min_length[3]',
            'phone' => 'required|numeric',
            'dob' => 'required',
            'role' => 'required'
        ]);

        // Insert data into the database
        $this->user->insert([
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'dob' => $this->request->getPost('dob'),
            'role' => $this->request->getPost('role'),
        ]);

        return redirect()->to('/admin')->with('success', 'User added successfully');
    }

    public function edit($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $user = $this->user->find($id);
        if (!$user) {
            return redirect()->to('/admin')->with('errors', ['User not found.']);
        }

        return view('admin/edit', ['user' => $user]);
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
            'name' => 'required|min_length[3]',
            'phone' => 'required|numeric',
            'dob' => 'required',
            'role' => 'required'
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->to('/admin/index')->withInput()->with('errors', $this->validator->getErrors());
        }

        // Convert DOB to d/m/Y format
        $dob = \DateTime::createFromFormat('d/m/Y', $this->request->getPost('dob'));
        if ($dob) {
            $dobFormatted = $dob->format('d/m/Y');
        } else {
            return redirect()->to('/admin')->withInput()->with('errors', ['dob' => 'The dob field must contain a valid date.']);
        }

        // Update data in the database
        $this->user->update($this->request->getPost('id'), [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'dob' => $dobFormatted,
            'role' => $this->request->getPost('role'),
        ]);

        return redirect()->to('/admin')->with('success', 'User updated successfully');
    }

    public function delete($id)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $this->user->delete($id);
        return redirect()->to('/admin')->with('success', 'User deleted successfully');
    }

    // New method for campaigns
    public function campaigns()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data['campaigns'] = $this->campaign->findAll(); // Retrieve all campaigns
        return view('campaigns/home', $data); // Pass data to the view
    }
}
