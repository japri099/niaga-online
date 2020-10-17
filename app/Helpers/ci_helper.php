<?php 

function akses($email)
{    
    $pModel = new \App\Models\Pengguna_model();
    if(empty($email))
    {
        $data = $pModel->getByEmail($email);
        if($data)
        {
            $uri = service('uri');
            $url = $uri->getSegment(1);
            if($data['level'] === $url)
            {                
                return redirect()->to(base_url('/' . $url));
            }
            else
            {
                return redirect()->to(base_url('/auth/block'));
            }
        }
        else
        {
            session()->destroy();
            return redirect()->to(base_url('/auth'));
        }
    }
    else
    {
        return redirect()->to(base_url('/auth'));
    }
}