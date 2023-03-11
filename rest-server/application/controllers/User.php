<?php 

class User extends CI_Controller{

    public function index()
    {
      $email =$this->session->userdata('email');
      $profiel = $this->M_user->getProfiel($email);
      $data = [
          'profiel' => $profiel,
          'kunci' => $this->M_user->getKunci($profiel['id_user'])
      ];      
      $this->load->view('template/header');
      $this->load->view('template/sidebar',$data);
      $this->load->view('index');
      $this->load->view('template/footer');
    }

    public function semua()
    {
        $email =$this->session->userdata('email');
        $data = [
          'profiel' => $this->M_user->getProfiel($email),
        ];
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$data);
        $this->load->view('semua');
        $this->load->view('template/footer');
    }
}
?>