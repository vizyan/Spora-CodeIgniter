<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('produk_model');
    }

    private function cekLogin(){
        if($this->session->userdata('login'))
            redirect(site_url());
    }
    private function cekNotLogin(){
        if(!$this->session->userdata('login'))
            redirect(site_url('login'));
    }

    private function cekNotVolunteer(){
        $vol = $this->user_model->getVolunteer();
        if($vol == NULL)
            redirect(site_url('dashboard/now'));
        if($vol->confirmed == 0)
            redirect(site_url('dashboard/now'));
    }

    private function generateAlamat(){
        $alamat = "";
        $n = "1234567890qwertyuiopasdfghjklzxcvbnm";
        for($i=0;$i<12;$i++){
          $alamat .= $n[rand(0, strlen($n) - 1)];
        }
        return 'prj_'.$alamat;
    }

    public function view($page){
        if($page == 'login'){
            $this->cekLogin();

            if($this->input->post('login')){
              $this->actionLogin();
            } else {
              $data['message'] = $this->session->flashdata('msg');
              $this->load->view('login/user', $data);
            }
        } else if($page == 'register'){
            $this->cekLogin();
            if($this->input->post('register')){
              $this->actionRegister();
            } else {
              $data['message'] = $this->session->flashdata('msg');
              $this->load->view('register/user', $data);
            }
        }
        else if($page == 'dashboard'){
            $this->cekNotLogin();
            if($this->input->post('now')){
                $this->now();
            } else if($this->input->post('own')){
                $this->own();
            } else if($this->input->post('addProject')){
                $this->addProject();
            } else {
                $this->now();
            }
        }
        else if($page == 'upload_project'){
            $this->cekNotLogin();
            $confirmed = $this->user_model->getVolunteerConfirm();

            if($confirmed == 1){
                if($this->input->post('upload')){
                    $this->actionUploadProyek();
                }
                else {
                    $data['message'] = $this->session->flashdata('msg');
                    $this->load->view('dashboard/user/upload_project', $data);
                }
            }
            else {
                echo "Akun anda belum terkonfirmasi menjadi volunteer. Harap tunggu hingga Admin mengkonfirmasi, Terima kasih";
            }
        }
        else if($page == 'daftar_volunteer'){
            $this->cekNotLogin();

            $cek = $this->user_model->checkVolunteer();

            if($this->input->post('daftar')){
                if($cek->num_rows() > 0){
                    redirect(site_url('dashboard'));
                }
                else {
                    $this->actionDaftarVol();
                }
            }
            else {
                $data['message'] = $this->session->flashdata('msg');
                $data['content'] = 'dashboard/user/daftar_volunteer';
                $data['alamat']  = $this->user_model->getAlamat();
                $this->load->view('dashboard/user/main', $data);
            }
        }
    }

    private function actionLogin(){
        $cekEmail = $this->user_model->checkEmail($this->input->post('email'));
        if($cekEmail->num_rows() > 0){
            $user = $this->user_model->getUser($this->input->post('email'));
            if(password_verify($this->input->post('password'), $user->password)){
                $data_session = array(
                    'login'  => true,
                    'id_akun'=> $user->id,
                    'email'  => $user->email,
                    'nama'   => $user->nama,
                    'priv'   => $user->priv
                );
                $this->session->set_userdata($data_session);
                redirect(site_url());
            } else {
              $this->session->set_flashdata('msg', '<div class="alert alert-danger">Password salah.</div>');
            }
          } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Email belum terdaftar.</div>');
        }
        redirect(site_url('login'));
      }

    private function actionRegister(){
        $cekEmail = $this->user_model->checkEmail($this->input->post('email'));
        if($cekEmail->num_rows() == 0){
            $this->user_model->addAkun($this->input->post());

            $user = $this->user_model->getUser($this->input->post('email'));

            $this->user_model->addUser($this->input->post(), $user->id);
            redirect(site_url());
        }
        else {
            $this->session->set_flashdata('msg', '<div class="alert alert-info">Email sudah terdaftar. <a href="'. site_url('login') .'">Masuk disini</a></div>');
        }

        redirect(site_url('register'));
    }

    private function actionUploadProyek(){
        $config['upload_path']   = APPPATH.'../uploads/projects/';
        $config['file_name']     = $this->generateAlamat();
        $config['allowed_types'] = 'jpg|png';
        $config['max_size']      = 500;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('foto')){
            $message = '<h4>'. $this->upload->display_errors() .'</h4>';
            $this->session->set_flashdata('msg', $message);
        }
        else{
            $this->load->model('project_model');
            $data = $this->upload->data();
            $this->project_model->addProject($data['file_name']);
            $message = '<p>Proyek berhasil diupload. Kami akan memberitahukan kepada Anda setiap ada perkembangan.</p>';
            $this->session->set_flashdata('msg', $message);
        }

        redirect(site_url('dashboard/upload-project'));
    }

    private function actionDaftarVol(){
        $cek = $this->user_model->checkVolunteerByKTP($this->input->post('no_ktp'));

        if($cek->num_rows() == 0){
            $this->user_model->addVolunteer();
            $this->session->set_flashdata('msg', 'Terima kasih sudah mendaftar, itikad baik Anda sangat kami apresiasi. Silahkan tunggu sampai Admin Spora mengkonfirmasi pendaftaran Anda.');
        }
        else {
            $this->session->set_flashdata('msg', '<h1>No. KTP telah terdaftar sebelumnya.</h1>');
        }

        redirect(site_url('dashboard/daftar-volunteer'));
    }

    public function profile(){
        $this->cekNotLogin();
        $data['volunteer'] = $this->user_model->getVolunteer();
        $data['alamat']    = $this->user_model->getAlamat();

        if($this->input->post('simpan_profil')){
            if($data['volunteer'] == NULL){
                $this->user_model->updateUser();
            }
            else {
                $this->user_model->updateUser();
                $this->user_model->updateVolunteer();
            }

            $this->session->set_userdata(['nama' => $this->input->post('nama')]);
            $this->session->set_flashdata('msg', 'Berhasil menyimpan profil.');
            $this->session->set_flashdata('type', 'success');
            redirect(site_url('profile'));
        }
        else if($this->input->post('simpan_alamat')){
            $this->user_model->updateAlamat();
            $this->session->set_flashdata('msg', 'Berhasil menyimpan alamat.');
            $this->session->set_flashdata('type', 'success');
            redirect(site_url('profile'));
        }
        else if($this->input->post('ubah_pass')){
            $user = $this->user_model->getUser($this->session->userdata('email'));

            if(password_verify($this->input->post('old-password'), $user->password)){
                if($this->input->post('password') == $this->input->post('password2')){
                    if(password_verify($this->input->post('password'), $user->password)){
                        // password lama sama dengan password baru
                        $this->session->set_flashdata('type', 'warning');
                        $this->session->set_flashdata('msg', 'Password sama saja. Password tidak diubah.');
                    }
                    else {
                        $this->user_model->updateUserPass();
                        $this->session->set_flashdata('type', 'success');
                        $this->session->set_flashdata('msg', 'Password berhasil diubah.');
                    }
                }
                else {
                    // password tidak sama
                    $this->session->set_flashdata('type', 'warning');
                    $this->session->set_flashdata('msg', 'Password tidak cocok.');
                }
            }
            else {
                // Password lama salah
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Password salah.');
            }
            
            redirect(site_url('profile'));
        }
        else {
            $data['content'] = 'dashboard/user/profile';
            $data['message'] = $this->session->flashdata('msg');
            $data['type']    = $this->session->flashdata('type');
            $this->load->view('dashboard/user/main', $data);
        }
    }

    public function now(){
        $vol = $this->user_model->getVolunteer();
        if($vol == NULL){
            $data['content'] = 'dashboard/user/bukan_vol';
            $this->load->view('dashboard/user/main', $data);
        }
        else {
            if($vol->confirmed == 0){
                $data['content'] = 'dashboard/user/tunggu_volunteer';
                $this->load->view('dashboard/user/main', $data);
            }
            else {
                if($vol->status == 'D' || $vol->status == 'T'){
                    $vol = $this->user_model->getVolunteer();

                    $data['projects'] = $this->user_model->getProyekByIdVol($vol->id);
                    $data['content'] = 'dashboard/user/dashboard_now';
                    $this->load->view('dashboard/user/main', $data);
                }
                else {
                    $data['content'] = 'dashboard/user/status_lain';
                    $this->load->view('dashboard/user/main', $data);
                }
            }
        }

    }

    public function own(){
        $this->cekNotVolunteer();
        $vol = $this->user_model->getVolunteer();
        if($vol->status == 'D' || $vol->status == 'P'){
            $data['content'] = 'dashboard/user/dashboard_own';
            $this->load->view('dashboard/user/main', $data);
        }
        else {
            $data['content'] = 'dashboard/user/status_lain';
            $this->load->view('dashboard/user/main', $data);
        }
    }

    public function addProject(){
        $this->cekNotVolunteer();
        $vol = $this->user_model->getVolunteer();
        if($vol->status == 'D' || $vol->status == 'P'){
            $data['message'] = $this->session->flashdata('msg');
            $data['content'] = 'dashboard/user/dashboard_add';
            $this->load->view('dashboard/user/main', $data);
        }
        else {
            $data['content'] = 'dashboard/user/status_lain';
            $this->load->view('dashboard/user/main', $data);
        }
    }

    public function shop(){
        $data['produk'] = $this->produk_model->getProduk()->result();
        $data['content'] = 'dashboard/user/shop';
        $this->load->view('dashboard/user/main', $data);
    }

    public function help(){
        $data['content'] = 'dashboard/user/help';
        $this->load->view('dashboard/user/main', $data);
    }

    public function term(){
        $data['content'] = 'dashboard/user/term';
        $this->load->view('dashboard/user/main', $data);
    }//aku harap aku ganteng kaya mas mukhlish

    public function policy(){
        $data['content'] = 'dashboard/user/policy';
        $this->load->view('dashboard/user/main', $data);
    }
}
