<?php namespace App\Controllers;

use CodeIgniter\Controller;
use Config\App;

class Admin extends BaseController
{
    protected $pModel;

    public function __construct()
    {
        $this->pModel = new \App\Models\Pengguna_model();
    }

    public function index()
    {
        $email = session()->get('email');
        $data = [
            'title' => 'Admin | Niaga 11',
            'nama' => $this->pModel->getByEmail($email)
        ];
        echo view('layout/header', $data);
        echo view('admin/dashboard');
        echo view('layout/footer');
    }

    public function pengguna()
    {
        $email = session()->get('email');
        $data = [
            'title' => 'Admin | Niaga 11',
            'nama' => $this->pModel->getByEmail($email),
            'pengguna' => $this->pModel->findAll()
        ];        
        echo view('layout/header', $data);
        echo view('admin/pengguna');
        echo view('layout/footer');
    }

}