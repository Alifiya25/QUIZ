<?php  
namespace App\Controllers;

use CodeIgniter\Controller;

class Profile extends Controller
{
    public function index()
    {
        // Load the user profile data
        // For example, use the session to get the logged-in user's data
        $session = session();
        $data = [
            'username' => $session->get('username'),
            'email' => $session->get('email'),
        ];

        return view('profile', $data);
    }
}
