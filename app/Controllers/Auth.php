<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Auth extends BaseController
{

	protected $pModel;
	protected $tModel;
	protected $email;

	public function __construct()
	{		
		$this->pModel = new \App\Models\Pengguna_model();
		$this->tModel = new \App\Models\Token_model();
		$this->email = \Config\Services::email();		
	}

	public function index()
	{		
		$data = [
			'title' => 'Login | Niaga Online',
			'validation' =>  \Config\Services::validation()
		];

		return view('auth/login', $data);
	}

	public function register()
	{
		$data = [
			'title' => 'Register | Niaga Online',
			'validation' =>  \Config\Services::validation()
		];

		return view('auth/register', $data);
	}

	public function login()
	{
		$val = $this->validate([
			'email' => [
				'rules' => 'required|trim|valid_email',
				'errors' => [
					'required' => 'kolom email tidak boleh kosong',
					'valid_email' => 'email tidak valid'
				]
			],
			'password' => [
				'rules' => 'required|trim|min_length[5]',
				'errors' => [
					'required' => 'password tidak boleh kosong',
					'min_length' => 'password minimal 5 karakter'
				]
			]
		]);

		if(!$val)
		{
			return redirect()->to(base_url())->withInput();
		}

		$email = $this->request->getPost('email');
		$password = $this->request->getPost('password');

		$dataPengguna = $this->pModel->getByEmail($email);

		if($dataPengguna)
		{
			if($dataPengguna['is_active'] == 1)
			{
				if($dataPengguna['password'] == password_verify($password, $dataPengguna['password']))
				{
					$data = [
						'email' => $dataPengguna['email'],
						'level' => $dataPengguna['level']
					];

					session()->set($data);
					if($dataPengguna['level'] == 'admin')
					{
						return redirect()->to(base_url('/admin'));
					}
					else
					{
						return redirect()->to('/pengguna');
					}
				}
				else
				{
					session()->setFlashdata('pesan','
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						Login gagal, <strong>password salah</strong>.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					');
					return redirect()->to(base_url());
				}
			}
			else
			{
				$dToken = $this->tModel->getToken($email);
				$waktuBuat = strtotime($dToken['created_at']);
				$tambah1jam = $waktuBuat + 60 * 60 * 24;
				$now = time();

				if($now < $tambah1jam)
				{
					session()->setFlashdata('pesan','
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						Akun anda belum di aktivasi, <strong>silahkan cek email untuk aktivasi</strong>.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					');
					return redirect()->to(base_url());
				}
				else
				{
					$this->tModel->deleteToken($email);
					$this->pModel->deletePengguna($email);
					session()->setFlashdata('pesan','
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						Akun anda belum teraktivasi lebih dari 1 hari, <strong>Silahkan registrasi lagi</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					');
					return redirect()->to(base_url());
				}

				
			}
		}
		else
		{
			session()->setFlashdata('pesan','
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Login gagal, <strong>Email tidak terdaftar</strong>.
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			');
			return redirect()->to(base_url());
		}
	}

	public function daftar()
	{
		$val = $this->validate(
			[
				'nama' => [
					'rules' => 'required|trim|alpha_space',
					'errors' => [
						'required' => 'kolom {field} tidak boleh kosong',
						'alpha_space' => 'isi kolom {field} dengan huruf saja'
					]
				],
				'email' => [
					'rules' => 'required|valid_email|is_unique[t_pengguna.email]',
					'errors' => [
						'is_unique' =>'{field} sudah terdaftar',
						'valid_email' => '{field} tidak valid'
					]
				],
				'no_telp' => [
					'rules' => 'required|trim|numeric',
					'errors' => [
						'required' => 'Nomor Telepon tidak boleh kosong',
						'numeric' => 'Isi kolom nomor telepon dengan angka saja'
					]
				],
				'password' => [
					'rules' => 'required|min_length[5]',
					'errors' => [
						'required' => 'Password tidak boleh kosong',
						'min_length' => 'Password minimal 5 karakter'
					]
				]
			]
		  );
  
		if(!$val){			
			return redirect()->to(base_url() . '/auth/register')->withInput();
		}
		$data = array(
			  'nama_pengguna' => $this->request->getPost('nama'),
			  'email' => $this->request->getPost('email'),
			  'nomor_telepon' => $this->request->getPost('no_telp'),
			  'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
			  'level' => 'pengguna',
			  'is_active' => 0
		  );
		$token = bin2hex(random_bytes(15));
		$this->sendEmail($token, $data['email']);

		$this->pModel->insert($data);
		$this->tModel->insert(['email' => $data['email'], 'token' => $token]);
		
		session()->setFlashdata('pesan','
		<div class="alert alert-success alert-dismissible fade show" role="alert">
		  	Registrasi berhasil, <strong>Cek email anda untuk aktivasi akun</strong>.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
	  	</div>
		');
		return redirect()->to(base_url());
	}

	public function aktivasi()
	{
		$email = $this->request->getGet('email');
		$token = $this->request->getGet('token');
		
		$dataToken = $this->tModel->getToken($email);

		if($dataToken)
		{
			if($dataToken['token'] == $token)
			{
				$waktuBuat = strtotime($dataToken['created_at']);
				$tambah1jam = $waktuBuat + 60 * 60 * 24;
				$now = time();
				
				if($now < $tambah1jam)
				{
					$this->tModel->deleteToken($email);
					$this->pModel->updateActive($email);
					session()->setFlashdata('pesan','
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						Aktivasi berhasil, <strong>Anda bisa login sekarang</strong>.
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					');
					return redirect()->to(base_url());
				}
				else
				{
					$this->tModel->deleteToken($email);
					$this->pModel->deletePengguna($email);
					session()->setFlashdata('pesan','
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						waktu aktivasi melebihi 1 hari, <strong>silahkan registrasi lagi.</strong> 
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					');
					return redirect()->to(base_url());
				}
			}
			else
			{
				session()->setFlashdata('pesan','
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					Gagal Aktivasi, <strong>Token salah.</strong>
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				');
				return redirect()->to(base_url());
			}
		}
		else
		{
			session()->setFlashdata('pesan','
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Gagal Aktivasi, <strong>Email tidak terdaftar.</strong>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			');
			return redirect()->to(base_url());
		}
	}

	public function block()
	{
		$data = [
			'title' => 'Akses Ditolek'
		];

		return view('auth/block', $data);
	}

	public function logout()
	{		
		session()->destroy();
		return redirect()->to(base_url());
	}

	private function sendEmail($token, $email)
	{
		$pesan = 'Klik <a href="' . base_url('/auth/aktivasi?email=') . $email . '&token=' . $token . '">disini</a> untuk aktivasi akun anda.<br>Note: <strong>Anda mempunyai waktu 1 hari untuk aktivasi akun.</strong>';
		$this->email->setFrom('niagaonline111@gmail.com', 'Niaga Online');
		$this->email->setTo($email);
		$this->email->setSubject('Niaga Online | Aktivasi Akun');
		$this->email->setMessage($pesan);

		if($this->email->send())
		{
			return true;
		}
		else
		{
			echo $this->email->printDebugger();
			die;
		}
	}

	//--------------------------------------------------------------------

}
