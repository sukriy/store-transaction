<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin_Model extends CI_Model
{
    public function sign_in()
    {
        $_POST['password']=hash_password($_POST['password']);
        $query = "
			select *
			from account
			where
				username = ".$this->post($_POST['username'])." and
					password = ".$this->post($_POST['password']);
        $query = $this->db->query($query);

        if ($query->num_rows()==1) {
            return $query->result();
        } else {
            return false;
        }
    }


    //ACCOUNT
    public function account()
    {
        $query = "
			select *
			from account
			where id_account<>'a000000000'
		";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function account_load($str)
    {
        $query = "select * from account where id_account<>'a000000000' and id_account = ".$this->post($str);
        $query = $this->db->query($query);
        return $query->result();
    }
    public function account_baru()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $query = "select concat('A',lpad(ifnull(max(mid(id_account,2,length(id_account)-1)),0)+1,9,0)) indeks from log_account";
        $query = $this->db->query($query);
        $row = $query->result();

        if (isset($_FILES) && $_FILES['gambar']['name']!='') {
            $temp = explode('.', htmlspecialchars($_FILES['gambar']['name'], ENT_QUOTES, 'UTF-8'));
            $_FILES['gambar']['name']=$row[0]->indeks.'.'.$temp[1];

            $config['upload_path']          = 'images/account';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2000;

            // $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata('account_modif', '<div class="alert alert-danger text-center">'.$this->upload->display_errors().'</div>');
                return false;
            } else {
                $data = array('upload_data' => $this->upload->data());
                $gambar = $data['upload_data']['file_name'];
            }
        } else {
            $gambar = '';
        }
        $_POST['password']=hash_password($_POST['password']);

        //ACCOUNT
        $query = "
		INSERT INTO `account`(`id_account`, `nama_lengkap`, `username`, `password`, `alamat`, `notlpn`, `npwp`, `email`, `gambar`) VALUES
		(".$this->post($row[0]->indeks).",".$this->post($_POST['nama_lengkap']).",".$this->post($_POST['username']).",
		".$this->post($_POST['password']).",".$this->post($_POST['alamat']).",".$this->post($_POST['notlpn']).",
		".$this->post($_POST['npwp']).",".$this->post($_POST['email']).",".$this->post($gambar).");";
        $query = $this->db->query($query);

        //LOG ACCOUNT
        $query = "
			insert into log_account
			SELECT ".$this->post($tgl).",".$this->post($_SESSION['id_account']).", `id_account`, `nama_lengkap`, `username`, `password`, `alamat`, `notlpn`, `npwp`, `email`, `gambar` FROM `account`
			where id_account=".$this->post($row[0]->indeks).";";
        $query = $this->db->query($query);
        $this->db->trans_complete();
        return true;
    }
    public function account_edit()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        if (isset($_FILES) && $_FILES['gambar']['name']!='') {
            $temp = explode('.', htmlspecialchars($_FILES['gambar']['name'], ENT_QUOTES, 'UTF-8'));
            $_FILES['gambar']['name']=$this->post($_POST['id_account']).'.'.$temp[1];

            $config['upload_path']          = 'images/account';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2000;

            // $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata('account_modif', '<div class="alert alert-danger text-center">'.$this->upload->display_errors().'</div>');
                return false;
            } else {
                $data = array('upload_data' => $this->upload->data());
                $gambar = $data['upload_data']['file_name'];
            }
        } else {
            $gambar = '';
        }

        $query = "select * from account where id_account = ".$this->post($_POST['id_account'])." and password = ".$this->post($_POST['password']);
        $query = $this->db->query($query);
        $baris = $query->num_rows();

        if ($baris!=1) {
            $_POST['password']=hash_password($_POST['password']);
        }

        //ACCOUNT
        if ($gambar=='') {
            $query = "
				UPDATE `account` SET
				`nama_lengkap`=".$this->post($_POST['nama_lengkap']).",`username`=".$this->post($_POST['username']).",`password`=".$this->post($_POST['password']).",
				`alamat`=".$this->post($_POST['alamat']).",`notlpn`=".$this->post($_POST['notlpn']).",`npwp`=".$this->post($_POST['npwp']).",`email`=".$this->post($_POST['email'])."
				WHERE id_account=".$this->post($_POST['id_account'])."
			";
        } else {
            $query = "
				UPDATE `account` SET
				`nama_lengkap`=".$this->post($_POST['nama_lengkap']).",`username`=".$this->post($_POST['username']).",`password`=".$this->post($_POST['password']).",
				`alamat`=".$this->post($_POST['alamat']).",`notlpn`=".$this->post($_POST['notlpn']).",`npwp`=".$this->post($_POST['npwp']).",`email`=".$this->post($_POST['email']).",
				`gambar`=".$this->post($_POST['nama_lengkap'])."
				WHERE id_account=".$this->post($_POST['id_account'])."
			";
        }
        $query = $this->db->query($query);

        //LOG ACCOUNT
        $query = "
			insert into log_account
			SELECT ".$this->post($tgl).",".$this->post($_SESSION['id_account']).", `id_account`, `nama_lengkap`, `username`, `password`, `alamat`, `notlpn`, `npwp`, `email`, `gambar` FROM `account`
			where id_account=".$this->post($_POST['id_account']).";";
        $query = $this->db->query($query);
        $this->db->trans_complete();
        return true;
    }
    public function ajax_account_hapus()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();
        $query = "delete from account where id_account<>'a000000000' and id_account = ".$this->post($_POST['id_account']);
        $query = $this->db->query($query);
        $this->db->trans_complete();
        return true;
    }
    public function check_account_id()
    {
        $query = "select * from account where id_account<>'a000000000' and id_account = ".$this->post($_POST['id_account']);
        $query = $this->db->query($query);
        if ($query->num_rows()==1) {
            return true;
        } else {
            return false;
        }
    }
    public function check_account_double()
    {
        $id_account = (isset($_POST['id_account']) ? $_POST['id_account'] : (isset($_GET['id_account']) ? $_GET['id_account'] : ''));

        if ($id_account=='') {
            $query = "select * from account where username = ".$this->post($_POST['username']);
            $query = $this->db->query($query);
        } else {
            $query = "select * from account where username = ".$this->post($_POST['username'])." and id_account <> ".$this->post($id_account);
            $query = $this->db->query($query);
        }

        $row = $query->num_rows();
        if ($row==0) {
            return true;
        }

        return false;
    }
    public function ajax_email_double()
    {
        $id_account = (isset($_POST['id_account']) ? $_POST['id_account'] : (isset($_GET['id_account']) ? $_GET['id_account'] : ''));

        if ($id_account=='') {
            $query = "select email from account where (email = ".$this->post($_POST['email'].'_1')." or email = ".$this->post($_POST['email']).") and email<>''";
        } else {
            $query = "select email from account where (email = ".$this->post($_POST['email'].'_1')." or email = ".$this->post($_POST['email']).") and email<>'' and id_account<>".$this->post($id_account);
        }

        $query = $this->db->query($query);
        $row = $query->num_rows();
        if ($row==0) {
            return true;
        }

        return false;
    }
    public function ganti_password()
    {
        $query = "
			update account
			set password = ".$this->post(hash_password($_POST['pass_confirmation']))."
			where id_account = ".$this->post($_SESSION['id_account']);
        $query = $this->db->query($query);
        return true;
    }
    public function check_password($str)
    {
        $query = "
			select case when password = ".$this->post(hash_password($str))." then 'true'
			else 'false' end nilai
			from account
			where id_account = ".$this->post($_SESSION['id_account']);
        $query = $this->db->query($query);
        return $query->result();
    }


    //CUSTOM
    public function kategori_list()
    {
        $query = "select * from kategori";
        $query = $this->db->query($query);
        return $query;
    }
    public function ajax_custom()
    {
        $query = "
		select kategori.nama_kategori, custom.*
		from custom
		left join kategori on kategori.id_kategori = custom.id_kategori
		where custom.id_kategori = ".$this->post($_POST['id_kategori']);
        $query = $this->db->query($query);
        $baris = $query->num_rows();

        if ($baris==0) {
            $array = array();
        } else {
            foreach ($query->result() as $row) {
                $newdata =  array(
                    'nama_kategori' => cetak($row->nama_kategori),
                    'id_kategori' => cetak($row->id_kategori),
                    'id_custom' => cetak($row->id_custom),
                    'opsi' => cetak($row->opsi),
                    'keterangan' => cetak($row->keterangan)
                );
                $array[] = $newdata;
            }
        }

        return $array;
    }
    public function ajax_custom_hapus()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        $query = "
		delete from custom
		where id_kategori = ".$this->post($_POST['id_kategori'])." and id_custom = ".$this->post($_POST['id_custom']);
        $query = $this->db->query($query);

        $this->db->trans_complete();
        return true;
    }
    public function custom_baru()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $query = "select concat('C',lpad(ifnull(max(mid(id_custom,2,length(id_custom)-1)),0)+1,9,0)) indeks from log_custom where id_kategori = ".$this->post($_POST['id_kategori']);
        $query = $this->db->query($query);
        $row = $query->result();

        $query = "
			INSERT INTO `custom`(`id_kategori`, `id_custom`, `opsi`, `keterangan`) VALUES
			(".$this->post($_POST['id_kategori']).",".$this->post($row[0]->indeks).",".$this->post($_POST['opsi']).",".$this->post($_POST['keterangan']).")";
        $query = $this->db->query($query);

        //LOG CUSTOM
        $query = "
			insert into log_custom
			SELECT ".$this->post($tgl).",".$this->post($_SESSION['id_account']).", `id_kategori`, `id_custom`, `opsi`, `keterangan` FROM `custom`
			where id_kategori=".$this->post($_POST['id_kategori'])." and id_custom=".$this->post($row[0]->indeks).";";
        $query = $this->db->query($query);
        $this->db->trans_complete();
        return true;
    }
    public function custom_detail($id_kategori, $id_custom)
    {
        $query = "
			select *
			from custom
			where id_kategori = ".$this->post($id_kategori)." and id_custom = ".$this->post($id_custom)."
		";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function custom_edit()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $query = "
			update custom
			set opsi = ".$this->post($_POST['opsi']).", keterangan = ".$this->post($_POST['keterangan'])."
			where id_kategori = ".$this->post($_POST['id_kategori'])." and id_custom = ".$this->post($_POST['id_custom']);
        $query = $this->db->query($query);

        //LOG CUSTOM
        $query = "
			insert into log_custom
			SELECT ".$this->post($tgl).",".$this->post($_SESSION['id_account']).", `id_kategori`, `id_custom`, `opsi`, `keterangan` FROM `custom`
			where id_kategori = ".$this->post($_POST['id_kategori'])." and id_custom = ".$this->post($_POST['id_custom']);
        $query = $this->db->query($query);
        $this->db->trans_complete();
        return true;
    }
    public function check_custom_modif()
    {
        $id_kategori = (isset($_POST['id_kategori']) ? $_POST['id_kategori'] : (isset($_GET['id']) ? $_GET['id'] : ''));
        $id_custom = (isset($_POST['id_custom']) ? $_POST['id_custom'] : (isset($_GET['id_custom']) ? $_GET['id_custom'] : ''));

        $query = "select id_kategori from kategori where id_kategori = ".$this->post($_POST['id_kategori']);
        $query = $this->db->query($query);

        $row = $query->num_rows();
        if ($row==0) {
            return false;
        }

        return true;
    }
    public function check_custom_double()
    {
        $id_kategori = (isset($_POST['id_kategori']) ? $_POST['id_kategori'] : (isset($_GET['id']) ? $_GET['id'] : ''));
        $id_custom = (isset($_POST['id_custom']) ? $_POST['id_custom'] : (isset($_GET['id_custom']) ? $_GET['id_custom'] : ''));

        if ($id_custom=='') {
            $query = "select opsi from custom where id_kategori = ".$this->post($_POST['id_kategori'])." and opsi = ".$this->post($_POST['opsi']);
        } else {
            $query = "select opsi from custom where id_kategori = ".$this->post($id_kategori)." and opsi = ".$this->post($_POST['opsi'])." and id_custom <> ".$this->post($id_custom);
        }
        $query = $this->db->query($query);
        $row = $query->num_rows();
        if ($row>0) {
            return false;
        }

        return true;
    }


    //ITEM
    public function search_blog($title)
    {
        $title = '%'.$title.'%';
        $query = "
			select *
			from item
			where nama like ".$this->post($title)."
			order by nama asc
			limit 10
		";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function item()
    {
        $query = "select * from item";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function list_group()
    {
        $query = "select * from custom where id_kategori = ? ";
        $query = $this->db->query($query, array('K0001'));
        return $query;
    }
    public function list_satuan()
    {
        $query = "select * from custom where id_kategori = ? ";
        $query = $this->db->query($query, array('K0004'));
        return $query;
    }
    public function check_satuan($str)
    {
        $query = "select * from custom where id_kategori = ".$this->post('K0004')." and opsi = ".$this->post($str);
        $query = $this->db->query($query);
        $row = $query->num_rows();
        if ($row==1) {
            return true;
        }

        return false;
    }
    public function item_baru()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $query = "select concat('I',lpad(ifnull(max(mid(id_item,2,length(id_item)-1)),0)+1,9,0)) indeks from log_item";
        $query = $this->db->query($query);
        $row = $query->result();

        if (isset($_FILES) && $_FILES['gambar']['name']!='') {
            $temp = explode('.', htmlspecialchars($_FILES['gambar']['name'], ENT_QUOTES, 'UTF-8'));
            $_FILES['gambar']['name']=$row[0]->indeks.'.'.$temp[1];

            $config['upload_path']          = 'images/item';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2000;

            // $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata('item_modif', '<div class="alert alert-danger text-center">'.$this->upload->display_errors().'</div>');
                return false;
            } else {
                $data = array('upload_data' => $this->upload->data());
                $gambar = $data['upload_data']['file_name'];
            }
        } else {
            $gambar = '';
        }
        $group = '';
        if (isset($_POST['group'])) {
            $group = implode(", ", $_POST['group']);
        }
        $query = "
		INSERT INTO `item`(`id_item`, `nama`, `harga_beli`, `diskon`, `satuan`, `group`, `keterangan`, `gambar`) VALUES
		(".$this->post($row[0]->indeks).",".$this->post($_POST['nama']).",".$this->post(str_replace(",", "", $_POST['harga_beli'])).",".
        $this->post(cetak0($_POST['diskon'])).",".$this->post($_POST['satuan']).",".$this->post($group).",".$this->post($_POST['keterangan']).",".$this->post($gambar).")";
        $query = $this->db->query($query);

        $query = "
			insert into log_item
			SELECT ".$this->post($tgl).",".$this->post($_SESSION['id_account']).", `id_item`, `nama`, `harga_beli`, `diskon`, `satuan`, `group`, `keterangan`, `gambar` FROM `item`
			where id_item=".$this->post($row[0]->indeks).";";
        $query = $this->db->query($query);
        $this->db->trans_complete();
        return true;
    }
    public function item_edit()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");
        if (isset($_FILES) && $_FILES['gambar']['name']!='') {
            $temp = explode('.', htmlspecialchars($_FILES['gambar']['name'], ENT_QUOTES, 'UTF-8'));
            $_FILES['gambar']['name']=$this->post($_POST['id_item']).'.'.$temp[1];
            $config['upload_path']          = 'images/item';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2000;

            // $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata('item_modif', '<div class="alert alert-danger text-center">'.$this->upload->display_errors().'</div>');
                return false;
            } else {
                $data = array('upload_data' => $this->upload->data());
                $gambar = $data['upload_data']['file_name'];
            }
        } else {
            $gambar = '';
        }

        $group = '';
        if (isset($_POST['group'])) {
            $group = implode(", ", $_POST['group']);
        }
        if ($gambar == '') {
            $query = "
				UPDATE `item` SET `nama`=".$this->post($_POST['nama']).",`harga_beli`=".$this->post(str_replace(",", "", $_POST['harga_beli'])).",`diskon`=".$this->post(cetak0($_POST['diskon'])).",
				`satuan`=".$this->post($_POST['satuan']).",`group`=".$this->post($group).",`keterangan`=".$this->post($_POST['keterangan'])."
				WHERE `id_item` = ".$this->post($_POST['id_item']);
        } else {
            $query = "
				UPDATE `item` SET `nama`=".$this->post($_POST['nama']).",`harga_beli`=".$this->post(str_replace(",", "", $_POST['harga_beli'])).",`diskon`=".$this->post(cetak0($_POST['diskon'])).",
				`satuan`=".$this->post($_POST['satuan']).",`group`=".$this->post($group).",`keterangan`=".$this->post($_POST['keterangan']).",`gambar`=".$this->post($gambar)."
				WHERE `id_item` = ".$this->post($_POST['id_item']);
        }
        $query = $this->db->query($query);

        $query = "
			insert into log_item
			SELECT ".$this->post($tgl).",".$this->post($_SESSION['id_account']).", `id_item`, `nama`, `harga_beli`, `diskon`, `satuan`, `group`, `keterangan`, `gambar` FROM `item`
			where id_item=".$this->post($_POST['id_item']).";";
        $query = $this->db->query($query);
        $this->db->trans_complete();
        return true;
    }
    public function ajax_item_hapus()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        $query = "
		delete from item
		where id_item = ".$this->post($_POST['id_item']);
        $query = $this->db->query($query);
        $this->db->trans_complete();
        return true;
    }
    public function item_load($id_item)
    {
        $query = "
			select *
			from item
			where id_item = ".$this->post($id_item);
        $query = $this->db->query($query);
        return $query->result();
    }
    public function check_item_id($str)
    {
        $query = "select id_item from item where id_item = ".$this->post($str);
        $query = $this->db->query($query);

        $row = $query->num_rows();
        if ($row==0) {
            return false;
        }

        return true;
    }
    public function check_item_double()
    {
        $id_item = (isset($_POST['id_item']) ? $_POST['id_item'] : (isset($_GET['id_item']) ? $_GET['id_item'] : ''));

        if ($id_item=='') {
            $query = "select nama from item where nama = ".$this->post($_POST['nama']);
        } else {
            $query = "select nama from item where nama = ".$this->post($_POST['nama'])." and id_item <> ".$this->post($id_item);
        }

        $query = $this->db->query($query);
        $row = $query->num_rows();
        if ($row==0) {
            return true;
        }

        return false;
    }
    public function check_item_group($str)
    {
        $txt = '';
        foreach ($str as $key=>$value) {
            if ($txt!='') {
                $txt.=',';
            }
            $txt.=$this->post($value);
        }
        $query = "select case when count(id_kategori)=".count($str)." then true else false end hasil from custom where id_kategori = 'k0001' and opsi in (".$txt.")";

        $query = $this->db->query($query);
        $query = $query->result();
        return $query[0]->hasil;
    }
    public function list_nama_item()
    {
        $query = "select nama from item";
        $query = $this->db->query($query);
        return $query->result();
    }


    //PERSON
    public function person()
    {
        $query = "select * from person";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function jenis_person()
    {
        $query = "select * from custom where id_kategori='K0003'";
        $query = $this->db->query($query);
        return $query;
    }
    public function person_load($id_person)
    {
        $query = "select * from person where id_person = ".$this->post($id_person);
        $query = $this->db->query($query);
        return $query->result();
    }
    public function person_baru()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $query = "select concat('P',lpad(ifnull(max(mid(id_person,2,length(id_person)-1)),0)+1,9,0)) indeks from log_person";
        $query = $this->db->query($query);
        $row = $query->result();

        if (isset($_FILES) && $_FILES['gambar']['name']!='') {
            $temp = explode('.', htmlspecialchars($_FILES['gambar']['name'], ENT_QUOTES, 'UTF-8'));
            $_FILES['gambar']['name']=$row[0]->indeks.'.'.$temp[1];

            $config['upload_path']          = 'images/person';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2000;

            // $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata('person_modif', '<div class="alert alert-danger text-center">'.$this->upload->display_errors().'</div>');
                return false;
            } else {
                $data = array('upload_data' => $this->upload->data());
                $gambar = $data['upload_data']['file_name'];
            }
        } else {
            $gambar = '';
        }
        $query = "
			INSERT INTO `person`(`id_person`, `nama_person`, `jenis`, `notlpn`, `alamat`, `npwp`, `gambar`) VALUES
			(".$this->post($row[0]->indeks).",".$this->post($_POST['nama_person']).",".$this->post($_POST['jenis']).",
			".$this->post($_POST['notlpn']).",".$this->post($_POST['alamat']).",".$this->post($_POST['npwp']).",
			".$this->post($gambar).")
		";
        $query = $this->db->query($query);

        $query = "
			insert into log_person
			SELECT ".$this->post($tgl).",".$this->post($_SESSION['id_account']).", `id_person`, `nama_person`, `jenis`, `notlpn`, `alamat`, `npwp`, `gambar` FROM `person`
			where id_person=".$this->post($row[0]->indeks).";";
        $query = $this->db->query($query);
        $this->db->trans_complete();
        return true;
    }
    public function person_edit()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        if (isset($_FILES) && $_FILES['gambar']['name']!='') {
            $temp = explode('.', htmlspecialchars($_FILES['gambar']['name'], ENT_QUOTES, 'UTF-8'));
            $_FILES['gambar']['name']=$this->post($_POST['id_person']).'.'.$temp[1];
            $config['upload_path']          = 'images/person';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2000;

            // $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata('person_modif', '<div class="alert alert-danger text-center">'.$this->upload->display_errors().'</div>');
                return false;
            } else {
                $data = array('upload_data' => $this->upload->data());
                $gambar = $data['upload_data']['file_name'];
            }
        } else {
            $gambar = '';
        }

        if ($gambar == '') {
            $query = "
			UPDATE `person` SET `nama_person`=".$this->post($_POST['nama_person']).",`jenis`=".$this->post($_POST['jenis']).",
			`notlpn`=".$this->post($_POST['notlpn']).",`alamat`=".$this->post($_POST['alamat']).",`npwp`=".$this->post($_POST['npwp'])."
			WHERE `id_person`=".$this->post($_POST['id_person']);
        } else {
            $query = "
			UPDATE `person` SET `nama_person`=".$this->post($_POST['nama_person']).",`jenis`=".$this->post($_POST['jenis']).",
			`notlpn`=".$this->post($_POST['notlpn']).",`alamat`=".$this->post($_POST['alamat']).",`npwp`=".$this->post($_POST['npwp']).",`gambar`=".$this->post($gambar)."
			WHERE `id_person`=".$this->post($_POST['id_person']);
        }
        $query = $this->db->query($query);

        $query = "
			insert into log_person
			SELECT ".$this->post($tgl).",".$this->post($_SESSION['id_account']).", `id_person`, `nama_person`, `jenis`, `notlpn`, `alamat`, `npwp`, `gambar` FROM `person`
			where id_person=".$this->post($_POST['id_person']).";";
        $query = $this->db->query($query);
        $this->db->trans_complete();
        return true;
    }
    public function ajax_person_hapus()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();
        $query = "
		delete from person
		where id_person = ".$this->post($_POST['id_person']);
        $query = $this->db->query($query);
        $this->db->trans_complete();
        return true;
    }
    public function check_person_double()
    {
        $id_person = (isset($_POST['id_person']) ? $_POST['id_person'] : (isset($_GET['id_person']) ? $_GET['id_person'] : ''));

        if ($id_person=='') {
            $query = "select nama_person from person where nama_person = ".$this->post($_POST['nama_person']);
        } else {
            $query = "select nama_person from person where nama_person = ".$this->post($_POST['nama_person']). "and id_person <> ".$this->post($id_person);
        }
        $query = $this->db->query($query);
        $row = $query->num_rows();
        if ($row==0) {
            return true;
        }

        return false;
    }
    public function check_person_id($str)
    {
        $query = "select id_person from person where id_person = ".$this->post($str);
        $query = $this->db->query($query);

        $row = $query->num_rows();
        if ($row==0) {
            return false;
        }

        return true;
    }
    public function check_person_jenis($str)
    {
        $query = "select * from custom where id_kategori = 'k0003' and opsi = ".$this->post($str);
        $query = $this->db->query($query);
        $query = $query->num_rows();
        if ($query==1) {
            return true;
        } else {
            return false;
        }
    }


    //TRANSAKSI
    public function list_item()
    {
        $query = "select * from item order by nama asc";
        $query = $this->db->query($query);
        return $query;
    }
    public function list_customer()
    {
        $query = "select id_person, nama_person from person where jenis = 'customer' order by nama_person asc";
        $query = $this->db->query($query);
        return $query;
    }
    public function list_sales()
    {
        $query = "select id_person, nama_person from person where jenis = 'sales' order by nama_person asc";
        $query = $this->db->query($query);
        return $query;
    }
    public function list_supplier()
    {
        $query = "select id_person, nama_person from person where jenis = 'supplier' order by nama_person asc";
        $query = $this->db->query($query);
        return $query;
    }
    public function check_customer($str)
    {
        $query = "select id_person, nama_person from person where jenis = 'customer' and id_person = ".$this->post($str);
        $query = $this->db->query($query);
        $query = $query->num_rows();
        if ($query==1) {
            return true;
        } else {
            return false;
        }
    }
    public function check_sales($str)
    {
        $query = "select id_person, nama_person from person where jenis = 'sales' and id_person = ".$this->post($str);
        $query = $this->db->query($query);
        $query = $query->num_rows();
        if ($query==1) {
            return true;
        } else {
            return false;
        }
    }
    public function check_supplier($str)
    {
        $query = "select id_person, nama_person from person where jenis = 'supplier' and id_person = ".$this->post($str);
        $query = $this->db->query($query);
        $baris = $query->num_rows();

        if ($baris==1) {
            return true;
        } else {
            return false;
        }
    }
    public function check_person($str)
    {
        $query = "select id_person, nama_person from person where jenis in ('customer','supplier') and id_person = ".$this->post($str);
        $query = $this->db->query($query);
        $baris = $query->num_rows();

        if ($baris==1) {
            return true;
        } else {
            return false;
        }
    }
    public function check_item_transaksi()
    {
        $temp = count($_POST['id_item']);

        //check data post
        if (
            $temp == count($_POST['nama_item']) &&
            $temp == count($_POST['qty_item']) &&
            $temp == count($_POST['satuan_item']) &&
            $temp == count($_POST['harga_item']) &&
            $temp == count($_POST['diskon_item']) &&
            $temp == count($_POST['subtotal_item']) &&
            $temp == count($_POST['keterangan_item'])
        ) {
            $check = true;
        } else {
            return 'Check kembali item';
        }

        //check subtotal
        if ($check == true) {
            foreach ($_POST['id_item'] as $key=>$value) {
                $str = $_POST['diskon_item'][$key];
                if (stripos($str, "%")) {
                    $diskon = str_replace("%", "", str_replace(",", "", $str));
                    $diskon = explode("+", $diskon);
                    foreach ($diskon as $key2=>$value2) {
                        if (is_numeric($value2)==0 || !($value2>=0 && $value2<=100)) {
                            return 'Item '.$_POST['nama_item'][$key].' diskon tidak sesuai';
                        }
                    }
                } elseif (stripos($str, "+")) {
                    return 'Item '.$_POST['nama_item'][$key].' diskon tidak sesuai';
                } else {
                    if (!(is_numeric(cetak0($str)))) {
                        return 'Item '.$_POST['nama_item'][$key].' diskon tidak sesuai';
                    }
                }
                $subtotal = hitung($_POST['harga_item'][$key], $_POST['qty_item'][$key], $_POST['diskon_item'][$key]);

                if (cetak0($_POST['subtotal_item'][$key]) == $subtotal && $check == true) {
                    if ($subtotal < 0) {
                        return 'Item '.$_POST['nama_item'][$key].' subtotal tidak boleh lebih kecil dari 0';
                    }

                    //check item
                    $query = "
						select count(id_item) byk
						from item
						where id_item in (".$this->post($_POST['id_item'][$key]).")
					";
                    $query = $this->db->query($query);
                    $byk = $query->result();
                    if ($byk[0]->byk == 1) {
                        $check = true;
                    } else {
                        return 'Item '.$_POST['nama_item'][$key].' tidak ditemukan';
                    }
                } else {
                    return 'Item '.$_POST['nama_item'][$key].' hitungan subtotal tidak sesuai';
                }
            }
        }

        //check item double
        if (count($_POST['id_item']) == count(array_unique($_POST['id_item']))) {
            return 'ok';
        } else {
            return 'item ada yang double';
        }
    }
    public function check_item_stock()
    {
        $id_penjualan = (isset($_POST['id_penjualan']) ? $_POST['id_penjualan'] : (isset($_GET['id_penjualan']) ? $_GET['id_penjualan'] : ''));
        $id_retur_beli = (isset($_POST['id_retur_beli']) ? $_POST['id_retur_beli'] : (isset($_GET['id_retur_beli']) ? $_GET['id_retur_beli'] : ''));

        foreach ($_POST['id_item'] as $key=>$value) {
            $query = "
				select
					case when sum(stock_sisa) >= ".$this->post($_POST['qty_item'][$key])."
					then 9
					else false
					end nilai
				from (
					select id_item, stock_sisa
					from stock
					where id_item = ".$this->post($_POST['id_item'][$key])."
					union all
					select id_item, qty
					from detail_penjualan
					where id_penjualan = ".$this->post($id_penjualan)." and id_penjualan <> '' and id_item = ".$this->post($_POST['id_item'][$key])."
					union all
					select id_item, qty
					from detail_retur_beli
					where id_retur_beli = ".$this->post($id_retur_beli)." and id_retur_beli <> '' and id_item = ".$this->post($_POST['id_item'][$key])."
				)stock
				where id_item = ".$this->post($_POST['id_item'][$key])."
				group by id_item";
            $query = $this->db->query($query);
            $query = $query->result();
            if ($query[0]->nilai == '9') {
                $check = true;
            } else {
                $temp0 = explode(' - ', $_POST['nama_item'][$key]);
                array_pop($temp0);
                return 'Item '.implode(' ', $temp0).' stock tidak ada / kurang';
            }
        }
        return 'ok';
    }
    public function list_stock()
    {
        $id_penjualan = (isset($_POST['id_penjualan']) ? $_POST['id_penjualan'] : (isset($_GET['id_penjualan']) ? $_GET['id_penjualan'] : ''));
        $id_retur_beli = (isset($_POST['id_retur_beli']) ? $_POST['id_retur_beli'] : (isset($_GET['id_retur_beli']) ? $_GET['id_retur_beli'] : ''));

        $query = "
			SELECT item.id_item, item.nama, stock_sisa qty,  stock_awal qty0, item.satuan, stock.subtotal, stock.diskon, harga
			FROM (
				SELECT stock.id_item, stock_sisa, stock.batch, stock_awal,
				case when b0.subtotal is not null
				then b0.subtotal
				else rj0.subtotal
				end subtotal,
				case when b0.subtotal is not null
				then b.diskon
				else rj.diskon
				end diskon,
				case when b0.harga is not null
				then b0.harga
				else rj0.harga
				end harga
				FROM stock
				LEFT JOIN detail_pembelian b0 on b0.batch=stock.batch
				LEFT JOIN pembelian b on b.id_pembelian=b0.id_pembelian
				LEFT JOIN detail_retur_jual rj0 on rj0.batch=stock.batch
				LEFT JOIN retur_jual rj on rj.id_retur_jual=rj0.id_retur_jual
				where stock_sisa>0

				union all

				select id_item, sum(qty) qty, batch, sum(qty) qty0, subtotal, diskon, harga
				from (
					select j0.id_item, j0.qty, j0.batch, j0.subtotal, j.diskon, j0.harga
					from detail_penjualan j0
					inner join penjualan j on j.id_penjualan=j0.id_penjualan
					where j0.id_penjualan<>'' and j0.id_penjualan = ".$this->post($id_penjualan)."
				)t
				group by id_item

				union all

				select id_item, sum(qty) qty, batch, sum(qty) qty0, subtotal, diskon, harga
				from (
					select rb0.id_item, rb0.qty, rb0.batch, rb0.subtotal, rb.diskon, rb0.harga
					from detail_retur_beli rb0
					inner join retur_beli rb on rb.id_retur_beli=rb0.id_retur_beli
					where rb0.id_retur_beli<>'' and rb0.id_retur_beli = ".$this->post($id_retur_beli)."
				)t
				group by id_item


			)`stock`
			LEFT JOIN item on item.id_item=stock.id_item
			order by item.nama asc
		";
        // pre($query);
        $query = $this->db->query($query);
        $query = $query->result_array();
        $nilai = array();

        foreach (array_unique(array_column($query, 'id_item')) as $key=>$value) {
            $temp = array(
                'id_item' => $value,
                'nama' => check_array($query, $value, 'id_item', 'nama'),
                'stock_awal' => check_array($query, $value, 'id_item', 'qty0'),
                'stock_sisa' => check_array($query, $value, 'id_item', 'qty'),
                'satuan' => check_array($query, $value, 'id_item', 'satuan'),
                'harga' => check_array($query, $value, 'id_item', 'harga')
            );
            $nilai[] = $temp;
        }
        return $nilai;
    }


    //PEMBELIAN
    public function pembelian()
    {
        $query = "
			select head.*, sum(detail.subtotal) subtotal, person.nama_person supplier
			from pembelian head
			inner join detail_pembelian detail on detail.id_pembelian=head.id_pembelian
			left join person on person.id_person=head.id_supplier
			where head.id_pembelian in (
				select t.id_pembelian
				from (
					select id_pembelian, count(id_pembelian) byk
					from stock
					left join detail_pembelian on detail_pembelian.batch=stock.batch
					where stock_awal=stock_sisa
					group by id_pembelian
				)t
				inner join (
					select id_pembelian, count(id_pembelian) byk
					from stock
					left join detail_pembelian on detail_pembelian.batch=stock.batch
					group by id_pembelian
				)t2 on t.id_pembelian=t2.id_pembelian and t.byk=t2.byk
			) and head.id_pembelian not in (select id_transaksi from detail_pembayaran)
			group by head.id_pembelian
		";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function pembelian_detail()
    {
        $query = "
			select detail_pembelian.*, item.nama, item.satuan, pembelian.diskon diskon0
			from detail_pembelian
			inner join pembelian on detail_pembelian.id_pembelian=pembelian.id_pembelian
			left join item on item.id_item=detail_pembelian.id_item
			where pembelian.id_pembelian in (
				select t.id_pembelian
				from (
					select id_pembelian, count(id_pembelian) byk
					from stock
					left join detail_pembelian on detail_pembelian.batch=stock.batch
					where stock_awal=stock_sisa
					group by id_pembelian
				)t
				inner join (
					select id_pembelian, count(id_pembelian) byk
					from stock
					left join detail_pembelian on detail_pembelian.batch=stock.batch
					group by id_pembelian
				)t2 on t.id_pembelian=t2.id_pembelian and t.byk=t2.byk
			) and pembelian.id_pembelian not in (select id_transaksi from detail_pembayaran)
			group by detail_pembelian.id_pembelian, id_item
		";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function pembelian_load($str)
    {
        $query = "
		select pembelian.tgl_input, pembelian.user_input, pembelian.id_pembelian, pembelian.tgl_pembelian, pembelian.id_supplier, pembelian.no_bon,
		pembelian.tgl_TOP, pembelian.diskon, pembelian.keterangan,
		detail.id_item,	detail.harga, detail.qty, detail.diskon diskon_item, detail.subtotal,
		detail.keterangan keterangan_item, detail.batch, item.nama nama_item, item.satuan
		from pembelian
		inner join detail_pembelian detail on detail.id_pembelian=pembelian.id_pembelian
		left join item on item.id_item=detail.id_item
		where pembelian.id_pembelian = ".$this->post($str);
        $query = $this->db->query($query);
        return $query->result();
    }
    public function pembelian_baru()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $query = "select concat('B',lpad(ifnull(max(mid(id_pembelian,2,length(id_pembelian)-1)),0)+1,9,0)) indeks from log_detail_pembelian where substring(id_pembelian,1,1)='B'";
        $query = $this->db->query($query);
        $row = $query->result();

        $tgl_pembelian = cetak_tgl($_POST['tgl_pembelian']);

        $tgl_TOP=date_create($_POST['tgl_pembelian']);
        date_add($tgl_TOP, date_interval_create_from_date_string(abs($_POST['jatuh_tempo'])." days"));

        if (isset($_FILES) && $_FILES['gambar']['name']!='') {
            $temp = explode('.', htmlspecialchars($_FILES['gambar']['name'], ENT_QUOTES, 'UTF-8'));
            $_FILES['gambar']['name']=$row[0]->indeks.'.'.$temp[1];

            $config['upload_path']          = 'images/pembelian';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2000;

            // $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata('pembelian_modif', '<div class="alert alert-danger text-center">'.$this->upload->display_errors().'</div>');
                return false;
            } else {
                $data = array('upload_data' => $this->upload->data());
                $gambar = $data['upload_data']['file_name'];
            }
        } else {
            $gambar = '';
        }

        foreach ($_POST['id_item'] as $key=>$value) {
            $query = " select concat('9',lpad(ifnull(max(mid(batch,2,length(batch)-1)),0)+1,11,0)) batch from ( select batch from log_detail_retur_jual UNION select batch from log_detail_pembelian )t where substring(batch,1,1)='9' ";
            $query = $this->db->query($query);
            $batch = $query->result();

            $query = "
			INSERT INTO `detail_pembelian`(`id_pembelian`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`) VALUES (
			".$this->post($row[0]->indeks).",".$this->post($_POST['id_item'][$key]).",".$this->post(cetak0($_POST['harga_item'][$key])).",
			".$this->post(cetak0($_POST['qty_item'][$key])).",".$this->post(cetak0($_POST['diskon_item'][$key])).",".$this->post(cetak0($_POST['subtotal_item'][$key])).",
			".$this->post(cetak0($_POST['keterangan_item'][$key])).",".$this->post($batch[0]->batch).")";
            $query = $this->db->query($query);

            $query = "
			insert into log_detail_pembelian
			SELECT ".$this->post($tgl).",".$this->post($_SESSION['id_account']).", `id_pembelian`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`,
			`keterangan`, `batch`
			FROM `detail_pembelian`
			WHERE id_pembelian=".$this->post($row[0]->indeks)." and id_item=".$this->post($_POST['id_item'][$key]);
            $query = $this->db->query($query);

            $query = "INSERT INTO `stock`(`tgl_input`, `id_item`, `stock_awal`, `stock_sisa`, `batch`, `gudang`) VALUES (
			".$this->post($tgl).",".$this->post($_POST['id_item'][$key]).",".$this->post(cetak0($_POST['qty_item'][$key])).",
			".$this->post(cetak0($_POST['qty_item'][$key])).",".$this->post($batch[0]->batch).", 'G000000001')";
            $query = $this->db->query($query);
        }
        $query = "
		INSERT INTO `pembelian`(`tgl_input`, `user_input`, `id_pembelian`, `tgl_pembelian`, `id_supplier`, `no_bon`, `tgl_TOP`, `gambar`, `diskon`, `keterangan`) VALUES (
		".$this->post($tgl).",".$this->post($_SESSION['id_account']).",".$this->post($row[0]->indeks).",".$this->post($tgl_pembelian).",
		".$this->post($_POST['id_supplier']).",".$this->post($_POST['no_bon']).",".$this->post(date_format($tgl_TOP, "Y-m-d")).",
		".$this->post($gambar).",".$this->post(cetak0($_POST['diskon'])).",".$this->post($_POST['keterangan']).")";
        $query = $this->db->query($query);

        $query = "
			insert into log_pembelian
			SELECT * FROM `pembelian`
			where id_pembelian=".$this->post($row[0]->indeks);
        $query = $this->db->query($query);
        $this->db->trans_complete();
        return true;
    }
    public function pembelian_edit()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $tgl_pembelian = cetak_tgl($_POST['tgl_pembelian']);
        $tgl_TOP=date_create($_POST['tgl_pembelian']);
        date_add($tgl_TOP, date_interval_create_from_date_string(abs($_POST['jatuh_tempo'])." days"));

        if (isset($_FILES) && $_FILES['gambar']['name']!='') {
            $temp = explode('.', htmlspecialchars($_FILES['gambar']['name'], ENT_QUOTES, 'UTF-8'));
            $_FILES['gambar']['name']=$_POST['id_pembelian'].'.'.$temp[1];

            $config['upload_path']          = 'images/pembelian';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2000;

            // $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata('pembelian_modif', '<div class="alert alert-danger text-center">'.$this->upload->display_errors().'</div>');
                return false;
            } else {
                $data = array('upload_data' => $this->upload->data());
                $gambar = $data['upload_data']['file_name'];
            }
        } else {
            $gambar = '';
        }

        $query = "delete from stock where batch in (select batch from detail_pembelian where id_pembelian=".$this->post($_POST['id_pembelian']).")";
        $query = $this->db->query($query);

        $query = "DELETE FROM `detail_pembelian` WHERE id_pembelian = ".$this->post($_POST['id_pembelian']);
        $query = $this->db->query($query);

        foreach ($_POST['id_item'] as $key=>$value) {
            $query = " select concat('9',lpad(ifnull(max(mid(batch,2,length(batch)-1)),0)+1,11,0)) batch from ( select batch from log_detail_retur_jual UNION select batch from log_detail_pembelian )t where substring(batch,1,1)='9' ";
            $query = $this->db->query($query);
            $batch = $query->result();

            $query = "
			INSERT INTO `detail_pembelian`(`id_pembelian`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`) VALUES (
			".$this->post($_POST['id_pembelian']).",".$this->post($_POST['id_item'][$key]).",".$this->post(cetak0($_POST['harga_item'][$key])).",
			".$this->post(cetak0($_POST['qty_item'][$key])).",".$this->post(cetak0($_POST['diskon_item'][$key])).",".$this->post(cetak0($_POST['subtotal_item'][$key])).",
			".$this->post(cetak0($_POST['keterangan_item'][$key])).",".$this->post($batch[0]->batch).")";
            $query = $this->db->query($query);

            $query = "
			insert into log_detail_pembelian
			SELECT ".$this->post($tgl).",".$this->post($_SESSION['id_account']).", `id_pembelian`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`,
			`keterangan`, `batch`
			FROM `detail_pembelian`
			WHERE id_pembelian=".$this->post($_POST['id_pembelian'])." and id_item=".$this->post($_POST['id_item'][$key]);
            $query = $this->db->query($query);

            $query = "INSERT INTO `stock`(`tgl_input`, `id_item`, `stock_awal`, `stock_sisa`, `batch`, `gudang`) VALUES (
			".$this->post($tgl).",".$this->post($_POST['id_item'][$key]).",".$this->post(cetak0($_POST['qty_item'][$key])).",
			".$this->post(cetak0($_POST['qty_item'][$key])).",".$this->post($batch[0]->batch).", 'G000000001')";
            $query = $this->db->query($query);
        }

        if ($gambar != '') {
            $query = "
				UPDATE `pembelian` SET `tgl_input`=".$this->post($tgl).",`user_input`=".$this->post($_SESSION['id_account']).",`tgl_pembelian`=".$this->post($tgl_pembelian).",
				`id_supplier`=".$this->post($_POST['id_supplier']).",`no_bon`=".$this->post($_POST['no_bon']).",`tgl_TOP`=".$this->post(date_format($tgl_TOP, "Y-m-d")).",
				`gambar`=".$this->post($gambar).",`diskon`=".$this->post(cetak0($_POST['diskon'])).",`keterangan`=".$this->post($_POST['keterangan'])."
				WHERE `id_pembelian`=".$this->post($_POST['id_pembelian']);
        } else {
            $query = "
				UPDATE `pembelian` SET `tgl_input`=".$this->post($tgl).",`user_input`=".$this->post($_SESSION['id_account']).",`tgl_pembelian`=".$this->post($tgl_pembelian).",
				`id_supplier`=".$this->post($_POST['id_supplier']).",`no_bon`=".$this->post($_POST['no_bon']).",`tgl_TOP`=".$this->post(date_format($tgl_TOP, "Y-m-d")).",
				`diskon`=".$this->post(cetak0($_POST['diskon'])).",`keterangan`=".$this->post($_POST['keterangan'])."
				WHERE `id_pembelian`=".$this->post($_POST['id_pembelian']);
        }
        $query = $this->db->query($query);

        $query = "
			insert into log_pembelian
			SELECT * FROM `pembelian`
			where id_pembelian=".$this->post($_POST['id_pembelian']);
        $query = $this->db->query($query);
        $this->db->trans_complete();
        return true;
    }
    public function ajax_pembelian_hapus()
    {
        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $query = "
		select count(id_item) stock, (select count(id_item) from detail_pembelian where id_pembelian = ".$this->post($_POST['id_pembelian']).") beli
		from stock
		where stock_awal=stock_sisa and batch in (select batch from detail_pembelian where id_pembelian = ".$this->post($_POST['id_pembelian']).")";
        $query = $this->db->query($query);
        $query = $query->result();

        if ($query[0]->stock==$query[0]->beli) {
            $this->db->trans_strict(false);
            $this->db->trans_start();
            $query = "delete from stock where batch in (select batch from log_detail_pembelian where id_pembelian = ".$this->post($_POST['id_pembelian']).")";
            $query = $this->db->query($query);
            $query = "delete from pembelian where id_pembelian = ".$this->post($_POST['id_pembelian']);
            $query = $this->db->query($query);
            $query = "delete from detail_pembelian where id_pembelian = ".$this->post($_POST['id_pembelian']);
            $query = $this->db->query($query);
            $this->db->trans_complete();
            return true;
        } else {
            return false;
        }
    }
    public function check_pembelian_id($str)
    {
        $query = "
			select case when batch=stock
			then true
			else false
			end nilai
			from(
				select id_pembelian, COUNT(batch) batch, (
					select count(stock_awal)
					from stock
					where stock_awal=stock_sisa and batch in
						(select batch from detail_pembelian where id_pembelian = ".$this->post($str).")
				) stock
				from detail_pembelian
				where id_pembelian not in (select id_transaksi from detail_pembayaran) and
				id_pembelian = ".$this->post($str)."
				group by id_pembelian
			)t";
        $query = $this->db->query($query);
        $row = $query->result();
        if ($row[0]->nilai==1) {
            return true;
        } else {
            return false;
        }
    }


    //PENJUALAN
    public function penjualan()
    {
        $query = "
select tgl_input, 	user_input, 	id_penjualan, 	tgl_penjualan, 	id_customer, 	id_sales, 	tgl_TOP, 	diskon, 	keterangan, sum(subtotal) subtotal, 	customer, 	sales, sum(qty) qty
from (
	select head.*, sum(detail.qty) qty, detail.subtotal, customer.nama_person customer, sales.nama_person sales
	from penjualan head
	inner join detail_penjualan detail on detail.id_penjualan=head.id_penjualan
	left join person customer on customer.id_person=head.id_customer
	left join person sales on sales.id_person=head.id_sales
	where head.id_penjualan not in (select id_transaksi from detail_pembayaran)
	group by head.id_penjualan, detail.id_item
)t
group by id_penjualan
		";
        // $query = "
        // select head.*, sum(detail.subtotal) subtotal, customer.nama_person customer, sales.nama_person sales
        // from penjualan head
        // inner join detail_penjualan detail on detail.id_penjualan=head.id_penjualan
        // left join person customer on customer.id_person=head.id_customer
        // left join person sales on sales.id_person=head.id_sales
        // where head.id_penjualan not in (select id_transaksi from detail_pembayaran)
        // group by head.id_penjualan
        // ";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function penjualan_detail()
    {
        $query = "set @row_num = 0;";
        $query = $this->db->query($query);

        $query = "
			select @row_num := @row_num + 1 as row_index, detail_penjualan.id_penjualan, detail_penjualan.id_item, harga, sum(qty) qty, detail_penjualan.diskon,
			detail_penjualan.subtotal, detail_penjualan.keterangan, batch, nama, satuan, penjualan.diskon diskon0
			from detail_penjualan
			inner join penjualan on detail_penjualan.id_penjualan=penjualan.id_penjualan
			left join item on item.id_item=detail_penjualan.id_item
			where penjualan.id_penjualan not in (select id_transaksi from detail_pembayaran)
			group by detail_penjualan.id_penjualan, id_item
			order by row_index asc
		";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function penjualan_load($str)
    {
        $query = "
		select penjualan.tgl_input, penjualan.user_input, penjualan.id_penjualan, penjualan.tgl_penjualan, penjualan.id_customer, penjualan.id_sales,
		penjualan.tgl_TOP, penjualan.diskon, penjualan.keterangan,
		detail.id_item,	detail.harga, sum(detail.qty) qty, detail.diskon diskon_item, detail.subtotal,
		detail.keterangan keterangan_item, detail.batch, item.nama nama_item, item.satuan
		from penjualan
		inner join detail_penjualan detail on detail.id_penjualan=penjualan.id_penjualan
		left join item on item.id_item=detail.id_item
		where penjualan.id_penjualan = ".$this->post($str)."
        group by detail.id_item";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function penjualan_baru()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $tgl_penjualan = cetak_tgl($_POST['tgl_penjualan']);
        $tgl_TOP=date_create($_POST['tgl_penjualan']);
        date_add($tgl_TOP, date_interval_create_from_date_string(abs($_POST['jatuh_tempo'])." days"));

        $query = "select concat('J',lpad(ifnull(max(mid(id_penjualan,2,length(id_penjualan)-1)),0)+1,9,0)) indeks from log_detail_penjualan where substring(id_penjualan,1,1)='J'";
        $query = $this->db->query($query);
        $row = $query->result();

        foreach ($_POST['id_item'] as $key=>$value) {
            $jmlh = str_replace(",", "", $_POST['qty_item'][$key]);
            while ($jmlh > 0) {
                $query = "
                    select tgl_input, id_item, stock.batch, stock_sisa
                    from stock
                    where stock_sisa<>0 and id_item = ".$this->post($_POST['id_item'][$key])."
                    order by tgl_input, batch DESC
                    limit 1";
                $query = $this->db->query($query);
                $batch = $query->result();
                $stock_sisa = $batch[0]->stock_sisa;

                if (($jmlh - $stock_sisa) >= 0) {
                    $kurang = $stock_sisa;
                } elseif (($jmlh - $stock_sisa) < 0) {
                    $kurang = $jmlh;
                }
                $jmlh = $jmlh - $kurang;
                $query = "
					UPDATE `stock` SET `stock_sisa`= stock_sisa - ".$this->post($kurang)."
					WHERE batch = ".$this->post($batch[0]->batch);
                $query = $this->db->query($query);

                $query = "
				INSERT INTO `detail_penjualan`(`id_penjualan`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`) VALUES (
				".$this->post($row[0]->indeks).",".$this->post($_POST['id_item'][$key]).",".$this->post(cetak0($_POST['harga_item'][$key])).",
				".$this->post($kurang).",".$this->post(cetak0($_POST['diskon_item'][$key])).",".$this->post(cetak0($_POST['subtotal_item'][$key])).",
				".$this->post(cetak0($_POST['keterangan_item'][$key])).",".$this->post($batch[0]->batch).")";

                $query = $this->db->query($query);


                $query = "
				insert into log_detail_penjualan
				select ".$this->post($tgl).",".$this->post($_SESSION['id_account']).",
				`id_penjualan`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`
				FROM `detail_penjualan`
				where id_penjualan=".$this->post($row[0]->indeks)." and id_item=".$this->post($_POST['id_item'][$key]). "and qty = ".$this->post($kurang);
                $query = $this->db->query($query);
            }
        }
        $query = "
		INSERT INTO `penjualan`(`tgl_input`, `user_input`, `id_penjualan`, `tgl_penjualan`, `id_customer`, `id_sales`, `tgl_TOP`, `diskon`, `keterangan`) VALUES (
		".$this->post($tgl).",".$this->post($_SESSION['id_account']).",".$this->post($row[0]->indeks).",".$this->post($tgl_penjualan).",
		".$this->post($_POST['id_customer']).",".$this->post($_POST['id_sales']).",".$this->post(date_format($tgl_TOP, "Y-m-d")).",
		".$this->post(cetak0($_POST['diskon'])).",".$this->post($_POST['keterangan']).")";
        $query = $this->db->query($query);

        $query = "
			insert into log_penjualan
			SELECT * FROM `penjualan`
			where id_penjualan=".$this->post($row[0]->indeks).";";
        $query = $this->db->query($query);

        $query = "select * from stock where stock_sisa<0 or stock_sisa>stock_awal";
        $query = $this->db->query($query);
        if ($query->num_rows()>0) {
            $this->session->set_flashdata('penjualan_modif', '<div class="alert alert-success text-center">Terjadi Kesalahan</div>');
            return false;
        } else {
            $this->db->trans_complete();
            return true;
        }
    }
    public function penjualan_edit()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $tgl_penjualan = cetak_tgl($_POST['tgl_penjualan']);
        $tgl_TOP=date_create($_POST['tgl_penjualan']);
        date_add($tgl_TOP, date_interval_create_from_date_string(abs($_POST['jatuh_tempo'])." days"));

        $query = "
			UPDATE stock
			INNER JOIN detail_penjualan
			on detail_penjualan.id_item=stock.id_item and detail_penjualan.batch=stock.batch
			set stock.stock_sisa = stock.stock_sisa + detail_penjualan.qty
			where id_penjualan = ".$this->post($_POST['id_penjualan']);
        $query = $this->db->query($query);

        $query = "delete from detail_penjualan where id_penjualan = ".$this->post($_POST['id_penjualan']);
        $query = $this->db->query($query);

        foreach ($_POST['id_item'] as $key=>$value) {
            $jmlh = str_replace(",", "", $_POST['qty_item'][$key]);
            while ($jmlh > 0) {
                $query = "
                    select tgl_input, id_item, stock.batch, stock_sisa
                    from stock
                    where stock_sisa<>0 and id_item = ".$this->post($_POST['id_item'][$key])."
                    order by tgl_input, batch DESC
                    limit 1";
                $query = $this->db->query($query);
                $batch = $query->result();
                $stock_sisa = $batch[0]->stock_sisa;

                if (($jmlh - $stock_sisa) >= 0) {
                    $kurang = $stock_sisa;
                } elseif (($jmlh - $stock_sisa) < 0) {
                    $kurang = $jmlh;
                }
                $jmlh = $jmlh - $kurang;
                $query = "
					UPDATE `stock` SET `stock_sisa`= stock_sisa - ".$this->post($kurang)."
					WHERE batch = ".$this->post($batch[0]->batch);
                $query = $this->db->query($query);

                $query = "
				INSERT INTO `detail_penjualan`(`id_penjualan`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`) VALUES (
				".$this->post($_POST['id_penjualan']).",".$this->post($_POST['id_item'][$key]).",".$this->post(cetak0($_POST['harga_item'][$key])).",
				".$this->post($kurang).",".$this->post(cetak0($_POST['diskon_item'][$key])).",".$this->post(cetak0($_POST['subtotal_item'][$key])).",
				".$this->post(cetak0($_POST['keterangan_item'][$key])).",".$this->post($batch[0]->batch).")";
                $query = $this->db->query($query);


                $query = "
				insert into log_detail_penjualan
				select ".$this->post($tgl).",".$this->post($_SESSION['id_account']).",
				`id_penjualan`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`
				FROM `detail_penjualan`
				where id_penjualan=".$this->post($_POST['id_penjualan'])." and id_item=".$this->post($_POST['id_item'][$key]). "and qty = ".$this->post($kurang);
                $query = $this->db->query($query);
            }
        }

        $query = "
			UPDATE `penjualan` SET
			`tgl_input`=".$this->post($tgl).",`user_input`=".$this->post($_SESSION['id_account']).",`tgl_penjualan`=".$this->post($tgl_penjualan).",
			`id_customer`=".$this->post($_POST['id_customer']).",`id_sales`=".$this->post($_POST['id_sales']).",`tgl_TOP`=".$this->post(date_format($tgl_TOP, "Y-m-d")).",
			`diskon`=".$this->post(cetak0($_POST['diskon'])).",`keterangan`=".$this->post($_POST['keterangan'])."
			WHERE id_penjualan = ".$this->post($_POST['id_penjualan']);
        $query = $this->db->query($query);

        $query = "
			insert into log_penjualan
			SELECT * FROM `penjualan`
			where id_penjualan=".$this->post($_POST['id_penjualan']).";";
        $query = $this->db->query($query);

        $query = "select * from stock where stock_sisa<0 or stock_sisa>stock_awal";
        $query = $this->db->query($query);
        if ($query->num_rows()>0) {
            $this->session->set_flashdata('penjualan_modif', '<div class="alert alert-success text-center">Terjadi Kesalahan</div>');
            return false;
        } else {
            $this->db->trans_complete();
            return true;
        }
    }
    public function ajax_penjualan_hapus()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        $query = "delete from detail_penjualan where id_penjualan not in (select id_transaksi from detail_pembayaran) and id_penjualan = ".$this->post($_POST['id_penjualan']);
        $query = $this->db->query($query);

        $query = "delete from penjualan where id_penjualan not in (select id_transaksi from detail_pembayaran) and id_penjualan = ".$this->post($_POST['id_penjualan']);
        $query = $this->db->query($query);

        $query = "
			UPDATE stock
			INNER JOIN log_detail_penjualan
			on log_detail_penjualan.id_item=stock.id_item and log_detail_penjualan.batch=stock.batch
			set stock.stock_sisa = stock.stock_sisa + log_detail_penjualan.qty
			where id_penjualan not in (select id_transaksi from detail_pembayaran) and id_penjualan = ".$this->post($_POST['id_penjualan']);
        $query = $this->db->query($query);

        $query = "select * from stock where stock_sisa<0 or stock_sisa>stock_awal";
        $query = $this->db->query($query);
        if ($query->num_rows()>0) {
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Terjadi Kesalahan</div>');
            return false;
        } else {
            $this->db->trans_complete();
            return true;
        }
    }
    public function check_penjualan_id($str)
    {
        $query = "
			select id_penjualan
			from penjualan
			where id_penjualan not in (select id_transaksi from detail_pembayaran) and id_penjualan = ".$this->post($str);
        $query = $this->db->query($query);
        if ($query->num_rows()==1) {
            return true;
        } else {
            return false;
        }
    }
    public function print_invoice($str)
    {
        $query = "
			select id_penjualan, tgl_penjualan, tgl_TOP, diskon, customer, sales, notlpn, alamat, sum(subtotal) subtotal
			from (
				select penjualan.id_penjualan, tgl_penjualan, tgl_TOP, penjualan.diskon, customer.nama_person customer, sales.nama_person sales,
				customer.notlpn, customer.alamat, sum(detail_penjualan.qty) qty, detail_penjualan.subtotal
				from penjualan
				inner join detail_penjualan on detail_penjualan.id_penjualan=penjualan.id_penjualan
				left join person customer on customer.id_person=penjualan.id_customer
				left join person sales on sales.id_person=penjualan.id_sales
				where penjualan.id_penjualan = ".$this->post($str)."
				group by penjualan.id_penjualan, detail_penjualan.id_item
			)t
			group by id_penjualan
		";
        // $query = "
        // select penjualan.id_penjualan, tgl_penjualan, tgl_TOP, penjualan.diskon, customer.nama_person customer, sales.nama_person sales,
        // customer.notlpn, customer.alamat, sum(detail_penjualan.subtotal) subtotal
        // from penjualan
        // inner join detail_penjualan on detail_penjualan.id_penjualan=penjualan.id_penjualan
        // left join person customer on customer.id_person=penjualan.id_customer
        // left join person sales on sales.id_person=penjualan.id_sales
        // where penjualan.id_penjualan = ".$this->post($str)."
        // group by penjualan.id_penjualan
        // ";
        $query = $this->db->query($query);
        $query = $query->result();
        $query[0]->tgl_penjualan = cetak_tgl($query[0]->tgl_penjualan);
        $query[0]->tgl_TOP = cetak_tgl($query[0]->tgl_TOP);
        $query[0]->id_penjualan = cetak($query[0]->id_penjualan);
        $query[0]->customer = strtoupper(cetak($query[0]->customer));
        $query[0]->sales = cetak($query[0]->sales);
        $query[0]->alamat = cetak($query[0]->alamat);
        $query[0]->subtotal = cetak($query[0]->subtotal);
        $query[0]->diskon = cetak($query[0]->diskon);
        $query[0]->total = cetak(hitung($query[0]->subtotal, 1, $query[0]->diskon));

        return $query;
    }
    public function print_detail($str)
    {
        $query = "set @row_num = 0;";
        $query = $this->db->query($query);

        $query = "
			CREATE TEMPORARY TABLE new_tbl
			select @row_num := @row_num + 1 as row_index, detail_penjualan.*
			from detail_penjualan
			where detail_penjualan.id_penjualan = ".$this->post($str).";
		";
        $query = $this->db->query($query);

        $query = "
			select nama, harga, FORMAT(sum(qty),2) qty, new_tbl.diskon, subtotal, satuan,
			(
				select sum(diskon) diskon9
				from detail_penjualan a
				where a.id_penjualan=new_tbl.id_penjualan
			) diskon9
			from new_tbl
			left join item on item.id_item=new_tbl.id_item
			group by nama
			order by row_index asc
		";
        $query = $this->db->query($query);
        return $query->result();
    }


    //RETUR JUAL
    public function retur_jual()
    {
        $query = "
			select head.*, sum(detail.subtotal) subtotal, person.nama_person customer
			from retur_jual head
			inner join detail_retur_jual detail on detail.id_retur_jual=head.id_retur_jual
			left join person on person.id_person=head.id_customer
			where head.id_retur_jual in (
				select t.id_retur_jual
				from (
					select id_retur_jual, count(id_retur_jual) byk
					from stock
					left join detail_retur_jual on detail_retur_jual.batch=stock.batch
					where stock_awal=stock_sisa
					group by id_retur_jual
				)t
				inner join (
					select id_retur_jual, count(id_retur_jual) byk
					from stock
					left join detail_retur_jual on detail_retur_jual.batch=stock.batch
					group by id_retur_jual
				)t2 on t.id_retur_jual=t2.id_retur_jual and t.byk=t2.byk
			) and head.id_retur_jual not in (select id_transaksi from detail_pembayaran)
			group by head.id_retur_jual
		";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function retur_jual_detail()
    {
        $query = "
			select detail_retur_jual.*, item.nama, item.satuan, retur_jual.diskon diskon0
			from detail_retur_jual
			inner join retur_jual on detail_retur_jual.id_retur_jual=retur_jual.id_retur_jual
			left join item on item.id_item=detail_retur_jual.id_item
			where retur_jual.id_retur_jual in (
				select t.id_retur_jual
				from (
					select id_retur_jual, count(id_retur_jual) byk
					from stock
					left join detail_retur_jual on detail_retur_jual.batch=stock.batch
					where stock_awal=stock_sisa
					group by id_retur_jual
				)t
				inner join (
					select id_retur_jual, count(id_retur_jual) byk
					from stock
					left join detail_retur_jual on detail_retur_jual.batch=stock.batch
					group by id_retur_jual
				)t2 on t.id_retur_jual=t2.id_retur_jual and t.byk=t2.byk
			)and retur_jual.id_retur_jual not in (select id_transaksi from detail_pembayaran)
			group by detail_retur_jual.id_retur_jual, id_item
		";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function retur_jual_load($str)
    {
        $query = "
		select retur_jual.tgl_input, retur_jual.user_input, retur_jual.id_retur_jual, retur_jual.tgl_retur_jual, retur_jual.id_customer,
		retur_jual.tgl_TOP, retur_jual.diskon, retur_jual.keterangan,
		detail.id_item,	detail.harga, detail.qty, detail.diskon diskon_item, detail.subtotal,
		detail.keterangan keterangan_item, detail.batch, item.nama nama_item, item.satuan
		from retur_jual
		inner join detail_retur_jual detail on detail.id_retur_jual=retur_jual.id_retur_jual
		left join item on item.id_item=detail.id_item
		where retur_jual.id_retur_jual = ".$this->post($str);
        $query = $this->db->query($query);
        return $query->result();
    }
    public function retur_jual_baru()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $query = "select concat('RJ',lpad(ifnull(max(mid(id_retur_jual,3,length(id_retur_jual)-2)),0)+1,9,0)) indeks from log_detail_retur_jual where substring(id_retur_jual,1,2)='RJ'";
        $query = $this->db->query($query);
        $row = $query->result();

        $tgl_retur_jual = cetak_tgl($_POST['tgl_retur_jual']);

        $tgl_TOP=date_create($_POST['tgl_retur_jual']);
        date_add($tgl_TOP, date_interval_create_from_date_string(abs($_POST['jatuh_tempo'])." days"));

        foreach ($_POST['id_item'] as $key=>$value) {
            $query = " select concat('9',lpad(ifnull(max(mid(batch,2,length(batch)-1)),0)+1,11,0)) batch from ( select batch from log_detail_retur_jual UNION select batch from log_detail_pembelian )t where substring(batch,1,1)='9' ";
            $query = $this->db->query($query);
            $batch = $query->result();

            $query = "
			INSERT INTO `detail_retur_jual`(`id_retur_jual`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`) VALUES (
			".$this->post($row[0]->indeks).",".$this->post($_POST['id_item'][$key]).",".$this->post(cetak0($_POST['harga_item'][$key])).",
			".$this->post(cetak0($_POST['qty_item'][$key])).",".$this->post(cetak0($_POST['diskon_item'][$key])).",".$this->post(cetak0($_POST['subtotal_item'][$key])).",
			".$this->post(cetak0($_POST['keterangan_item'][$key])).",".$this->post($batch[0]->batch).")";
            $query = $this->db->query($query);

            $query = "
			insert into log_detail_retur_jual
			SELECT ".$this->post($tgl).",".$this->post($_SESSION['id_account']).", `id_retur_jual`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`,
			`keterangan`, `batch`
			FROM `detail_retur_jual`
			WHERE id_retur_jual=".$this->post($row[0]->indeks)." and id_item=".$this->post($_POST['id_item'][$key]);
            $query = $this->db->query($query);

            $query = "INSERT INTO `stock`(`tgl_input`, `id_item`, `stock_awal`, `stock_sisa`, `batch`, `gudang`) VALUES (
			".$this->post($tgl).",".$this->post($_POST['id_item'][$key]).",".$this->post(cetak0($_POST['qty_item'][$key])).",
			".$this->post(cetak0($_POST['qty_item'][$key])).",".$this->post($batch[0]->batch).", 'G000000001')";
            $query = $this->db->query($query);
        }
        $query = "
		INSERT INTO `retur_jual`(`tgl_input`, `user_input`, `id_retur_jual`, `tgl_retur_jual`, `id_customer`, `tgl_TOP`, `diskon`, `keterangan`) VALUES (
		".$this->post($tgl).",".$this->post($_SESSION['id_account']).",".$this->post($row[0]->indeks).",".$this->post($tgl_retur_jual).",
		".$this->post($_POST['id_customer']).",".$this->post(date_format($tgl_TOP, "Y-m-d")).",
		".$this->post(cetak0($_POST['diskon'])).",".$this->post($_POST['keterangan']).")";
        $query = $this->db->query($query);

        $query = "
			insert into log_retur_jual
			SELECT * FROM `retur_jual`
			where id_retur_jual=".$this->post($row[0]->indeks);
        $query = $this->db->query($query);

        $this->db->trans_complete();
        return true;
    }
    public function retur_jual_edit()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $tgl_retur_jual = cetak_tgl($_POST['tgl_retur_jual']);
        $tgl_TOP=date_create($_POST['tgl_retur_jual']);
        date_add($tgl_TOP, date_interval_create_from_date_string(abs($_POST['jatuh_tempo'])." days"));

        $query = "delete from stock where batch in (select batch from detail_retur_jual where id_retur_jual=".$this->post($_POST['id_retur_jual']).")";
        $query = $this->db->query($query);

        $query = "DELETE FROM `detail_retur_jual` WHERE id_retur_jual = ".$this->post($_POST['id_retur_jual']);
        $query = $this->db->query($query);

        foreach ($_POST['id_item'] as $key=>$value) {
            $query = " select concat('9',lpad(ifnull(max(mid(batch,2,length(batch)-1)),0)+1,11,0)) batch from ( select batch from log_detail_retur_jual UNION select batch from log_detail_pembelian )t where substring(batch,1,1)='9' ";
            $query = $this->db->query($query);
            $batch = $query->result();

            $query = "
			INSERT INTO `detail_retur_jual`(`id_retur_jual`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`) VALUES (
			".$this->post($_POST['id_retur_jual']).",".$this->post($_POST['id_item'][$key]).",".$this->post(cetak0($_POST['harga_item'][$key])).",
			".$this->post(cetak0($_POST['qty_item'][$key])).",".$this->post(cetak0($_POST['diskon_item'][$key])).",".$this->post(cetak0($_POST['subtotal_item'][$key])).",
			".$this->post(cetak0($_POST['keterangan_item'][$key])).",".$this->post($batch[0]->batch).")";
            $query = $this->db->query($query);

            $query = "
			insert into log_detail_retur_jual
			SELECT ".$this->post($tgl).",".$this->post($_SESSION['id_account']).", `id_retur_jual`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`,
			`keterangan`, `batch`
			FROM `detail_retur_jual`
			WHERE id_retur_jual=".$this->post($_POST['id_retur_jual'])." and id_item=".$this->post($_POST['id_item'][$key]);
            $query = $this->db->query($query);

            $query = "INSERT INTO `stock`(`tgl_input`, `id_item`, `stock_awal`, `stock_sisa`, `batch`, `gudang`) VALUES (
			".$this->post($tgl).",".$this->post($_POST['id_item'][$key]).",".$this->post(cetak0($_POST['qty_item'][$key])).",
			".$this->post(cetak0($_POST['qty_item'][$key])).",".$this->post($batch[0]->batch).", 'G000000001')";
            $query = $this->db->query($query);
        }

        $query = "
			UPDATE `retur_jual` SET `tgl_input`=".$this->post($tgl).",`user_input`=".$this->post($_SESSION['id_account']).",`tgl_retur_jual`=".$this->post($tgl_retur_jual).",
			`id_customer`=".$this->post($_POST['id_customer']).",`tgl_TOP`=".$this->post(date_format($tgl_TOP, "Y-m-d")).",
			`diskon`=".$this->post(cetak0($_POST['diskon'])).",`keterangan`=".$this->post($_POST['keterangan'])."
			WHERE id_retur_jual = ".$this->post($_POST['id_retur_jual']);
        $query = $this->db->query($query);

        $query = "
			insert into log_retur_jual
			SELECT * FROM `retur_jual`
			where id_retur_jual=".$this->post($_POST['id_retur_jual']);
        $query = $this->db->query($query);
        $this->db->trans_complete();
        return true;
    }
    public function ajax_retur_jual_hapus()
    {
        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $query = "
		select count(id_item) stock, (select count(id_item) from detail_retur_jual where id_retur_jual = ".$this->post($_POST['id_retur_jual']).") beli
		from stock
		where stock_awal=stock_sisa and batch in (select batch from detail_retur_jual where id_retur_jual = ".$this->post($_POST['id_retur_jual']).")";
        $query = $this->db->query($query);
        $query = $query->result();

        if ($query[0]->stock==$query[0]->beli) {
            $this->db->trans_strict(false);
            $this->db->trans_start();
            $query = "delete from stock where batch in (select batch from log_detail_retur_jual where id_retur_jual = ".$this->post($_POST['id_retur_jual']).")";
            $query = $this->db->query($query);
            $query = "delete from retur_jual where id_retur_jual = ".$this->post($_POST['id_retur_jual']);
            $query = $this->db->query($query);
            $query = "delete from detail_retur_jual where id_retur_jual = ".$this->post($_POST['id_retur_jual']);
            $query = $this->db->query($query);

            $query = "select * from stock where stock_sisa<0 or stock_sisa>stock_awal";
            $query = $this->db->query($query);
            if ($query->num_rows()>0) {
                $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Terjadi Kesalahan</div>');
                return false;
            } else {
                $this->db->trans_complete();
                return true;
            }
        } else {
            return false;
        }
    }
    public function check_retur_jual_id($str)
    {
        $query = "
			select case when batch=stock
			then true
			else false
			end nilai
			from(
				select id_retur_jual, COUNT(batch) batch, (
					select count(stock_awal)
					from stock
					where stock_awal=stock_sisa and batch in
						(select batch from detail_retur_jual where id_retur_jual = ".$this->post($str).")
				) stock
				from detail_retur_jual
				where id_retur_jual not in (select id_transaksi from detail_pembayaran) and
				id_retur_jual = ".$this->post($str)."
				group by id_retur_jual
			)t";
        $query = $this->db->query($query);
        $row = $query->result();
        if ($row[0]->nilai==1) {
            return true;
        } else {
            return false;
        }
    }


    //RETUR BELI
    public function retur_beli()
    {
        $query = "
			select head.*, sum(detail.subtotal) subtotal, person.nama_person supplier
			from retur_beli head
			inner join detail_retur_beli detail on detail.id_retur_beli=head.id_retur_beli
			left join person on person.id_person=head.id_supplier
			where head.id_retur_beli not in (select id_transaksi from detail_pembayaran)
			group by head.id_retur_beli
		";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function retur_beli_detail()
    {
        $query = "
			select detail_retur_beli.id_retur_beli, detail_retur_beli.id_item, harga, sum(qty) qty, detail_retur_beli.diskon,
			detail_retur_beli.subtotal, detail_retur_beli.keterangan, batch, nama, satuan, retur_beli.diskon diskon0
			from detail_retur_beli
			inner join retur_beli on detail_retur_beli.id_retur_beli=retur_beli.id_retur_beli
			left join item on item.id_item=detail_retur_beli.id_item
			where detail_retur_beli.id_retur_beli not in (select id_transaksi from detail_pembayaran)
			group by detail_retur_beli.id_retur_beli, id_item
		";
        $query = $this->db->query($query);
        return $query->result();
    }
    public function retur_beli_load($str)
    {
        $query = "
		select retur_beli.tgl_input, retur_beli.user_input, retur_beli.id_retur_beli, retur_beli.tgl_retur_beli, retur_beli.id_supplier,
		retur_beli.tgl_TOP, retur_beli.diskon, retur_beli.keterangan,
		detail.id_item,	detail.harga, sum(detail.qty) qty, detail.diskon diskon_item, detail.subtotal,
		detail.keterangan keterangan_item, detail.batch, item.nama nama_item, item.satuan
		from retur_beli
		inner join detail_retur_beli detail on detail.id_retur_beli=retur_beli.id_retur_beli
		left join item on item.id_item=detail.id_item
		where retur_beli.id_retur_beli = ".$this->post($str)."
        group by detail.id_item";

        $query = $this->db->query($query);
        return $query->result();
    }
    public function retur_beli_baru()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $tgl_retur_beli = cetak_tgl($_POST['tgl_retur_beli']);
        $tgl_TOP=date_create($_POST['tgl_retur_beli']);
        date_add($tgl_TOP, date_interval_create_from_date_string(abs($_POST['jatuh_tempo'])." days"));

        $query = "select concat('RB',lpad(ifnull(max(mid(id_retur_beli,3,length(id_retur_beli)-2)),0)+1,9,0)) indeks from log_detail_retur_beli where substring(id_retur_beli,1,2)='RB'";
        $query = $this->db->query($query);
        $row = $query->result();

        foreach ($_POST['id_item'] as $key=>$value) {
            $jmlh = str_replace(",", "", $_POST['qty_item'][$key]);
            while ($jmlh > 0) {
                $query = "
                    select tgl_input, id_item, stock.batch, stock_sisa
                    from stock
                    where stock_sisa<>0 and id_item = ".$this->post($_POST['id_item'][$key])."
                    order by tgl_input, batch DESC
                    limit 1";
                $query = $this->db->query($query);
                $batch = $query->result();
                $stock_sisa = $batch[0]->stock_sisa;

                if (($jmlh - $stock_sisa) >= 0) {
                    $kurang = $stock_sisa;
                } elseif (($jmlh - $stock_sisa) < 0) {
                    $kurang = $jmlh;
                }
                $jmlh = $jmlh - $kurang;
                $query = "
					UPDATE `stock` SET `stock_sisa`= stock_sisa - ".$this->post($kurang)."
					WHERE batch = ".$this->post($batch[0]->batch);
                $query = $this->db->query($query);

                $query = "
				INSERT INTO `detail_retur_beli`(`id_retur_beli`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`) VALUES (
				".$this->post($row[0]->indeks).",".$this->post($_POST['id_item'][$key]).",".$this->post(cetak0($_POST['harga_item'][$key])).",
				".$this->post($kurang).",".$this->post(cetak0($_POST['diskon_item'][$key])).",".$this->post(cetak0($_POST['subtotal_item'][$key])).",
				".$this->post(cetak0($_POST['keterangan_item'][$key])).",".$this->post($batch[0]->batch).")";

                $query = $this->db->query($query);


                $query = "
				insert into log_detail_retur_beli
				select ".$this->post($tgl).",".$this->post($_SESSION['id_account']).",
				`id_retur_beli`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`
				FROM `detail_retur_beli`
				where id_retur_beli=".$this->post($row[0]->indeks)." and id_item=".$this->post($_POST['id_item'][$key]). "and qty = ".$this->post($kurang);
                $query = $this->db->query($query);
            }
        }
        $query = "
		INSERT INTO `retur_beli`(`tgl_input`, `user_input`, `id_retur_beli`, `tgl_retur_beli`, `id_supplier`, `tgl_TOP`, `diskon`, `keterangan`) VALUES (
		".$this->post($tgl).",".$this->post($_SESSION['id_account']).",".$this->post($row[0]->indeks).",".$this->post($tgl_retur_beli).",
		".$this->post($_POST['id_supplier']).",".$this->post(date_format($tgl_TOP, "Y-m-d")).",
		".$this->post(cetak0($_POST['diskon'])).",".$this->post($_POST['keterangan']).")";
        $query = $this->db->query($query);

        $query = "
			insert into log_retur_beli
			SELECT * FROM `retur_beli`
			where id_retur_beli=".$this->post($row[0]->indeks).";";
        $query = $this->db->query($query);

        $query = "select * from stock where stock_sisa<0 or stock_sisa>stock_awal";
        $query = $this->db->query($query);
        if ($query->num_rows()>0) {
            $this->session->set_flashdata('retur_beli_modif', '<div class="alert alert-success text-center">Terjadi Kesalahan</div>');
            return false;
        } else {
            $this->db->trans_complete();
            return true;
        }
    }
    public function retur_beli_edit()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $tgl_retur_beli = cetak_tgl($_POST['tgl_retur_beli']);
        $tgl_TOP=date_create($_POST['tgl_retur_beli']);
        date_add($tgl_TOP, date_interval_create_from_date_string(abs($_POST['jatuh_tempo'])." days"));

        $query = "
			UPDATE stock
			INNER JOIN detail_retur_beli
			on detail_retur_beli.id_item=stock.id_item and detail_retur_beli.batch=stock.batch
			set stock.stock_sisa = stock.stock_sisa + detail_retur_beli.qty
			where id_retur_beli = ".$this->post($_POST['id_retur_beli']);
        $query = $this->db->query($query);

        $query = "delete from detail_retur_beli where id_retur_beli = ".$this->post($_POST['id_retur_beli']);
        $query = $this->db->query($query);

        foreach ($_POST['id_item'] as $key=>$value) {
            $jmlh = str_replace(",", "", $_POST['qty_item'][$key]);
            while ($jmlh > 0) {
                $query = "
                    select tgl_input, id_item, stock.batch, stock_sisa
                    from stock
                    where stock_sisa<>0 and id_item = ".$this->post($_POST['id_item'][$key])."
                    order by tgl_input, batch DESC
                    limit 1";
                $query = $this->db->query($query);
                $batch = $query->result();
                $stock_sisa = $batch[0]->stock_sisa;

                if (($jmlh - $stock_sisa) >= 0) {
                    $kurang = $stock_sisa;
                } elseif (($jmlh - $stock_sisa) < 0) {
                    $kurang = $jmlh;
                }
                $jmlh = $jmlh - $kurang;
                $query = "
					UPDATE `stock` SET `stock_sisa`= stock_sisa - ".$this->post($kurang)."
					WHERE batch = ".$this->post($batch[0]->batch);
                $query = $this->db->query($query);

                $query = "
				INSERT INTO `detail_retur_beli`(`id_retur_beli`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`) VALUES (
				".$this->post($_POST['id_retur_beli']).",".$this->post($_POST['id_item'][$key]).",".$this->post(cetak0($_POST['harga_item'][$key])).",
				".$this->post($kurang).",".$this->post(cetak0($_POST['diskon_item'][$key])).",".$this->post(cetak0($_POST['subtotal_item'][$key])).",
				".$this->post(cetak0($_POST['keterangan_item'][$key])).",".$this->post($batch[0]->batch).")";
                $query = $this->db->query($query);


                $query = "
				insert into log_detail_retur_beli
				select ".$this->post($tgl).",".$this->post($_SESSION['id_account']).",
				`id_retur_beli`, `id_item`, `harga`, `qty`, `diskon`, `subtotal`, `keterangan`, `batch`
				FROM `detail_retur_beli`
				where id_retur_beli=".$this->post($_POST['id_retur_beli'])." and id_item=".$this->post($_POST['id_item'][$key]). "and qty = ".$this->post($kurang);
                $query = $this->db->query($query);
            }
        }

        $query = "
			UPDATE `retur_beli` SET
			`tgl_input`=".$this->post($tgl).",`user_input`=".$this->post($_SESSION['id_account']).",`tgl_retur_beli`=".$this->post($tgl_retur_beli).",
			`id_supplier`=".$this->post($_POST['id_supplier']).",`tgl_TOP`=".$this->post(date_format($tgl_TOP, "Y-m-d")).",
			`diskon`=".$this->post(cetak0($_POST['diskon'])).",`keterangan`=".$this->post($_POST['keterangan'])."
			WHERE id_retur_beli = ".$this->post($_POST['id_retur_beli']);
        $query = $this->db->query($query);

        $query = "
			insert into log_retur_beli
			SELECT * FROM `retur_beli`
			where id_retur_beli=".$this->post($_POST['id_retur_beli']).";";
        $query = $this->db->query($query);

        $query = "select * from stock where stock_sisa<0 or stock_sisa>stock_awal";
        $query = $this->db->query($query);
        if ($query->num_rows()>0) {
            $this->session->set_flashdata('retur_beli_modif', '<div class="alert alert-success text-center">Terjadi Kesalahan</div>');
            return false;
        } else {
            $this->db->trans_complete();
            return true;
        }
    }
    public function ajax_retur_beli_hapus()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        $query = "delete from detail_retur_beli where id_retur_beli not in (select id_transaksi from detail_pembayaran) and id_retur_beli = ".$this->post($_POST['id_retur_beli']);
        $query = $this->db->query($query);

        $query = "delete from retur_beli where id_retur_beli not in (select id_transaksi from detail_pembayaran) and id_retur_beli = ".$this->post($_POST['id_retur_beli']);
        $query = $this->db->query($query);

        $query = "
			UPDATE stock
			INNER JOIN log_detail_retur_beli
			on log_detail_retur_beli.id_item=stock.id_item and log_detail_retur_beli.batch=stock.batch
			set stock.stock_sisa = stock.stock_sisa + log_detail_retur_beli.qty
			where id_retur_beli not in (select id_transaksi from detail_pembayaran) and id_retur_beli = ".$this->post($_POST['id_retur_beli']);
        $query = $this->db->query($query);

        $query = "select * from stock where stock_sisa<0 or stock_sisa>stock_awal";
        $query = $this->db->query($query);
        if ($query->num_rows()>0) {
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Terjadi Kesalahan</div>');
            return false;
        } else {
            $this->db->trans_complete();
            return true;
        }
    }
    public function check_retur_beli_id($str)
    {
        $query = "
			select id_retur_beli
			from retur_beli
			where id_retur_beli not in (select id_transaksi from detail_pembayaran) and id_retur_beli = ".$this->post($str);
        $query = $this->db->query($query);
        if ($query->num_rows()==1) {
            return true;
        } else {
            return false;
        }
    }


    //PEMBAYARAN
    public function pembayaran()
    {
        if (isset($_POST['dari']) && $_POST['dari']!='' && isset($_POST['sampai']) && $_POST['sampai']!='') {
            $dari = cetak_tgl($_POST['dari']);
            $sampai = cetak_tgl($_POST['sampai']);
            if ($_POST['jenis'] == 'penjualan') {
                $opsi1 = " and tgl_penjualan between ".$this->post($dari)." and ".$this->post($sampai);
                $opsi2 = " and tgl_retur_jual between ".$this->post($dari)." and ".$this->post($sampai);
            } else {
                $opsi1 = " and tgl_pembelian between ".$this->post($dari)." and ".$this->post($sampai);
                $opsi2 = " and tgl_retur_beli between ".$this->post($dari)." and ".$this->post($sampai);
            }
        } else {
            $opsi1 = '';
            $opsi2 = '';
        }

        if (isset($_POST['jenis']) && $_POST['jenis']=='penjualan') {
            $query = "
				select
					p.id_person, p.nama_person nama, '' no_po,
					t.tgl_transaksi tgl_transaksi, ifnull(t.id_transaksi,'-') id_transaksi, ifnull(t.diskon,0) diskon,
					ifnull(t.subtotal,0) subtotal, ifnull(saldo.nominal,0) bayar
				from person p
				left join (
					SELECT tgl_transaksi, id_transaksi, id_person, diskon, sum(subtotal) subtotal
					from
					(
						select b.tgl_penjualan tgl_transaksi, b.id_penjualan id_transaksi, b.id_customer id_person, b.diskon, b0.subtotal, sum(qty) qty, b0.id_item
						from penjualan b
						inner join detail_penjualan b0 on b0.id_penjualan=b.id_penjualan
						where b.id_penjualan not in (select id_transaksi from detail_pembayaran) ".$opsi1."
						group by b.id_penjualan, b0.id_item
					)t
					group by id_transaksi
					union all
					SELECT tgl_retur_jual, id_retur_jual, id_customer, diskon, sum(subtotal)*-1 subtotal
					from
					(
						select rb.tgl_retur_jual, rb.id_retur_jual, rb.id_customer, rb.diskon, rb0.subtotal, sum(qty) qty, rb0.id_item
						from retur_jual rb
						inner join detail_retur_jual rb0 on rb0.id_retur_jual=rb.id_retur_jual
						where rb.id_retur_jual not in (select id_transaksi from detail_pembayaran) ".$opsi2."
						group by rb.id_retur_jual, rb0.id_item
					)t
					group by id_retur_jual
				)t on p.id_person=t.id_person
				left join saldo on saldo.id_person=p.id_person
				where ((t.subtotal is not null and t.subtotal<>0) || (saldo.nominal is not null && saldo.nominal<>0) || p.id_person in (select id_person from pembayaran)) && p.jenis='customer' && t.id_transaksi is not null
				order by id_transaksi asc
			";
        } else {
            $query = "
				select
					p.id_person, p.nama_person nama, no_po,
					t.tgl_transaksi tgl_transaksi, ifnull(t.id_transaksi,'-') id_transaksi, ifnull(t.diskon,0) diskon,
					ifnull(t.subtotal,0) subtotal, ifnull(saldo.nominal,0) bayar
				from person p
				left join (
					SELECT tgl_transaksi, no_po, id_transaksi, id_person, diskon, sum(subtotal) subtotal
					from
					(
						select b.tgl_pembelian tgl_transaksi, b.no_bon no_po, b.id_pembelian id_transaksi, b.id_supplier id_person, b.diskon, b0.subtotal, sum(qty) qty, b0.id_item
						from pembelian b
						inner join detail_pembelian b0 on b0.id_pembelian=b.id_pembelian
						where b.id_pembelian not in (select id_transaksi from detail_pembayaran) ".$opsi1."
						group by b.id_pembelian, b0.id_item
					)t
					group by id_transaksi
					union all
					SELECT tgl_retur_beli, '', id_retur_beli, id_supplier, diskon, sum(subtotal)*-1 subtotal
					from
					(
						select rb.tgl_retur_beli, '', rb.id_retur_beli, rb.id_supplier, rb.diskon, rb0.subtotal, sum(qty) qty, rb0.id_item
						from retur_beli rb
						inner join detail_retur_beli rb0 on rb0.id_retur_beli=rb.id_retur_beli
						where rb.id_retur_beli not in (select id_transaksi from detail_pembayaran) ".$opsi2."
						group by rb.id_retur_beli, rb0.id_item
					)t
					group by id_retur_beli
				)t on p.id_person=t.id_person
				left join saldo on saldo.id_person=p.id_person
				where ((t.subtotal is not null and t.subtotal<>0) || (saldo.nominal is not null && saldo.nominal<>0) || p.id_person in (select id_person from pembayaran)) && p.jenis='supplier' && t.id_transaksi is not null
				order by id_transaksi asc
			";
        }
        $query = $this->db->query($query);

        return $query->result_array();
    }
    public function check_pembayaran_modif()
    {
        $query = "
		select id_person, nama_person from person where jenis in (select jenis from person where id_person=".$this->post($_POST['id_person']).") and
		id_person = ".$this->post($_POST['id_person'])." and nama_person = ".$this->post($_POST['nama_person']);
        $query = $this->db->query($query);
        $query = $query->num_rows();
        if ($query==1) {
            return true;
        } else {
            return false;
        }
    }
    public function pembayaran_baru()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        date_default_timezone_set("Asia/Bangkok");
        $tgl=date("Y-m-d H:i:s");

        $tgl_pembayaran = cetak_tgl($_POST['tgl_pembayaran']);

        $query = "select concat('Y',lpad(ifnull(max(mid(id_pembayaran,2,length(id_pembayaran)-1)),0)+1,9,0)) indeks from log_pembayaran where substring(id_pembayaran,1,1)='Y'";
        $query = $this->db->query($query);
        $row = $query->result();

        if (isset($_FILES) && $_FILES['gambar']['name']!='') {
            $temp = explode('.', htmlspecialchars($_FILES['gambar']['name'], ENT_QUOTES, 'UTF-8'));
            $_FILES['gambar']['name']=$row[0]->indeks.'.'.$temp[1];

            $config['upload_path']          = 'images/bayar';
            $config['allowed_types']        = 'gif|jpg|png|jpeg';
            $config['max_size']             = 2000;

            // $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('gambar')) {
                $this->session->set_flashdata('pembayaran_modif', '<div class="alert alert-danger text-center">'.$this->upload->display_errors().'</div>');
                return false;
            } else {
                $data = array('upload_data' => $this->upload->data());
                $gambar = $data['upload_data']['file_name'];
            }
        } else {
            $gambar = '';
        }

        $id_transaksi = (isset($_POST['transaksi']) ? "'".implode("','", $_POST['transaksi'])."'" : "''");
        $id_retur = (isset($_POST['retur']) ? "'".implode("','", $_POST['retur'])."'" : "''");

        $query = "select jenis from person where id_person=".$this->post($_POST['id_person']);
        $query = $this->db->query($query);
        $jenis = $query->result()[0]->jenis;

        if ($jenis == 'supplier') {
            $query = "
				SELECT id_transaksi, diskon, sum(subtotal) subtotal
				from
				(
					select b.id_pembelian id_transaksi, b.diskon, b0.subtotal, sum(qty) qty
					from pembelian b
					inner join detail_pembelian b0 on b0.id_pembelian=b.id_pembelian
					where b.id_pembelian not in (select id_transaksi from detail_pembayaran) and b.id_pembelian in (".$id_transaksi.")
					and id_supplier = ".$this->post($_POST['id_person'])."
					group by b.id_pembelian, b0.id_item
				)t
				group by id_transaksi
				union all
				SELECT id_retur_beli, diskon, sum(subtotal)*-1 subtotal
				from
				(
					select rb.id_retur_beli, rb.diskon, rb0.subtotal, sum(qty) qty
					from retur_beli rb
					inner join detail_retur_beli rb0 on rb0.id_retur_beli=rb.id_retur_beli
					where rb.id_retur_beli not in (select id_transaksi from detail_pembayaran) and rb.id_retur_beli in (".$id_retur.")
					and id_supplier = ".$this->post($_POST['id_person'])."
					group by rb.id_retur_beli, rb0.id_item
				)t
				group by id_retur_beli
			";
        } elseif ($jenis == 'customer') {
            $query = "
				SELECT id_transaksi, diskon, sum(subtotal) subtotal
				from
				(
					select b.id_penjualan id_transaksi, b.diskon, b0.subtotal, sum(qty) qty
					from penjualan b
					inner join detail_penjualan b0 on b0.id_penjualan=b.id_penjualan
					where b.id_penjualan not in (select id_transaksi from detail_pembayaran) and b.id_penjualan in (".$id_transaksi.")
					and id_customer = ".$this->post($_POST['id_person'])."
					group by b.id_penjualan, b0.id_item
				)t
				group by id_transaksi
				union all
				SELECT id_retur_jual, diskon, sum(subtotal)*-1 subtotal
				from
				(
					select rb.id_retur_jual, rb.diskon, rb0.subtotal, sum(qty) qty
					from retur_jual rb
					inner join detail_retur_jual rb0 on rb0.id_retur_jual=rb.id_retur_jual
					where rb.id_retur_jual not in (select id_transaksi from detail_pembayaran) and rb.id_retur_jual in (".$id_retur.")
					and id_customer = ".$this->post($_POST['id_person'])."
					group by rb.id_retur_jual, rb0.id_item
				)t
				group by id_retur_jual
			";
        }
        $query = $this->db->query($query);
        $nilai = $query->result();
        $temp = array();

        foreach ($nilai as $key=>$value) {
            $array = array(
                'id_transaksi' => $value->id_transaksi,
                'total' => hitung($value->subtotal, 1, $value->diskon)
            );
            $temp[]=$array;
        }

        $bayar = cetak0($_POST['bayar']);
        $tagihan = array_sum(array_column($temp, 'total'));
        $bayar = $bayar - $tagihan;

        foreach ($temp as $key=>$value) {
            $query = "
				INSERT INTO `detail_pembayaran`(`tgl_input`, `user_input`, `id_pembayaran`, `id_transaksi`, `nominal`) VALUES (
				".$this->post($tgl).",".$this->post($_SESSION['id_account']).",".$this->post($row[0]->indeks).",".$this->post($value['id_transaksi']).",
				".$this->post($value['total']).")
			";
            $query = $this->db->query($query);
        }

        $query = "
			INSERT INTO `pembayaran`(`tgl_input`, `user_input`, `id_pembayaran`, `tgl_pembayaran`, `id_person`, `nominal`, `keterangan`, `gambar`,`flag`) VALUES (
			".$this->post($tgl).",".$this->post($_SESSION['id_account']).",".$this->post($row[0]->indeks).",".$this->post(cetak_tgl($_POST['tgl_pembayaran'])).",
			".$this->post($_POST['id_person']).",".$this->post(cetak0($_POST['bayar'])).",".$this->post($_POST['keterangan']).",".$this->post($gambar).",'0')
		";
        $query = $this->db->query($query);

        $query = "
			select count(id_person) byk
			from saldo
			where id_person = ".$this->post($_POST['id_person']);
        $query = $this->db->query($query);
        $check = $query->result();
        $check = $check[0]->byk;

        if ($check == 0) {
            $query = "INSERT INTO `saldo`(`id_person`, `nominal`, `flag`) VALUES (".$this->post($_POST['id_person']).",".$this->post($bayar).",'1')";
        } else {
            $query = "UPDATE `saldo` SET `nominal`= nominal + ".$this->post($bayar)." WHERE id_person=".$this->post($_POST['id_person']);
        }

        $query = $this->db->query($query);

        $query = "
			select *
			from saldo
			left join
			(
				select id_person, ifnull(nominal,0) nominal
				from (
					select id_person, (sum(nominal) - sum(subtotal)) nominal
					from (
						select p.id_pembayaran, p.id_person, p.nominal, ifnull(sum(p0.nominal),0) subtotal
						from pembayaran p
						left join detail_pembayaran p0
						on p.id_pembayaran=p0.id_pembayaran
						group by p.id_pembayaran
					)t
					group by id_person
				)t2
			)t3
			on saldo.id_person=t3.id_person
			where saldo.nominal<>t3.nominal
		";
        $query = $this->db->query($query);

        if ($query->num_rows() > 0) {
            return false;
        } else {
            $query = "
				insert into log_detail_pembayaran
				SELECT * FROM `detail_pembayaran`
				where id_pembayaran=".$this->post($row[0]->indeks).";";
            $query = $this->db->query($query);

            $query = "
				insert into log_pembayaran
				SELECT * FROM `pembayaran`
				where id_pembayaran=".$this->post($row[0]->indeks).";";
            $query = $this->db->query($query);
            $this->db->trans_complete();
            return true;
        }
    }
    public function pembayaran_list()
    {
        $query = "select jenis from person where id_person=".$this->post($_GET['id_person']);
        $query = $this->db->query($query);
        if ($query->num_rows()==0) {
            $this->session->set_flashdata('pembayaran_list', '<div class="alert alert-danger text-center">Data tidak ditemukan</div>');
            return false;
        }
        $this->session->set_flashdata('pembayaran_list', '');
        $jenis = $query->result()[0]->jenis;

        $query = "
			select y.*, person.nama_person nama, account.nama_lengkap input
			from pembayaran y
			left join person on person.id_person=y.id_person
			left join account on account.id_account=y.user_input
			where y.id_person = ".$this->post($_GET['id_person'])."
			order by id_pembayaran asc
			";

        $query = $this->db->query($query);
        return $query->result();
    }
    public function detail_pembayaran_list()
    {
        $query = "select jenis from person where id_person=".$this->post($_GET['id_person']);
        $query = $this->db->query($query);
        $jenis = $query->result()[0]->jenis;

        if ($jenis == 'supplier') {
            $query = "
				select y0.*, case when b.tgl_pembelian is not null then b.tgl_pembelian else rb.tgl_retur_beli end tgl_transaksi
				from detail_pembayaran y0
				inner join pembayaran y on y.id_pembayaran=y0.id_pembayaran
				left join pembelian b on b.id_pembelian=y0.id_transaksi
				left join retur_beli rb on rb.id_retur_beli=y0.id_transaksi
				where y.id_person = ".$this->post($_GET['id_person']);
        } elseif ($jenis == 'customer') {
            $query = "
				select y0.*, case when j.tgl_penjualan is not null then j.tgl_penjualan else rj.tgl_retur_jual end tgl_transaksi
				from detail_pembayaran y0
				inner join pembayaran y on y.id_pembayaran=y0.id_pembayaran
				left join penjualan j on j.id_penjualan=y0.id_transaksi
				left join retur_jual rj on rj.id_retur_jual=y0.id_transaksi
				where y.id_person = ".$this->post($_GET['id_person']);
        }
        $query = $this->db->query($query);
        return $query->result();
    }
    public function ajax_pembayaran_hapus()
    {
        $this->db->trans_begin();

        $query = "select id_person from pembayaran where id_pembayaran=".$this->post($_POST['id_pembayaran']);
        $query = $this->db->query($query);
        $query = $query->result();
        $id_person = $query[0]->id_person;

        $query = "
			select id_pembayaran
			from pembayaran
			where id_person = ".$this->post($id_person)."
			order by id_pembayaran DESC
			limit 1
		";
        $query = $this->db->query($query);
        $query = $query->result();

        if ($query[0]->id_pembayaran != strtolower($_POST['id_pembayaran'])) {
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Terjadi Kesalahan</div>');
            return $query[0]->id_pembayaran.' = '.strtolower($_POST['id_pembayaran']);
        }

        $query = "delete from pembayaran where id_pembayaran = ".$this->post($_POST['id_pembayaran']);
        $query = $this->db->query($query);

        $query = "delete from detail_pembayaran where id_pembayaran = ".$this->post($_POST['id_pembayaran']);
        $query = $this->db->query($query);

        $query = "select * from stock where stock_sisa<0 or stock_sisa>stock_awal";
        $query = $this->db->query($query);
        if ($query->num_rows()>0) {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Terjadi Kesalahan</div>');
            return false;
        }

        $query = "
			update saldo
			left join (
				select id_person, ifnull(nominal,0) nominal
				from (
					select id_person, (sum(nominal) - sum(subtotal)) nominal
					from (
						select p.id_pembayaran, p.id_person, p.nominal, ifnull(sum(p0.nominal),0) subtotal
						from pembayaran p
						left join detail_pembayaran p0
						on p.id_pembayaran=p0.id_pembayaran
						where id_person = ".$this->post($id_person)."
						group by p.id_pembayaran
					)t
					group by id_person
				)t2
			)t3
			on saldo.id_person = t3.id_person
			set saldo.nominal = ifnull(t3.nominal,0)
			where saldo.id_person = ".$this->post($id_person);
        $query = $this->db->query($query);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    public function check_pembayaran_transaksi()
    {
        if ($_POST['sisa']=='') {
            $_POST['sisa']=0;
        }

        $query = "select jenis from person where id_person = ".$this->post($_POST['id_person']);
        $query = $this->db->query($query);
        $query = $query->result();
        $jenis = $query[0]->jenis;


        // check sisa
        $query = "
			select
				case when ifnull(sum(nominal),0) = ".$this->post(cetak0($_POST['sisa']))."
				then 'yes'
				else 'no'
				end `check`
			from saldo
			where id_person = ".$this->post($_POST['id_person'])."
		";
        $query = $this->db->query($query);
        $query = $query->result();
        $check = $query[0]->check;
        if ($check == 'no') {
            return 'nominal sisa tidak sesuai';
        }

        //check id_transaksi
        if ($jenis == 'supplier') {
            if (isset($_POST['transaksi'])) {
                foreach ($_POST['transaksi'] as $key=>$value) {
                    if ($value=='') {
                        continue;
                    }
                    $query = "select count(id_pembelian) byk from pembelian where id_pembelian = ".$this->post($value);
                    $query = $this->db->query($query);
                    $query = $query->result();
                    if ($query[0]->byk != 1) {
                        return $value.' tidak ditemukan';
                    }
                }
            }
            if (isset($_POST['retur'])) {
                foreach ($_POST['retur'] as $key=>$value) {
                    if ($value=='') {
                        continue;
                    }
                    $query = "select count(id_retur_beli) byk from retur_beli where id_retur_beli = ".$this->post($value);
                    $query = $this->db->query($query);
                    $query = $query->result();
                    if ($query[0]->byk != 1) {
                        return $value.' tidak ditemukan';
                    }
                }
            }
        } elseif ($jenis == 'customer') {
            if (isset($_POST['transaksi'])) {
                foreach ($_POST['transaksi'] as $key=>$value) {
                    $query = "select count(id_penjualan) byk from penjualan where id_penjualan = ".$this->post($value);
                    $query = $this->db->query($query);
                    $query = $query->result();
                    if ($query[0]->byk != 1) {
                        return $value.' tidak ditemukan';
                    }
                }
            }
            if (isset($_POST['retur'])) {
                foreach ($_POST['retur'] as $key=>$value) {
                    $query = "select count(id_retur_jual) byk from retur_jual where id_retur_jual = ".$this->post($value);
                    $query = $this->db->query($query);
                    $query = $query->result();
                    if ($query[0]->byk != 1) {
                        return $value.' tidak ditemukan';
                    }
                }
            }
        }

        //check pembelian
        $id_transaksi = (isset($_POST['transaksi']) ? "'".implode("','", $_POST['transaksi'])."'" : "''");
        $id_retur = (isset($_POST['retur']) ? "'".implode("','", $_POST['retur'])."'" : "''");

        if ($jenis == 'supplier') {
            $query = "
				SELECT id_transaksi, diskon, sum(subtotal) subtotal
				from
				(
					select b.id_pembelian id_transaksi, b.diskon, b0.subtotal, sum(qty) qty
					from pembelian b
					inner join detail_pembelian b0 on b0.id_pembelian=b.id_pembelian
					where b.id_pembelian not in (select id_transaksi from detail_pembayaran) and b.id_pembelian in (".$id_transaksi.")
					and id_supplier = ".$this->post($_POST['id_person'])."
					group by b.id_pembelian, b0.id_item
				)t
				group by id_transaksi
				union all
				SELECT id_retur_beli, diskon, sum(subtotal)*-1 subtotal
				from
				(
					select rb.id_retur_beli, rb.diskon, rb0.subtotal, sum(qty) qty
					from retur_beli rb
					inner join detail_retur_beli rb0 on rb0.id_retur_beli=rb.id_retur_beli
					where rb.id_retur_beli not in (select id_transaksi from detail_pembayaran) and rb.id_retur_beli in (".$id_retur.")
					and id_supplier = ".$this->post($_POST['id_person'])."
					group by rb.id_retur_beli, rb0.id_item
				)t
				group by id_retur_beli
			";
        } elseif ($jenis == 'customer') {
            $query = "
				SELECT id_transaksi, diskon, sum(subtotal) subtotal
				from
				(
					select b.id_penjualan id_transaksi, b.diskon, b0.subtotal, sum(qty) qty
					from penjualan b
					inner join detail_penjualan b0 on b0.id_penjualan=b.id_penjualan
					where b.id_penjualan not in (select id_transaksi from detail_pembayaran) and b.id_penjualan in (".$id_transaksi.")
					and id_customer = ".$this->post($_POST['id_person'])."
					group by b.id_penjualan, b0.id_item
				)t
				group by id_transaksi
				union all
				SELECT id_retur_jual, diskon, sum(subtotal)*-1 subtotal
				from
				(
					select rb.id_retur_jual, rb.diskon, rb0.subtotal, sum(qty) qty
					from retur_jual rb
					inner join detail_retur_jual rb0 on rb0.id_retur_jual=rb.id_retur_jual
					where rb.id_retur_jual not in (select id_transaksi from detail_pembayaran) and rb.id_retur_jual in (".$id_retur.")
					and id_customer = ".$this->post($_POST['id_person'])."
					group by rb.id_retur_jual, rb0.id_item
				)t
				group by id_retur_jual
			";
        }

        $query = $this->db->query($query);
        $nilai = $query->result();
        $temp = array();

        foreach ($nilai as $key=>$value) {
            $array = array(
                'id_transaksi' => $value->id_transaksi,
                'total' => hitung($value->subtotal, 1, $value->diskon)
            );
            $temp[]=$array;
        }

        $bayar = cetak0($_POST['bayar'])+cetak0($_POST['sisa']);
        $tagihan = array_sum(array_column($temp, 'total'));
        if (($bayar - $tagihan) < 0) {
            return 'nominal bayar terlalu kecil';
        }
        return 'ok';
    }


    //REPORT
    public function report()
    {
        if ($_POST['jenis']=='omset') {
            $query = "
				select jual.tgl_penjualan, t.id_penjualan, t.id_pembelian, sum(t.qty) qty, sum(subtotal_beli) subtotal_beli, sum(subtotal_jual) subtotal_jual,
				customer.nama_person customer
				from (
					select jual.id_penjualan,
					case
						when beli.id_pembelian is not null then beli.id_pembelian
						else rj.id_retur_jual end id_pembelian
					, jual.id_item, jual.qty, jual.qty*(jual.subtotal/total.total_qty) subtotal_jual, jual.batch,
					case
						when beli.subtotal is not null then (beli.subtotal/beli.qty)*jual.qty
						else (rj.subtotal/rj.qty)*jual.qty end subtotal_beli
					from detail_penjualan jual
					left join detail_pembelian beli on beli.batch=jual.batch
					left join detail_retur_jual rj on rj.batch=jual.batch
					left join (
						select id_penjualan, id_item, sum(qty) total_qty
						from detail_penjualan
						where id_penjualan in
							(select id_penjualan from penjualan where tgl_penjualan BETWEEN ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai'])).")
						group by id_penjualan, id_item
					)total on total.id_penjualan = jual.id_penjualan and total.id_item = jual.id_item
					where jual.id_penjualan in
						(select id_penjualan from penjualan where tgl_penjualan BETWEEN ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai'])).")
				)t
				left join penjualan jual on jual.id_penjualan=t.id_penjualan
				left join pembelian beli on beli.id_pembelian=t.id_pembelian
				left join detail_retur_jual rj on rj.id_retur_jual=t.id_pembelian
				left join item on item.id_item=t.id_item
				left join person customer on customer.id_person=jual.id_customer
				group by t.id_penjualan
			";
        } elseif ($_POST['jenis']=='retur_beli') {
            $query = "
				select head.*, sum(detail.subtotal) subtotal, person.nama_person supplier
				from retur_beli head
				inner join detail_retur_beli detail on detail.id_retur_beli=head.id_retur_beli
				left join person on person.id_person=head.id_supplier
				where tgl_retur_beli BETWEEN ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai']))."
				group by head.id_retur_beli
			";
        } elseif ($_POST['jenis']=='retur_jual') {
            $query = "
				select head.*, sum(detail.subtotal) subtotal, person.nama_person customer
				from retur_jual head
				inner join detail_retur_jual detail on detail.id_retur_jual=head.id_retur_jual
				left join person on person.id_person=head.id_customer
				where head.tgl_retur_jual BETWEEN ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai']))."
				group by head.id_retur_jual
			";
        } elseif ($_POST['jenis']=='penjualan') {
            $query = "
				select tgl_input, 	user_input, 	id_penjualan, 	tgl_penjualan, 	id_customer, 	id_sales, 	tgl_TOP, 	diskon, 	keterangan, sum(subtotal) subtotal, 	customer, 	sales, sum(qty) qty
				from (
					select head.*, sum(detail.qty) qty, detail.subtotal, customer.nama_person customer, sales.nama_person sales
					from penjualan head
					inner join detail_penjualan detail on detail.id_penjualan=head.id_penjualan
					left join person customer on customer.id_person=head.id_customer
					left join person sales on sales.id_person=head.id_sales
					where head.id_penjualan in
						(select id_penjualan from penjualan where tgl_penjualan BETWEEN ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai'])).")
					group by head.id_penjualan, detail.id_item
				)t
				group by id_penjualan
			";
        } elseif ($_POST['jenis']=='pembelian') {
            $query = "
				select pembelian.*, person.nama_person, sum(subtotal) subtotal
				from pembelian
				inner join detail_pembelian on detail_pembelian.id_pembelian=pembelian.id_pembelian
				left join person on person.id_person=pembelian.id_supplier
				where pembelian.tgl_pembelian between ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai']))."
				group by pembelian.id_pembelian
			";
        } elseif ($_POST['jenis']=='stock') {
            $query = "
				SELECT stock.id_item, item.nama, min(tgl_input) tgl_input, sum(stock_sisa) stock_sisa, item.satuan
				FROM stock
				left join item on item.id_item=stock.id_item
				group by stock.id_item, item.nama
			";
        } elseif ($_POST['jenis']=='pembayaran') {
            $query = "
				select y.*, person.nama_person nama, account.nama_lengkap input
				from pembayaran y
				left join person on person.id_person=y.id_person
				left join account on account.id_account=y.user_input
				where y.tgl_pembayaran between ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai']))
            ;
        } else {
            echo 'else';
            pre($_POST);
            exit();
        }
        // pre($query);
        $query = $this->db->query($query);
        return $query->result();
    }
    public function detail_report()
    {
        if ($_POST['jenis']=='omset') {
            $query = "
				select t.*, item.nama, item.satuan, customer.nama_person customer, supplier.nama_person supplier, jual.diskon diskon0,
				case when beli.diskon is not null then beli.diskon
				else rj.diskon end diskon1
				from (
					select jual.id_penjualan,
					case
						when beli.id_pembelian is not null then beli.id_pembelian
						else rj.id_retur_jual end id_pembelian
					, jual.id_item, jual.qty, jual.qty*(jual.subtotal/total.total_qty) subtotal_jual, jual.batch,
					case
						when beli.subtotal is not null then (beli.subtotal/beli.qty)
						else (rj.subtotal/rj.qty) end beli
					from detail_penjualan jual
					left join detail_pembelian beli on beli.batch=jual.batch
					left join detail_retur_jual rj on rj.batch=jual.batch
					left join (
						select id_penjualan, id_item, sum(qty) total_qty
						from detail_penjualan
						where id_penjualan in
							(select id_penjualan from penjualan where tgl_penjualan BETWEEN ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai'])).")
						group by id_penjualan, id_item
					)total on total.id_penjualan = jual.id_penjualan and total.id_item = jual.id_item
					where jual.id_penjualan in
						(select id_penjualan from penjualan where tgl_penjualan BETWEEN ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai'])).")
				)t
				left join penjualan jual on jual.id_penjualan=t.id_penjualan
				left join pembelian beli on beli.id_pembelian=t.id_pembelian
				left join detail_retur_jual rj on rj.id_retur_jual=t.id_pembelian
				left join item on item.id_item=t.id_item
				left join person customer on customer.id_person=jual.id_customer
				left join person supplier on supplier.id_person=beli.id_supplier
			";
        } elseif ($_POST['jenis']=='retur_beli') {
            $query = "
				select detail_retur_beli.id_retur_beli, detail_retur_beli.id_item, harga, sum(qty) qty, detail_retur_beli.diskon,
				detail_retur_beli.subtotal, detail_retur_beli.keterangan, batch, nama, satuan, retur_beli.diskon diskon0
				from detail_retur_beli
				inner join retur_beli on detail_retur_beli.id_retur_beli=retur_beli.id_retur_beli
				left join item on item.id_item=detail_retur_beli.id_item
				where detail_retur_beli.id_retur_beli in
					(select id_retur_beli from retur_beli where tgl_retur_beli BETWEEN ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai'])).")
				group by detail_retur_beli.id_retur_beli, id_item
			";
        } elseif ($_POST['jenis']=='retur_jual') {
            $query = "
				select detail_retur_jual.*, item.nama, item.satuan, retur_jual.diskon diskon0
				from detail_retur_jual
				inner join retur_jual on detail_retur_jual.id_retur_jual=retur_jual.id_retur_jual
				left join item on item.id_item=detail_retur_jual.id_item
				where detail_retur_jual.id_retur_jual in
					(select id_retur_jual from retur_jual where tgl_retur_jual BETWEEN ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai'])).")
				group by detail_retur_jual.id_retur_jual, id_item
			";
        } elseif ($_POST['jenis']=='penjualan') {
            $query = "
				select detail_penjualan.id_penjualan, detail_penjualan.id_item, harga, sum(qty) qty, detail_penjualan.diskon,
				detail_penjualan.subtotal, detail_penjualan.keterangan, batch, nama, satuan, penjualan.diskon diskon0
				from detail_penjualan
				inner join penjualan on detail_penjualan.id_penjualan=penjualan.id_penjualan
				left join item on item.id_item=detail_penjualan.id_item
				where penjualan.id_penjualan in
					(select id_penjualan from penjualan where tgl_penjualan BETWEEN ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai'])).")
				group by detail_penjualan.id_penjualan, id_item
			";
        } elseif ($_POST['jenis']=='pembelian') {
            $query = "
				select detail_pembelian.*, item.nama, item.satuan, pembelian.diskon diskon0
				from detail_pembelian
				inner join pembelian on pembelian.id_pembelian=detail_pembelian.id_pembelian
				left join item on item.id_item=detail_pembelian.id_item
				where detail_pembelian.id_pembelian in (
					select id_pembelian
					from pembelian
					where pembelian.tgl_pembelian between ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai']))."
				)
			";
        } elseif ($_POST['jenis']=='pembayaran') {
            $query = "
				select y0.*,
					case
						when j.tgl_penjualan is not null then j.tgl_penjualan
						when rj.tgl_retur_jual is not null then rj.tgl_retur_jual
						when b.tgl_pembelian is not null then b.tgl_pembelian
						when rb.tgl_retur_beli is not null then rb.tgl_retur_beli
					else ''
					end tgl_transaksi
				from detail_pembayaran y0
				inner join pembayaran y on y.id_pembayaran=y0.id_pembayaran
				left join penjualan j on j.id_penjualan=y0.id_transaksi
				left join retur_jual rj on rj.id_retur_jual=y0.id_transaksi
				left join pembelian b on b.id_pembelian=y0.id_transaksi
				left join retur_beli rb on rb.id_retur_beli=y0.id_transaksi
				where y.tgl_pembayaran between ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai']))."
			";
        } elseif ($_POST['jenis']=='stock') {
            $query = "
				select t.tgl_input, t.id_item, item.nama item, id_transaksi, tgl_transaksi, person.nama_person person, sum(qty) qty, subtotal, diskon0, item.satuan
				from (
					select pembelian.tgl_input, stock.id_item, pembelian.no_bon id_transaksi, tgl_pembelian tgl_transaksi, pembelian.id_supplier id_person, harga, qty, detail_pembelian.diskon, subtotal, pembelian.diskon diskon0
					from stock
					INNER join detail_pembelian on detail_pembelian.batch=stock.batch
					INNER join pembelian on detail_pembelian.id_pembelian=pembelian.id_pembelian
					where tgl_pembelian between ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai']))."
					UNION ALL
					select penjualan.tgl_input, stock.id_item, detail_penjualan.id_penjualan, penjualan.tgl_penjualan, penjualan.id_customer,
					harga, qty*-1 qty, detail_penjualan.diskon, subtotal, penjualan.diskon diskon0
					from stock
					INNER join detail_penjualan on detail_penjualan.batch=stock.batch
					INNER join penjualan on detail_penjualan.id_penjualan=penjualan.id_penjualan
					where tgl_penjualan between ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai']))."
					UNION ALL
					select retur_jual.tgl_input, stock.id_item, detail_retur_jual.id_retur_jual, retur_jual.tgl_retur_jual, retur_jual.id_customer,
					harga, qty, detail_retur_jual.diskon, subtotal, retur_jual.diskon diskon0
					from stock
					INNER join detail_retur_jual on detail_retur_jual.batch=stock.batch
					INNER join retur_jual on detail_retur_jual.id_retur_jual=retur_jual.id_retur_jual
					where tgl_retur_jual between ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai']))."
					UNION ALL
					select retur_beli.tgl_input, stock.id_item, detail_retur_beli.id_retur_beli, retur_beli.tgl_retur_beli, retur_beli.id_supplier,
					harga, qty*-1 qty, detail_retur_beli.diskon, subtotal, retur_beli.diskon diskon0
					from stock
					INNER join detail_retur_beli on detail_retur_beli.batch=stock.batch
					INNER join retur_beli on detail_retur_beli.id_retur_beli=retur_beli.id_retur_beli
					where tgl_retur_beli between ".$this->post(cetak_tgl($_POST['dari']))." and ".$this->post(cetak_tgl($_POST['sampai']))."
				)t
				left join item on item.id_item=t.id_item
				left join person on person.id_person=t.id_person
				group by id_transaksi, t.id_item, tgl_input
				order by tgl_input asc";
        } else {
            return true;
        }
        // pre($query);
        $query = $this->db->query($query);
        return $query->result();
    }
    public function ajax_print_all()
    {
        $query = "
				SELECT stock.id_item, item.nama, min(tgl_input) tgl_input, sum(stock_sisa) stock_sisa, item.satuan
				FROM stock
				left join item on item.id_item=stock.id_item
				group by stock.id_item, item.nama
		";
        $query = $this->db->query($query);
        return $query->result();
    }


    //MENU
    public function menu_update()
    {
        $this->db->trans_strict(false);
        $this->db->trans_start();

        $cuek = array('uniqid','ci_csrf_token','id_account','submit');
        $query = "delete from menu where id_account = ".$this->post($_POST['id_account']);
        $query = $this->db->query($query);
        foreach ($_POST as $key=>$value) {
            if (!(in_array($key, $cuek))) {
                $value = array_map('strtolower', $value);
                $nilai = implode(', ', $value);
                if (!(in_array('view', $value))) {
                    $nilai = 'view, '.$nilai;
                }
                $query = "
					INSERT INTO `menu`
					(`id_account`, `bagian`, `hak`, `flag`) VALUES
					(".$this->post($_POST['id_account']).",".$this->post($key).",".$this->post($nilai).",".$this->post('0').")
				";
                $query = $this->db->query($query);
            }
        }
        $this->db->trans_complete();
        return true;
    }
    public function menu_load($str)
    {
        $query = "select * from menu where id_account = ".$this->post($str);
        $query = $this->db->query($query);
        return $query->result();
    }
    public function check_menu($menulist)
    {
        $temp = true;
        $cuek = array('uniqid','ci_csrf_token','id_account','submit');
        foreach ($_POST as $key=>$value) {
            if (!(in_array($key, $cuek)) && $temp==true) {
                if (is_array($value)) {
                    $value = array_map('strtolower', $value);
                    foreach ($value as $key2=>$value2) {
                        if (empty($menulist[strtolower($key)][$value2])) {
                            $temp = false;
                        }
                    }
                } else {
                    $temp = false;
                }
            }
        }
        return $temp;
    }

    public function post($str)
    {
        return $this->db->escape($this->security->xss_clean(trim(strtolower($str))));
    }
}
