<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('siswa_model');
    }
    public function index()
    {
        $data['title'] = 'Siswa';
        $data['siswa'] = $this->siswa_model->get_data('tbl_siswa')->result();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('siswa', $data);
        $this->load->view('templates/footer');
    }

    public function tambah()
    {
        $data['title'] = 'Tambah Siswa';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('tambah_siswa');
        $this->load->view('templates/footer');
    }

    public function tambah_aksi()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            $data = array(
                'nama_siswa' => $this->input->post('nama_siswa'),
                'kelas_siswa' => $this->input->post('kelas_siswa'),
                'alamat_siswa' => $this->input->post('alamat_siswa'),
                'nomor_telepon' => $this->input->post('nomor_telepon'),
            );

            $this->siswa_model->insert_data($data, 'tbl_siswa');
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Data berhasil ditambahkan!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                . '<script>
            setTimeout(function(){
                $(".alert").alert("close");
            }, 2000);
            </script>');
            redirect('siswa');
        }
    }

    public function edit($id_siswa)
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $data = array(
                'id_siswa' => $id_siswa,
                'nama_siswa' => $this->input->post('nama_siswa'),
                'kelas_siswa' => $this->input->post('kelas_siswa'),
                'alamat_siswa' => $this->input->post('alamat_siswa'),
                'nomor_telepon' => $this->input->post('nomor_telepon'),
            );
            $this->siswa_model->update_data($data, 'tbl_siswa');
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            Data berhasil diubah!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
                . '<script>
            setTimeout(function(){
                $(".alert").alert("close");
            }, 2000);
            </script>');
            redirect('siswa');
        }
    }

    public function print()
    {
        $data['siswa'] = $this->siswa_model->get_data('tbl_siswa')->result();
        $this->load->view('print_siswa', $data);
    }

    public function pdf()
    {
        $this->load->library('dompdf_gen');

        $data['siswa'] = $this->siswa_model->get_data('tbl_siswa')->result();
        $this->load->view('laporan_siswa', $data);

        $paper_size = 'A4';
        $orientation = 'potrait';
        $html = $this->output->get_output();
        $this->dompdf->set_paper($paper_size, $orientation);

        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream('laporan_siswa.pdf', array('Attachment' => 0));
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required', array(
            'required' => '%s harus diisi !!'
        ));
        $this->form_validation->set_rules('kelas_siswa', 'Kelas Siswa', 'required', array(
            'required' => '%s harus diisi !!'
        ));
        $this->form_validation->set_rules('alamat_siswa', 'Alamat Siswa', 'required', array(
            'required' => '%s harus diisi !!'
        ));
        $this->form_validation->set_rules('nomor_telepon', 'Nomor Telepon', 'required', array(
            'required' => '%s harus diisi !!'
        ));
    }

    public function delete($id)
    {
        $where = array('id_siswa' => $id);

        $this->siswa_model->delete($where, 'tbl_siswa');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Data berhasil dihapus!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
            . '<script>
            setTimeout(function(){
                $(".alert").alert("close");
            }, 2000);
            </script>');
        redirect('siswa');
    }
}
