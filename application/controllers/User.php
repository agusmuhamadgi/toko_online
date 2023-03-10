<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function index()
    {
        $data['tittle'] = 'TOKO ONLINE';
        $data['aktif'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['barang'] = $this->model_barang->tampil_data()->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }
    public function elektronik()
    {
        $data['tittle'] = 'TOKO ONLINE';
        $data['aktif'] = 'Elektronik';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['elektronik'] = $this->model_kategori->data_elektronik()->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/elektronik', $data);
        $this->load->view('templates/footer');
    }

    public function Pakaian_anak()
    {
        $data['tittle'] = 'TOKO ONLINE';
        $data['aktif'] = 'Pakaian Anak';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['Pakaian_anak'] = $this->model_kategori->data_pakaian_anak()->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/Pakaian_anak', $data);
        $this->load->view('templates/footer');
    }
    public function Pakaian_Pria()
    {
        $data['tittle'] = 'TOKO ONLINE';
        $data['aktif'] = 'Pakaian Pria';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['Pakaian_Pria'] = $this->model_kategori->data_pakaian_pria()->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/Pakaian_Pria', $data);
        $this->load->view('templates/footer');
    }
    public function Pakaian_Wanita()
    {

        $data['tittle'] = 'TOKO ONLINE';
        $data['aktif'] = 'Pakaian Wanita';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['Pakaian_Wanita'] = $this->model_kategori->data_pakaian_wanita()->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/Pakaian_Wanita', $data);
        $this->load->view('templates/footer');
    }
    public function myProfile()
    {
        $data['tittle'] = 'TOKO ONLINE';
        $data['aktif'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/myProfile', $data);
        $this->load->view('templates/footer');
    }

    public function editProfile()
    {
        $data['tittle'] = 'TOKO ONLINE';
        $data['aktif'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/editProfile', $data);
            $this->load->view('templates/footer');
        } else {
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');
            $unggah_image = $_FILES['image'];


            if ($unggah_image) {
                $config['upload_path'] = 'assets/img/profile';
                $config['allowed_types'] = 'jpeg|gif|jpg|png';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {

                    echo $this->upload->display_errors();
                }
            }
            $this->db->set('nama', $nama);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profile berhasil di ubah!!!</div>');
            redirect('user/myProfile');
        }
    }
    public function tambah_keranjang($id)
    {
        $barang = $this->model_barang->find($id);
        $data = array(
            'id'      => $barang->id_barang,
            'qty'     => 1,
            'price'   => $barang->harga,
            'name'    => $barang->nama_barang,
        );

        $this->cart->insert($data);
        redirect('user/index');
    }
    public function detail_keranjang()
    {
        $data['tittle'] = 'TOKO ONLINE';
        $data['aktif'] = '<i class="fas fa-edit"></i>Detail Keranjang';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/keranjang', $data);
        $this->load->view('templates/footer');
    }
    public function hapus_keranjang()
    {
        $this->cart->destroy();
        redirect('user/index');
    }
    public function pembayaran()
    {
        $data['tittle'] = 'TOKO ONLINE';
        $data['aktif'] = '<i class="fas fa-money-check-edit-alt"></i>Pembayaran';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/pembayaran', $data);
        $this->load->view('templates/footer');
    }
    public function proses_pesanan()
    {
        $data['tittle'] = 'TOKO ONLINE';
        $data['aktif'] = '<i class="fas fa-money-check-edit-alt"></i>Proses Pesanan';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $is_processed = $this->model_invoice->invoice();
        if ($is_processed) {

            $this->cart->destroy();
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/proses_pesanan', $data);
            $this->load->view('templates/footer');
        } else {
            echo "Maaf, Pesanan anda gagal diproses!";
        }
    }
    public function detail_produk($id_barang)
    {

        $data['tittle'] = 'TOKO ONLINE';
        $data['aktif'] = 'Details Produk';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['barang'] = $this->model_barang->detail_produk($id_barang);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/detail_produk', $data);
        $this->load->view('templates/footer');
    }
}
