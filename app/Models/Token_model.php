<?php 
namespace App\Models;

use CodeIgniter\Model;

class Token_model extends Model
{
    protected $table = 't_token';
    protected $allowedFields = ['email', 'token'];
    protected $useTimestamps = true;

    public function getToken($email)
    {
        return $this->db->table('t_token')->getWhere(['email' => $email])->getRowArray();
    }

    public function deleteToken($email)
    {
        $this->db->table('t_token')->where('email', $email)->delete();
        return true;
    }
}