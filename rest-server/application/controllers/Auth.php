<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function alert($key, $pesan)
	{
		if ($key == 'berhasil') {
			return '<div class="alert alert-success d-flex align-items-center" role="alert">
				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
					aria-label="Success:">
					<use xlink:href="#check-circle-fill" /></svg>
				<div>
					' . $pesan . '
				</div>
			</div>';
		} else {
			return '<div class="alert alert-danger d-flex align-items-center" role="alert">
				<svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
					aria-label="Success:">
					<use xlink:href="#check-circle-fill" /></svg>
				<div>
					' . $pesan . '
				</div>
			</div>';
		}
	}

	public function index()
	{
		$this->form_validation->set_rules('email','Email','required|trim');
		$this->form_validation->set_rules('password','Password','required|trim');
		if($this->form_validation->run() == false){
			$this->load->view('auth/index');
		}else{
			$this->_login();
		}
	}

private function _login(){
	$pw = $this->input->post('password');
	$query = $this->M_auth->login();
	if($query){
		if($query['status'] == 1){
			if(password_verify($pw,$query['password'])){
				$data = ['email' => $query['email']];
				$this->session->set_userdata($data);
				redirect(base_url() . 'rest-server/user');
			}else{
				$this->session->set_flashdata('pesan', $this->alert('gagal', 'Gagal,Password salah'));
				redirect(base_url() . 'rest-server/auth');
			}
		}else{
			$this->session->set_flashdata('pesan', $this->alert('gagal', 'Gagal,Email belum diverifikasi'));
			redirect(base_url() . 'rest-server/auth');
		}
	}else{
		$this->session->set_flashdata('pesan', $this->alert('gagal', 'Gagal,Email tidak terdaftar'));
		redirect(base_url() . 'rest-server/auth');
	}
}



	public function registrasi()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[user.email]');
		$this->form_validation->set_rules('pw', 'Password', 'required|trim|min_length[3]');
		$this->form_validation->set_rules('kp', 'Konfirmasi Password', 'required|trim|min_length[3]|matches[pw]');
		if ($this->form_validation->run() == false) {
			$this->load->view('auth/registrasi');
		} else {
			$this->M_auth->register();
			//siapkan token
			$token = base64_encode(random_bytes(32));
			$user_token = [
				'email' => $this->input->post('email', true),
				'token' => $token,
				'date_created' => time(),
			];
			$this->db->insert(
				'user_token',
				$user_token
			);
			$this->_kirimEmail($token);

			$this->session->set_flashdata('pesan', $this->alert('berhasil', 'berhasil,silahkan cek email untuk verifikasi!!'));
			redirect(base_url() . 'rest-server/auth');
		}
	}

	private function _kirimEmail($token)
	{
		// EMAIL GATEWAY // 
		$config = [
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'protocol'  => 'smtp',
			'smtp_host' => 'smtp.gmail.com',
			'smtp_user' => 'belajarcoding185@gmail.com',  // Email gmail 
			'smtp_pass'   => 'yfgibyecqvlftrdj',  // Password gmail 
			'smtp_crypto' => 'ssl',
			'smtp_port'   => 465,
			'crlf'    => "\r\n",
			'newline' => "\r\n"
		];
		// Load library email dan konfigurasinya 
		$this->load->library('email', $config);
		// Email dan nama pengirim 
		$this->email->from('najibi@man2hss.sch.id', 'admin');
		// Email penerima 
		$this->email->to($this->input->post('email')); // Ganti dengan email tujuan 
		// Subject email 
		$this->email->subject('Account Verification');
		// Isi email 
		$pesan = '<!DOCTYPE html>
		 <html>
		 <head>
			 <meta charset="UTF-8">
			 <meta name="viewport" content="width=device-width, initial-scale=1.0">
			 <title>Email Template</title>
			 <style>
				 body {
					 font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
					 font-size: 14px;
					 line-height: 1.4;
					 color: #333333;
					 background-color: #ffffff;
					 padding: 20px;
					 margin: 0;
				 }
				 h1, h2, h3, h4, h5, h6 {
					 color: #000000;
					 line-height: 1.2;
				 }
				 h1 {
					 font-size: 24px;
					 font-weight: bold;
					 margin: 0;
					 padding: 0;
					 text-align: center;
					 margin-bottom: 20px;
				 }
				 p {
					 margin: 0 0 20px;
					 padding: 0;
				 }
				 a {
					 color: #007bff;
					 text-decoration: none;
				 }
				 .container {
					 max-width: 600px;
					 margin: 0 auto;
				 }
			 </style>
		 </head>
		 <body>
			 <div class="container">
				 <h1>Verifikasi Akun REST SERVER</h1>
				 <p>Kepada ' . $this->input->post('email') . '</p>
				 <p>Agar akun anda aktif silakan klik tombol aktif dibawah ini</p>
				 <a href= "' . base_url() . 'rest-server/auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Aktif</a>
			 </div>
		 </body>
		 </html>
		 ';
		$this->email->message($pesan);
		// Tampilkan pesan sukses atau error 
		if ($this->email->send()) {
			// echo 'Sukses! email berhasil dikirim.';
		} else {
			// echo 'Error! email tidak dapat dikirim.';
		}

		// END EMAIL GATEWAY //

	}

	public function verify()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		//validasi email
		$user = $this->db->get_where('user', ['email' => $email])->row_array();
		$idUser = $user['id_user'];
		$this->_createKey($idUser);
		if ($user) {
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			if ($user_token) {
				//cek waktu validasi account
				if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
					$this->db->set('status', 1);
					$this->db->where('email', $email);
					$this->db->update('user');
					$this->db->delete('user_token', ['email' => $email]);
					$this->session->set_flashdata('pesan', $this->alert('berhasil', 'Selamat akun anda sudah aktif,silahkan login!'));
					redirect(base_url() . 'rest-server/auth');
				} else {
					$this->db->delete('user_token', ['email' => $email]);
					$this->db->delete('user', ['email' => $email]);
					$this->session->set_flashdata('pesan', $this->alert('gagal', 'Mohon maaf gagal di verikasi karena token tidak luarsa'));
					redirect(base_url() . 'rest-server/auth');
				}
			} else {
				$this->session->set_flashdata('pesan', $this->alert('gagal', 'Mohon maaf gagal di verikasi karena token salah'));
			}
		} else {
			$this->session->set_flashdata('pesan', $this->alert('gagal', 'Mohon maaf gagal di verikasi karena email salah'));
		}
	}

	private function _createKey($idUser)
	{
		$this->load->helper('string');
		$random_string = random_string('unique', 5);
		$this->M_auth->insertKey($idUser, $random_string);
	}
}
