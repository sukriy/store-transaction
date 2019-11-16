<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends CI_Controller {
	public function index(){ 
		if($this->session->userdata('id_account')==''){
			$this->load->view('page/sign_in');
		}else{
			$data = $this->check();
			$this->load->view('page/home',$data);
		}
	}
	function csrf_redirect(){
		// $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">CRSF code error</div>');
		redirect($this->agent->referrer());
	}
	public function menu(){
		$data['menulist'] = array(
			'account' => array(
				'view' => array(
					'controller' => 'account',
					'link' => "<li>".anchor(base_url('Admin/Account'),  '<i class="menu-icon fa fa-users"></i>Account')."</li>",
					'parameter' => ''
				),
				'baru' => array(
					'controller' => 'account_modif',
					'link' => "",
					'parameter' => 'baru'
				),
				'edit' => array(
					'controller' => 'account_modif',
					'link' => "",
					'parameter' => 'edit'
				),
				'hapus' => array(
					'controller' => 'ajax_account_hapus',
					'link' => "",
					'parameter' => ''
				)
			),
			'custom' => array(
				'view' => array(
					'controller' => 'custom',
					'link' => "<li>".anchor(base_url('Admin/Custom'),  '<i class="menu-icon fa fa-cogs"></i>Custom')."</li>",
					'parameter' => ''
				),
				'baru' => array(
					'controller' => 'custom_modif',
					'link' => "",
					'parameter' => 'baru'
				),
				'edit' => array(
					'controller' => 'custom_modif',
					'link' => "",
					'parameter' => 'edit'
				),
				'hapus' => array(
					'controller' => 'ajax_custom_hapus',
					'link' => "",
					'parameter' => ''
				)
			),
			'item' => array(
				'view' => array(
					'controller' => 'item',
					'link' => "<li>".anchor(base_url('Admin/Item'),  '<i class="menu-icon fa fa-puzzle-piece"></i>Item')."</li>",					
					'parameter' => ''
				),
				'baru' => array(
					'controller' => 'item_modif',
					'link' => "",
					'parameter' => 'baru'
				),
				'edit' => array(
					'controller' => 'item_modif',
					'link' => "",
					'parameter' => 'edit'
				),
				'hapus' => array(
					'controller' => 'ajax_item_hapus',
					'link' => "",
					'parameter' => ''
				)
			),
			'person' => array(
				'view' => array(
					'controller' => 'person',
					'link' => "<li>".anchor(base_url('Admin/Person'),  '<i class="menu-icon fa fa-users"></i>Person')."</li>",					
					'parameter' => ''
				),
				'baru' => array(
					'controller' => 'person_modif',
					'link' => "",
					'parameter' => 'baru'
				),
				'edit' => array(
					'controller' => 'person_modif',
					'link' => "",
					'parameter' => 'edit'
				),
				'hapus' => array(
					'controller' => 'ajax_person_hapus',
					'link' => "",
					'parameter' => ''
				)
			),
			'pembelian' => array(
				'view' => array(
					'controller' => 'pembelian',
					'link' => "<li>".anchor(base_url('Admin/Pembelian'),  '<i class="menu-icon fa fa-shopping-cart"></i>Beli')."</li>",
					'parameter' => ''
				),
				'baru' => array(
					'controller' => 'pembelian_modif',
					'link' => "",
					'parameter' => 'baru'
				),
				'edit' => array(
					'controller' => 'pembelian_modif',
					'link' => "",
					'parameter' => 'edit'
				),
				'hapus' => array(
					'controller' => 'ajax_pembelian_hapus',
					'link' => "",
					'parameter' => ''
				)
			),
			'penjualan' => array(
				'view' => array(
					'controller' => 'Penjualan',
					'link' => "<li>".anchor(base_url('Admin/Penjualan'),  '<i class="menu-icon fa fa-list"></i>Jual')."</li>",
					'parameter' => ''
				),
				'baru' => array(
					'controller' => 'penjualan_modif',
					'link' => "",
					'parameter' => 'baru'
				),
				'edit' => array(
					'controller' => 'penjualan_modif',
					'link' => "",
					'parameter' => 'edit'
				),
				'hapus' => array(
					'controller' => 'ajax_penjualan_hapus',
					'link' => "",
					'parameter' => ''
				)
			),
			'retur_beli' => array(
				'view' => array(
					'controller' => 'retur_beli',
					'link' => "<li>".anchor(base_url('Admin/retur_beli'),  '<i class="menu-icon fa fa-shopping-cart"></i>Retur Beli')."</li>",
					'parameter' => ''
				),
				'baru' => array(
					'controller' => 'retur_beli',
					'link' => "",
					'parameter' => 'baru'
				),
				'edit' => array(
					'controller' => 'retur_beli',
					'link' => "",
					'parameter' => 'edit'
				),
				'hapus' => array(
					'controller' => 'ajax_retur_beli_hapus',
					'link' => "",
					'parameter' => ''
				)
			),
			'retur_jual' => array(
				'view' => array(
					'controller' => 'retur_jual',
					'link' => "<li>".anchor(base_url('Admin/retur_jual'),  '<i class="menu-icon fa fa-list"></i>Retur Jual')."</li>",
					'parameter' => ''
				),
				'baru' => array(
					'controller' => 'retur_jual',
					'link' => "",
					'parameter' => 'baru'
				),
				'edit' => array(
					'controller' => 'retur_jual',
					'link' => "",
					'parameter' => 'edit'
				),
				'hapus' => array(
					'controller' => 'ajax_retur_jual_hapus',
					'link' => "",
					'parameter' => ''
				)
			),
			'pembayaran' => array(
				'view' => array(
					'controller' => 'pembayaran',
					'link' => "<li>".anchor(base_url('Admin/Pembayaran'),  '<i class="menu-icon fa fa-money"></i>Bayar')."</li>",
					'parameter' => ''
				),
				'bayar' => array(
					'controller' => 'pembayaran_modif',
					'link' => "",
					'parameter' => 'bayar'
				),
				'edit' => array(
					'controller' => 'pembayaran',
					'link' => "",
					'parameter' => 'edit'
				),
				'hapus' => array(
					'controller' => 'ajax_pembayaran_hapus',
					'link' => "",
					'parameter' => ''
				)
			),
			'report' => array(
				'view' => array(
					'controller' => 'Report',
					'link' => "<li>".anchor(base_url('Admin/Report'),  '<i class="menu-icon fa fa-table"></i>Report')."</li>",
					'parameter' => 'load'
				)
			),
			'hak_akses' => array(
				'view' => array(
					'controller' => 'menu_list',
					'link' => "<li>".anchor(base_url('Admin/menu_list'),  '<i class="menu-icon fa fa-table"></i>Hak Akses')."</li>",
					'parameter' => ''
				),
				'edit' => array(
					'controller' => 'menu_list',
					'link' => "",
					'parameter' => 'edit'
				)
			)
		);
		$data['hak_akses'][$_SESSION['id_account']] = array();
		if(isset($_SESSION['id_account'])){
			$menu_load = $this->db1->menu_load($_SESSION['id_account']);
			foreach($menu_load as $key=>$value){
				$data['hak_akses'][$_SESSION['id_account']][$value->bagian]=explode(', ',$value->hak);
			}
		}
		return $data;
	}	
	public function check(){
		if(isset($_SESSION['id_account'])){
			$data = $this->menu();
			if($_SESSION['id_account']!='a000000000'){
				$ada = 9;
				foreach($data['menulist'] as $key=>$value){
					foreach($value as $key2=>$value2){
						if(strtolower($value2['controller'])==strtolower($this->router->fetch_method()) && $ada!=1){
							$ada = 0;
							if(isset($_POST['submit']) && $_POST['submit']!=$value2['parameter']){
								continue; 
							}
							if(isset($data['hak_akses'][$_SESSION['id_account']][$key])){
								$nilai = implode(",",$data['hak_akses'][$_SESSION['id_account']][$key]);
								$nilai = explode(",",$nilai);
								if (in_array($key2, $nilai)){
									$ada = 1;
								}
							}
						}
					}
				}
				if($ada == 0){
					$this->session->set_flashdata('hak_akses', '<div class="alert alert-danger text-center">Anda Tidak punya akses</div>');
					redirect('Admin');
				} 
			}else{
				foreach($data['menulist'] as $key=>$value){
					foreach($value as $key2=>$value2){
						$data['hak_akses'][$_SESSION['id_account']][$key][]=$key2;
					}
				}
			}
			return $data;
		}else{
			redirect('Admin');
		}
	}
	public function sign_in(){
		if(isset($_POST['submit'])){
			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
		
			$sign_in = $this->db1->sign_in();
			if($sign_in==FALSE){
				$this->session->set_flashdata('sign_in', '<div class="alert alert-danger text-center">Username / Password Salah</div>');
				$this->load->view('page/sign_in');
			}else{
				$newdata = array(
					'id_account'  => $sign_in[0]->id_account,
					'username'  => $sign_in[0]->username,
					'nama_lengkap'  => $sign_in[0]->nama_lengkap,
					'gambar' => $sign_in[0]->gambar,
					'form_key' => ''
				);
				$this->session->set_userdata($newdata);
				redirect('Admin');
			}
		}else{
			redirect('Admin');
		}
	}
	public function coba(){
		// $data = $this->check();
		// $hak = $data['hak_akses'][$_SESSION['id_account']]['item'];
		// pre($hak);
		
		$this->load->view('user_view');
	}
	public function get_autocomplete(){
		if (isset($_GET['term'])) {
		  	$result = $this->db1->search_blog($_GET['term']);
		   	if (count($result) > 0) {
				foreach ($result as $row)
		     	$arr_result[] = array(
					'label'			=> $row->nama,
					'description'	=> $row->id_item,
				);
		     	echo json_encode($arr_result);
		   	}
		}
	}	
	public function check_salah(){
		$this->form_validation->set_message('check_salah', 'check_salah');
		return false;
	}
	public function check_baru($str){
		$this->form_validation->set_message('check_baru', 'Terjadi kesalahan');
		if($str=='')
			return true;
		else
			return false;
	}
	public function check_diskon($str){
		$this->form_validation->set_message('check_diskon', '%s tidak sesuai');
		if($str == ''){
			$str=0;
			return true;
		}
		
		if(stripos($str,"%")){
			$diskon = str_replace("%","",str_replace(",","",$str));
			$diskon = explode("+",$diskon);
			foreach($diskon as $key2=>$value2){
				if(is_numeric($value2)==0 || !($value2>=0 && $value2<=100)){
					return false;
				}
			}
		}else if(stripos($str,"+")){
				return false;
		}else{
			if(!(is_numeric(cetak0($str))))
				return false;
		}
		return true;
	}
	public function check_tgl($str){
		if($str == ''){
			return true;
		}
		$str = explode("-",$str);
		$this->form_validation->set_message('check_tgl', 'Format Tanggal tidak sesuai format (DD-MM-YYYY)');
		return checkdate($str[1],$str[0],$str[2]);
	}
	public function check_supplier($str){
		$this->form_validation->set_message('check_supplier', 'Supplier tidak ditemukan');
		$check = $this->db1->check_supplier($str);
		return $check;
	}
	public function check_customer($str){
		$this->form_validation->set_message('check_customer', 'Customer tidak ditemukan');
		$check = $this->db1->check_customer($str);
		return $check;
	}
	public function check_person($str){
		$this->form_validation->set_message('check_person', 'Person tidak ditemukan');
		$check = $this->db1->check_person($str);
		return $check;
	}
	public function check_sales($str){
		$this->form_validation->set_message('check_sales', 'Sales tidak ditemukan');
		$check = $this->db1->check_sales($str);
		return $check;
	}
	public function check_angka($str){
		$str = str_replace(',','',$str);	
		if($str=='')
			return true;
		if (is_numeric($str)){
			if(strlen($str)>9){
				$this->form_validation->set_message('check_angka', '%s melebihi 9 digit');	
				return false;
			}else{
				return true;
			}
		}else{
			$this->form_validation->set_message('check_angka', '%s Hanya Boleh Angka');	
			return false;
		}
	}

	
	//ACCOUNT
	public function account(){
		$data = $this->check();
		$data['load']=$this->db1->account();
		$this->load->view('page/account',$data);
	}
	public function account_modif(){
		$data = $this->check();
		$id_account = (isset($_POST['id_account']) ? $_POST['id_account'] : (isset($_GET['id_account']) ? $_GET['id_account'] : ''));
		if(isset($_POST['submit'])){
			$this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'trim|required|max_length[255]|min_length[6]');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[255]|min_length[6]|callback_check_account_double');
			$this->form_validation->set_rules('password_confirmation', 'Password', 'trim|required|max_length[255]|min_length[6]');
			$this->form_validation->set_rules('password', 'Re Password', 'trim|required|matches[password_confirmation]');
			$this->form_validation->set_rules('alamat', 'Alamat', 'trim|max_length[1000]');
			$this->form_validation->set_rules('notlpn', 'Nomor Telepon', 'trim|max_length[20]|numeric');
			$this->form_validation->set_rules('npwp', 'NPWP', 'trim|max_length[255]|numeric');
			$this->form_validation->set_rules('email', 'Email', 'trim|max_length[255]|callback_check_email_double');
			
			if($_POST['submit']=='edit')
				$this->form_validation->set_rules('id_account', 'ID Account', 'required|callback_check_account_id');
			
			if ($this->form_validation->run() == TRUE){
				if($_SESSION['form_key']!=$_POST['uniqid']){
					$_SESSION['form_key']=$_POST['uniqid'];
					if($_POST['submit']=='baru'){
						$account_baru=$this->db1->account_baru();
						if($account_baru){
							$this->session->set_flashdata('account', '<div class="alert alert-success text-center">Berhasil Input</div>');
							redirect('Admin/Account');
						}
					}else if($_POST['submit']=='edit'){
						$account_edit=$this->db1->account_edit();
						if($account_edit){
							$this->session->set_flashdata('account', '<div class="alert alert-success text-center">Berhasil Update</div>');
							redirect('Admin/Account');
						}
					}
				}else{
					redirect('Admin/Account');
				}
			}
		}
		if($id_account!=''){
			$data['load']=$this->db1->account_load($id_account);
		}
		$this->load->view('page/account_modif',$data);
	}	
	public function check_email_double(){
		$check=$this->db1->ajax_email_double();		
		$this->form_validation->set_message('check_email_double', 'Email sudah ada');
		return $check;
	}
	public function check_account_double(){
		$check=$this->db1->check_account_double();		
		$this->form_validation->set_message('check_account_double', 'Nama sudah ada');
		return $check;
	}	
	public function check_account_id($str){
		$check=$this->db1->check_account_id($str);
		$this->form_validation->set_message('check_account_id', 'ID tidak ditemukan');
		return $check;		
	}
	public function ajax_account_hapus(){
		$data = $this->check();
		$data['check']=$this->db1->ajax_account_hapus();
		$this->session->set_flashdata('account', '<div class="alert alert-success text-center">Berhasil Hapus</div>');		
		echo json_encode(array("nilai" => $data['check'], "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));		
		exit();		
	}
	public function ajax_account_double(){
		$data['check']=$this->db1->check_account_double();		
		echo json_encode(array("nilai" => $data['check'], "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));		
		exit();			
	}
	public function ganti_password(){
		$data = $this->check();
		if(isset($_POST['submit'])){
			$this->form_validation->set_rules('password_lama', 'Password Lama', 'trim|required|callback_check_password');
			$this->form_validation->set_rules('pass_confirmation', 'Password Baru', 'trim|required|min_length[6]|max_length[255]');
			$this->form_validation->set_rules('pass', 'Password Confirmation', 'trim|matches[pass_confirmation]');
			if ($this->form_validation->run() == TRUE){
				if($_SESSION['form_key']!=$_POST['uniqid']){
					$_SESSION['form_key']=$_POST['uniqid'];
					$check = $this->db1->ganti_password();
					$this->session->set_flashdata('ganti_password', '<div class="alert alert-success text-center">Berhasil Ganti Password</div>');
					redirect('admin/ganti_password');
				}else{
					redirect('admin/ganti_password');
				}
			}
		}
		$this->load->view('page/ganti_password',$data);		
	}
	public function check_password($str){
		$this->form_validation->set_message('check_password', '%s tidak sesuai');
		$check = $this->db1->check_password($str);
		if($check[0]->nilai=='true')
			return TRUE;
		else
			return FALSE;
	}	
	
	
	//CUSTOM
	public function Custom(){
		$data = $this->check();
		$data['list']=$this->db1->kategori_list();
		$this->load->view('page/custom',$data);
	}
	public function Custom_Modif(){
		$data = $this->check();
		$id_kategori = (isset($_POST['id_kategori']) ? $_POST['id_kategori'] : (isset($_GET['id']) ? $_GET['id'] : ''));
		$id_custom = (isset($_POST['id_custom']) ? $_POST['id_custom'] : (isset($_GET['id_custom']) ? $_GET['id_custom'] : ''));
		
		if($id_kategori==''){
			redirect('Admin/Custom');
			exit();
		}
		
		if(isset($_POST['submit'])){
			$this->form_validation->set_rules('id_kategori', 'Kategori', 'trim|required|callback_check_custom_modif|callback_check_custom_double');
			$this->form_validation->set_rules('opsi', 'Opsi', 'trim|required|max_length[85]');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|max_length[1000]');
			if($_POST['submit']=='edit')
				$this->form_validation->set_rules('id_custom', 'Custom', 'trim|required');
			
			if ($this->form_validation->run() == TRUE){
				if($_SESSION['form_key']!=$_POST['uniqid']){
					$_SESSION['form_key']=$_POST['uniqid'];					
					
					if($_POST['submit']=='baru'){
						$data['custom_baru']=$this->db1->custom_baru();
						$this->session->set_flashdata('custom', '<div class="alert alert-success text-center">Berhasil Input</div>');
					}else if($_POST['submit']=='edit'){
						$this->db1->custom_edit();
						$this->session->set_flashdata('custom', '<div class="alert alert-success text-center">Berhasil Update</div>');
					}
				}
				$this->session->set_flashdata('id_kategori', $_POST['id_kategori']);
				redirect('Admin/Custom');
			}
		}
		if($id_custom!=''){
			$data['detail']=$this->db1->custom_detail($id_kategori,$id_custom);
		}
		$this->load->view('page/custom_modif', $data);
	}
	public function ajax_custom(){
		$data['load']=$this->db1->ajax_custom();	
		echo json_encode(array("nilai" => $data['load'], "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));		
		exit();
	}
	public function ajax_custom_hapus(){
		$data = $this->check();
		$data['ajax_custom_hapus']=$this->db1->ajax_custom_hapus();	
		$this->session->set_flashdata('id_kategori', $_POST['id_kategori']);
		$this->session->set_flashdata('custom', '<div class="alert alert-success text-center">Berhasil Hapus</div>');
		echo json_encode(array("nilai" => $data['ajax_custom_hapus'], "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));		
		exit();
	}
	public function ajax_custom_double(){
		$data['check']=$this->db1->check_custom_double();		
		echo json_encode(array("nilai" => $data['check'], "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));		
		exit();
	}
	public function check_custom_modif(){
		$data['check']=$this->db1->check_custom_modif();		
		$this->form_validation->set_message('check_custom_modif', 'Data tidak sesuai');
		return $data['check'];
	}
	public function check_custom_double(){
		$data['check']=$this->db1->check_custom_double();		
		$this->form_validation->set_message('check_custom_double', 'Nama Opsi sudah ada');
		return $data['check'];
	}

	
	//ITEM
	public function item(){
		$data = $this->check();
		$data['load']=$this->db1->item();
		$this->load->view('page/item',$data);
	}
	public function item_modif(){
		$data = $this->check();
		
		$id_item = (isset($_POST['id_item']) ? $_POST['id_item'] : (isset($_GET['id_item']) ? $_GET['id_item'] : ''));
		if(isset($_POST['submit'])){
			$this->form_validation->set_rules('nama', 'Nama', 'trim|required|max_length[255]|callback_check_item_double|callback_check_item_group');
			$this->form_validation->set_rules('harga_beli', 'Harga Beli', 'trim|callback_check_angka');
			$this->form_validation->set_rules('diskon', 'Diskon', 'trim|callback_check_diskon');
			$this->form_validation->set_rules('satuan', 'Satuan', 'trim|callback_check_satuan');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|max_length[1000]');
						
			if($_POST['submit']=='edit')
				$this->form_validation->set_rules('id_item', 'ID item', 'required|callback_check_item_id');
			if ($this->form_validation->run() == TRUE){
				if($_SESSION['form_key']!=$_POST['uniqid']){
					$_SESSION['form_key']=$_POST['uniqid'];
					if($_POST['submit']=='baru'){
						$item_baru=$this->db1->item_baru();
						if($item_baru){
							$this->session->set_flashdata('item', '<div class="alert alert-success text-center">Berhasil Input</div>');
							redirect('Admin/item');
						}
					}else if($_POST['submit']=='edit'){
						$item_edit=$this->db1->item_edit();
						if($item_edit){
							$this->session->set_flashdata('item', '<div class="alert alert-success text-center">Berhasil Edit</div>');
							redirect('Admin/item');
						}
					}
				}else{
					redirect('Admin/item');
				}
			}
		}
		if($id_item!=''){
			$data['load']=$this->db1->item_load($id_item);
		}
		$data['satuan']=$this->db1->list_satuan();
		$data['group']=$this->db1->list_group();
		$this->load->view('page/item_modif',$data);
	}
	public function ajax_item_hapus(){
		$data = $this->check();
		$data['ajax_item_hapus']=$this->db1->ajax_item_hapus();	
		$this->session->set_flashdata('item', '<div class="alert alert-success text-center">Berhasil Hapus</div>');				
		echo json_encode(array("nilai" => $data['ajax_item_hapus'], "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));				
		exit();
	}
	public function ajax_item_double(){
		$data['check']=$this->db1->check_item_double();		
		echo json_encode(array("nilai" => $data['check'], "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));		
		exit();
	}
	public function check_item_id($str){
		$data['check']=$this->db1->check_item_id($str);
		$this->form_validation->set_message('check_item_id', 'ID Item tidak ditemukan');
		return $data['check'];		
	}
	public function check_satuan($str){
		if($str != ''){
			$data['check']=$this->db1->check_satuan($str);
			$this->form_validation->set_message('check_satuan', 'Satuan tidak ditemukan');
			return $data['check'];					
		}else{
			return true;
		}
	}
	public function check_item_double(){
		$data['check']=$this->db1->check_item_double();		
		$this->form_validation->set_message('check_item_double', 'Nama Item sudah ada');
		return $data['check'];
	}
	public function check_item_group(){
		$str = (isset($_POST['group']) ? $_POST['group'] : '');
		if($str=='') return true;

		$cocok = $this->db1->check_item_group($str);
		if($cocok==false){
			$this->form_validation->set_message('check_item_group', 'Data Group tidak sesuai');
			return false;
		}else{
			$this->form_validation->set_message('check_item_group', 'Hanya boleh 3 kategori');
			if(count($str)>3)
				return false;
			else 
				return true;
		}
	}
	public function get_data_user(){
		$this->load->model('DB_Model');
		$data = $this->check();
		$hak = $data['hak_akses'][$_SESSION['id_account']]['item'];

		$list = $this->DB_Model->get_datatables();
		$data = array();

		foreach($list as $field){
			$ada = 0;
			if(cetak($field->gambar)==''){
				$gambar='';
			}else{
				$base = base_url();
				$gambar="<a href='".$base."images/item/".cetak($field->gambar)."' data-fancybox><img src='".$base."images/item/".cetak($field->gambar)."' style='width:200px; height:100px' alt='' /></a>";
			}
			$txt = '';
			if(array_search("edit",$hak)!=''){
				if($ada>0) $txt .= "&nbsp;|&nbsp;";
				$txt .= "<a href='#' class='edit' style='color:blue'>Edit</a>";
				$ada++;
			}
			if(array_search("hapus",$hak)!=''){
				if($ada>0) $txt .= "&nbsp;|&nbsp;";
				$txt .= "<a href='#' class='hapus' style='color:blue'>Hapus</a>";
				$ada++;
			}
			$row = array();
			$row[] = cetak($field->id_item);
			$row[] = cetak($field->nama);
			$row[] = cetak(number_format($field->harga_beli,0));
			$row[] = cetak($field->diskon);
			$row[] = cetak($field->satuan);
			$row[] = cetak($field->group);
			$row[] = cetak($field->keterangan);
			$row[] = $gambar;
			$row[] = $txt;
			$data[] = $row;		
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->DB_Model->count_all(),
			"recordsFiltered" => $this->DB_Model->count_filtered(),
			"data" => $data,
		);
		//output dalam format JSON
		echo json_encode($output);
	}	
	
	//PERSON
	public function person(){
		$data = $this->check();
		$data['load']=$this->db1->person();
		$this->load->view('page/person',$data);
	}
	public function person_modif(){
		$data = $this->check();
		$id_person = (isset($_POST['id_person']) ? $_POST['id_person'] : (isset($_GET['id_person']) ? $_GET['id_person'] : ''));
		if(isset($_POST['submit'])){
			$this->form_validation->set_rules('nama_person', 'Nama', 'trim|required|max_length[255]|callback_check_person_double');
			$this->form_validation->set_rules('jenis', 'jenis', 'trim|required|callback_check_person_jenis');
			$this->form_validation->set_rules('notlpn', 'Nomor Telepon', 'callback_check_angka_person');
			$this->form_validation->set_rules('npwp', 'NPWP', 'callback_check_angka_person');
			$this->form_validation->set_rules('alamat', 'Alamat', 'max_length[1000]');			

						
			if($_POST['submit']=='edit')
				$this->form_validation->set_rules('id_person', 'ID person', 'required|callback_check_person_id');
			
			if ($this->form_validation->run() == TRUE){
				if($_SESSION['form_key']!=$_POST['uniqid']){
					$_SESSION['form_key']=$_POST['uniqid'];
					if($_POST['submit']=='baru'){
						$person_baru=$this->db1->person_baru();
						if($person_baru){
							$this->session->set_flashdata('person', '<div class="alert alert-success text-center">Berhasil Input</div>');
							redirect('Admin/person');
						}
					}else if($_POST['submit']=='edit'){
						$person_edit=$this->db1->person_edit();
						if($person_edit){
							$this->session->set_flashdata('person', '<div class="alert alert-success text-center">Berhasil Edit</div>');
							redirect('Admin/person');
						}
					}
				}else{
					redirect('Admin/person');
				}
			}
		}
		if($id_person!=''){
			$data['load']=$this->db1->person_load($id_person);
		}
		$data['group']=$this->db1->jenis_person();
		$this->load->view('page/person_modif',$data);
	}
	public function ajax_person_hapus(){
		$data['ajax_person_hapus']=$this->db1->ajax_person_hapus();	
		$this->session->set_flashdata('person', '<div class="alert alert-success text-center">Berhasil Hapus</div>');						
		// echo json_encode(array("nilai" => $data['ajax_person_hapus'], "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));				
		exit();
	}
	public function ajax_person_double(){
		$data['check']=$this->db1->check_person_double();		
		echo json_encode(array("nilai" => $data['check'], "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));		
		exit();
	}	
	public function check_angka_person($str){
		$str = str_replace(',','',$str);	
		if($str=='')
			return true;
		if (is_numeric($str)){
			if(strlen($str)>20){
				$this->form_validation->set_message('check_angka', '%s melebihi 20 digit');	
				return false;
			}else{
				return true;
			}
		}else{
			$this->form_validation->set_message('check_angka_person', '%s Hanya Boleh Angka');	
			return false;
		}
	}
	public function check_person_double(){
		$data['check']=$this->db1->check_person_double();		
		$this->form_validation->set_message('check_person_double', 'Nama sudah ada');
		return $data['check'];
	}	
	public function check_person_id($str){
		$data['check']=$this->db1->check_person_id($str);
		$this->form_validation->set_message('check_person_id', 'ID tidak ditemukan');
		return $data['check'];		
	}
	public function check_person_jenis($str){
		if($str=='')
			return true;
		
		$cocok = $this->db1->check_person_jenis($str);
		if($cocok==false){
			$this->form_validation->set_message('check_person_jenis', 'Data %s tidak sesuai');
			return false;
		}else{
			return true;
		}
	}	
	

	//TRANSAKSI
	public function check_item_transaksi(){
		if(empty($_POST['id_item'])){
			$this->form_validation->set_message('check_item_transaksi', 'Item tidak boleh kosong');
			return false;
		}else{
			$check = $this->db1->check_item_transaksi();
			if($check == 'ok'){
				return TRUE;
			}else{
				$this->form_validation->set_message('check_item_transaksi', $check);
				return FALSE;
			}
		}
	}
	public function check_item_stock(){
		$check = $this->db1->check_item_stock();
		if($check == 'ok'){
			return TRUE;
		}else{
			$this->form_validation->set_message('check_item_stock', $check);
			return FALSE;
		}
	}
	
	
	//PEMBELIAN
	public function pembelian(){
		$data = $this->check();
		$data['load']=$this->db1->pembelian();
		$data['load_detail']=$this->db1->pembelian_detail();
		$this->load->view('page/pembelian',$data);
	}
	public function pembelian_modif(){
		$data = $this->check();
		$id_pembelian = (isset($_POST['id_pembelian']) ? $_POST['id_pembelian'] : (isset($_GET['id_pembelian']) ? $_GET['id_pembelian'] : ''));
		if(isset($_POST['submit'])){
			$id_supplier=(isset($_POST['id_supplier']) ? $_POST['id_supplier'] : '');//aneh
			$this->form_validation->set_rules('id_supplier', 'Supplier', 'required|trim|callback_check_supplier|callback_check_item_transaksi');
			$this->form_validation->set_rules('no_bon', 'Nomor Bon', 'required|trim|max_length[255]');
			$this->form_validation->set_rules('jatuh_tempo', 'Jatuh Tempo', 'required|trim|numeric|less_than_equal_to[999]|greater_than_equal_to[0]');
			$this->form_validation->set_rules('tgl_pembelian', 'Tanggal Retur Penjualan', 'required|trim|callback_check_tgl');
			$this->form_validation->set_rules('diskon', 'Diskon', 'trim|callback_check_diskon');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|max_length[1000]');	
			
			if($_POST['submit']=='edit'){
				$this->form_validation->set_rules('id_pembelian', 'ID Pembelian', 'required|callback_check_pembelian_id');
			}else if($_POST['submit']=='baru'){
				$this->form_validation->set_rules('id_pembelian', 'ID Pembelian', 'callback_check_baru');				
			}

			if ($this->form_validation->run() == TRUE){
				if($_SESSION['form_key']!=$_POST['uniqid']){
					$_SESSION['form_key']=$_POST['uniqid'];
					$_POST['id_supplier']=$id_supplier;//aneh

					if($_POST['submit']=='baru'){
						$pembelian_baru=$this->db1->pembelian_baru();
						if($pembelian_baru){
							$this->session->set_flashdata('pembelian', '<div class="alert alert-success text-center">Berhasil Input</div>');
							redirect('Admin/pembelian');
						}
					}else if($_POST['submit']=='edit'){
						$pembelian_edit=$this->db1->pembelian_edit();
						if($pembelian_edit){
							$this->session->set_flashdata('pembelian', '<div class="alert alert-success text-center">Berhasil Edit</div>');
							redirect('Admin/pembelian');
						}
					}
				}else{
					redirect('Admin/pembelian');
				}
			}
		}

		if($id_pembelian!=''){
			$data['load']=$this->db1->pembelian_load($id_pembelian);
		}
		$data['item']=$this->db1->list_item();
		$data['list']=$this->db1->list_supplier();
		if(isset($_POST['id_supplier'])){
			$_POST['id_supplier']=$id_supplier;//aneh
		}
		$this->load->view('page/pembelian_modif',$data);		
	}
	public function check_pembelian_id($str){
		$check = $this->db1->check_pembelian_id($str);
		if($check){
			return $check;
		}else{
			$this->form_validation->set_message('check_pembelian_id', '%s tidak ditemukan');
			return false;			
		}
	}
	public function ajax_pembelian_hapus(){
		$data = $this->check();
		$data['ajax_pembelian_hapus']=$this->db1->ajax_pembelian_hapus();
		echo json_encode(array("nilai" => $data['ajax_pembelian_hapus'], "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));				
		exit();		
	}


	//PENJUALAN
	public function penjualan(){
		$data = $this->check();
		$data['load']=$this->db1->penjualan();
		$data['load_detail']=$this->db1->penjualan_detail();
		$this->load->view('page/penjualan',$data);
	}
	public function penjualan_modif(){
		$data = $this->check();
		$id_penjualan = (isset($_POST['id_penjualan']) ? $_POST['id_penjualan'] : (isset($_GET['id_penjualan']) ? $_GET['id_penjualan'] : ''));
		if(isset($_POST['submit'])){ 
			$id_customer=(isset($_POST['id_customer']) ? $_POST['id_customer'] : '');//aneh
			$this->form_validation->set_rules('id_customer', 'Customer', 'required|trim|callback_check_customer|callback_check_item_transaksi|callback_check_item_stock');
			$this->form_validation->set_rules('id_sales', 'Sales', 'required|trim|callback_check_sales');
			$this->form_validation->set_rules('jatuh_tempo', 'Jatuh Tempo', 'required|trim|numeric|less_than_equal_to[999]|greater_than_equal_to[0]');
			$this->form_validation->set_rules('tgl_penjualan', 'Tanggal penjualan', 'required|trim|callback_check_tgl');
			$this->form_validation->set_rules('diskon', 'Diskon', 'trim|callback_check_diskon');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|max_length[1000]');

			if($_POST['submit']=='edit'){
				$this->form_validation->set_rules('id_penjualan', 'ID Penjualan', 'required|callback_check_penjualan_id');
			}else if($_POST['submit']=='baru'){
				$this->form_validation->set_rules('id_penjualan', 'ID Penjualan', 'callback_check_baru');				
			}

			if ($this->form_validation->run() == TRUE){
				if($_SESSION['form_key']!=$_POST['uniqid']){
					$_SESSION['form_key']=$_POST['uniqid'];
					$_POST['id_customer']=$id_customer;//aneh

					if($_POST['submit']=='baru'){
						$penjualan_baru=$this->db1->penjualan_baru();
						if($penjualan_baru){
							$this->session->set_flashdata('penjualan', '<div class="alert alert-success text-center">Berhasil Input</div>');
							redirect('Admin/penjualan');
						}
					}else if($_POST['submit']=='edit'){
						$penjualan_edit=$this->db1->penjualan_edit();
						if($penjualan_edit){
							$this->session->set_flashdata('penjualan', '<div class="alert alert-success text-center">Berhasil Edit</div>');
							redirect('Admin/penjualan');
						}
					}
				}else{
					redirect('Admin/penjualan');
				}
			}
		}

		if($id_penjualan!=''){
			$data['load']=$this->db1->penjualan_load($id_penjualan);
		}
		$data['item']=$this->db1->list_stock();
		$data['customer']=$this->db1->list_customer();
		$data['sales']=$this->db1->list_sales();
		if(isset($_POST['id_customer'])){
			$_POST['id_customer']=$id_customer;//aneh
		}
		$this->load->view('page/penjualan_modif',$data);		
	}
	public function check_penjualan_id($str){
		$check = $this->db1->check_penjualan_id($str);
		if($check){
			return $check;
		}else{
			$this->form_validation->set_message('check_penjualan_id', '%s tidak ditemukan');
			return false;			
		}
	}
	public function ajax_penjualan_hapus(){
		$data = $this->check();
		$check=$this->db1->ajax_penjualan_hapus();
		echo json_encode(array("nilai" => $check, "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));				
		exit();		
	}
	public function ajax_penjualan_print(){
		$data['load']=$this->db1->print_invoice($_POST['id_penjualan']);
		$data['detail']=$this->db1->print_detail($_POST['id_penjualan']);
		
		$cetak = $this->load->view('page/penjualan_print',$data);
		$cetak = $cetak->output->final_output;
		echo json_encode(array("cetak" => $cetak, "nilai" => $data['load'], "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));				
		exit();
		// $this->load->view('page/penjualan_print',$data);		
	}


	//RETUR JUAL
	public function retur_jual(){
		$data = $this->check();
		$data['load']=$this->db1->retur_jual();
		$data['load_detail']=$this->db1->retur_jual_detail();
		$this->load->view('page/retur_jual',$data);
	}
	public function retur_jual_modif(){
		$data = $this->check();
		$id_retur_jual = (isset($_POST['id_retur_jual']) ? $_POST['id_retur_jual'] : (isset($_GET['id_retur_jual']) ? $_GET['id_retur_jual'] : ''));
		if(isset($_POST['submit'])){ 
			$id_customer=(isset($_POST['id_customer']) ? $_POST['id_customer'] : '');//aneh
			$this->form_validation->set_rules('id_customer', 'Customer', 'required|trim|callback_check_customer|callback_check_item_transaksi');
			$this->form_validation->set_rules('jatuh_tempo', 'Jatuh Tempo', 'required|trim|numeric|less_than_equal_to[999]|greater_than_equal_to[0]');
			$this->form_validation->set_rules('tgl_retur_jual', 'Tanggal Retur Penjualan', 'required|trim|callback_check_tgl');
			$this->form_validation->set_rules('diskon', 'Diskon', 'trim|callback_check_diskon');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|max_length[1000]');

			if($_POST['submit']=='edit'){
				$this->form_validation->set_rules('id_retur_jual', 'ID Retur Jual', 'required|callback_check_retur_jual_id');
			}else if($_POST['submit']=='baru'){
				$this->form_validation->set_rules('id_retur_jual', 'ID Retur Jual', 'callback_check_baru');				
			}

			if ($this->form_validation->run() == TRUE){
				if($_SESSION['form_key']!=$_POST['uniqid']){
					$_SESSION['form_key']=$_POST['uniqid'];
					$_POST['id_customer']=$id_customer;//aneh

					if($_POST['submit']=='baru'){
						$retur_jual_baru=$this->db1->retur_jual_baru();
						if($retur_jual_baru){
							$this->session->set_flashdata('retur_jual', '<div class="alert alert-success text-center">Berhasil Input</div>');
							redirect('Admin/retur_jual');
						}
					}else if($_POST['submit']=='edit'){
						$retur_jual_edit=$this->db1->retur_jual_edit();
						if($retur_jual_edit){
							$this->session->set_flashdata('retur_jual', '<div class="alert alert-success text-center">Berhasil Edit</div>');
							redirect('Admin/retur_jual');
						}
					}
				}else{
					redirect('Admin/retur_jual');
				}
			}
		}

		if($id_retur_jual!=''){
			$data['load']=$this->db1->retur_jual_load($id_retur_jual);
		}
		$data['item']=$this->db1->list_item();
		$data['list']=$this->db1->list_customer();
		if(isset($_POST['id_customer'])){
			$_POST['id_customer']=$id_customer;//aneh
		}
		$this->load->view('page/retur_jual_modif',$data);		
	}
	public function check_retur_jual_id($str){
		$check = $this->db1->check_retur_jual_id($str);
		if($check){
			return $check;
		}else{
			$this->form_validation->set_message('check_retur_jual_id', '%s tidak ditemukan');
			return false;			
		}
	}
	public function ajax_retur_jual_hapus(){
		$data = $this->check();
		$data['ajax_retur_jual_hapus']=$this->db1->ajax_retur_jual_hapus();
		echo json_encode(array("nilai" => $data['ajax_retur_jual_hapus'], "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));				
		exit();		
	}
	
	
	//RETUR BELI
	public function retur_beli(){
		$data = $this->check();
		$data['load']=$this->db1->retur_beli();
		$data['load_detail']=$this->db1->retur_beli_detail();
		$this->load->view('page/retur_beli',$data);
	}
	public function retur_beli_modif(){
		$data = $this->check();
		$id_retur_beli = (isset($_POST['id_retur_beli']) ? $_POST['id_retur_beli'] : (isset($_GET['id_retur_beli']) ? $_GET['id_retur_beli'] : ''));
		if(isset($_POST['submit'])){ 
			$id_supplier=(isset($_POST['id_supplier']) ? $_POST['id_supplier'] : '');//aneh
			$this->form_validation->set_rules('id_supplier', 'Supplier', 'required|trim|callback_check_supplier|callback_check_item_transaksi|callback_check_item_stock');
			$this->form_validation->set_rules('jatuh_tempo', 'Jatuh Tempo', 'required|trim|numeric|less_than_equal_to[999]|greater_than_equal_to[0]');
			$this->form_validation->set_rules('tgl_retur_beli', 'Tanggal Retur Beli', 'required|trim|callback_check_tgl');
			$this->form_validation->set_rules('diskon', 'Diskon', 'trim|callback_check_diskon');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|max_length[1000]');

			if($_POST['submit']=='edit'){
				$this->form_validation->set_rules('id_retur_beli', 'ID Retur Beli', 'required|callback_check_retur_beli_id');
			}else if($_POST['submit']=='baru'){
				$this->form_validation->set_rules('id_retur_beli', 'ID Retur Beli', 'callback_check_baru');				
			}

			if ($this->form_validation->run() == TRUE){
				if($_SESSION['form_key']!=$_POST['uniqid']){
					$_SESSION['form_key']=$_POST['uniqid'];
					$_POST['id_supplier']=$id_supplier;//aneh

					if($_POST['submit']=='baru'){
						$retur_beli_baru=$this->db1->retur_beli_baru();
						if($retur_beli_baru){
							$this->session->set_flashdata('retur_beli', '<div class="alert alert-success text-center">Berhasil Input</div>');
							redirect('Admin/retur_beli');
						}
					}else if($_POST['submit']=='edit'){
						$retur_beli_edit=$this->db1->retur_beli_edit();
						if($retur_beli_edit){
							$this->session->set_flashdata('retur_beli', '<div class="alert alert-success text-center">Berhasil Edit</div>');
							redirect('Admin/retur_beli');
						}
					}
				}else{
					redirect('Admin/retur_beli');
				}
			}
		}

		if($id_retur_beli!=''){
			$data['load']=$this->db1->retur_beli_load($id_retur_beli);
		}
		$data['item']=$this->db1->list_stock();
		$data['list']=$this->db1->list_supplier();
		if(isset($_POST['id_supplier'])){
			$_POST['id_supplier']=$id_supplier;//aneh
		}
		$this->load->view('page/retur_beli_modif',$data);		
	}
	public function check_retur_beli_id($str){
		$check = $this->db1->check_retur_beli_id($str);
		if($check){
			return $check;
		}else{
			$this->form_validation->set_message('check_retur_beli_id', '%s tidak ditemukan');
			return false;			
		}
	}
	public function ajax_retur_beli_hapus(){
		$data = $this->check();
		$data['ajax_retur_beli_hapus']=$this->db1->ajax_retur_beli_hapus();
		echo json_encode(array("nilai" => $data['ajax_retur_beli_hapus'], "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));				
		exit();		
	}
	
	
	//Bayar
	public function pembayaran(){
		$data = $this->check();
		$data['load']=$this->db1->pembayaran();
		if(isset($_POST['jenis'])){
			$this->form_validation->set_rules('id_supplier', 'Supplier', 'required|trim|in_list[pembelian,penjualan]');
		}		
		$this->load->view('page/pembayaran',$data);
	}
	public function pembayaran_modif(){
		$data = $this->check();
		$id_pembayaran = (isset($_POST['id_pembayaran']) ? $_POST['id_pembayaran'] : (isset($_GET['id_pembayaran']) ? $_GET['id_pembayaran'] : ''));
		if(isset($_POST['submit'])){
						
			$this->form_validation->set_rules('id_person', 'ID Person', 'trim|required[255]|callback_check_person|callback_check_pembayaran_modif|callback_check_pembayaran_transaksi');
			$this->form_validation->set_rules('nama_person', 'Nama', 'trim|required');
			$this->form_validation->set_rules('tgl_pembayaran', 'Tgl Pembayaran', 'trim|required|callback_check_tgl');
			$this->form_validation->set_rules('bayar', 'Bayar', 'trim|required|callback_check_angka');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|max_length[1000]');

			if ($this->form_validation->run() == TRUE){
				if($_SESSION['form_key']!=$_POST['uniqid']){
					$_SESSION['form_key']=$_POST['uniqid'];
					$pembayaran_baru=$this->db1->pembayaran_baru();
					if($pembayaran_baru){
						$this->session->set_flashdata('pembayaran', '<div class="alert alert-success text-center">Berhasil Input</div>');
						redirect('Admin/pembayaran');
					}
				}else{
					redirect('Admin/pembayaran');
				}
			}else{
				$this->session->set_flashdata('pembayaran', '<div class="alert alert-danger text-center">'.validation_errors().'</div>');
			}
		}
		$data['load']=$this->db1->pembayaran();
		$this->load->view('page/pembayaran',$data);
	}
	public function check_pembayaran_modif(){
		$this->form_validation->set_message('check_sales', '%s tidak ditemukan');
		$check = $this->db1->check_pembayaran_modif();
		return $check;	
	} 
	public function pembayaran_list(){
		$data = $this->check(); 
		$data['load']=$this->db1->pembayaran_list();
		$data['detail']=$this->db1->detail_pembayaran_list();
		$this->load->view('page/pembayaran_list',$data);
	}
	public function ajax_pembayaran_hapus(){
		$data['ajax_pembayaran_hapus']=$this->db1->ajax_pembayaran_hapus();
		$this->session->set_flashdata('penjualan', '<div class="alert alert-success text-center">Berhasil Hapus</div>');
		echo json_encode(array("nilai" => $data['ajax_pembayaran_hapus'], "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));				
		exit();	
	}
	public function check_pembayaran_transaksi(){
		$check = $this->db1->check_pembayaran_transaksi();
		if($check == 'ok'){
			return TRUE;
		}else{
			$this->form_validation->set_message('check_pembayaran_transaksi', $check);
			return FALSE;
		}
	}

	
	//MENU
	public function menu_list(){
		$data = $this->check();
		if(isset($_POST['submit'])){
			$this->form_validation->set_rules('id_account', 'Account', 'trim|required|callback_check_menu');

			if ($this->form_validation->run() == TRUE){
				if($_SESSION['form_key']!=$_POST['uniqid']){
					$_SESSION['form_key']=$_POST['uniqid'];
					$update = $this->db1->menu_update();
				}
			}
		}
		$data['load']=$this->db1->account();		
		$this->load->view('page/menu_list',$data);		
	}
	public function check_menu(){
		$data = $this->check();
		$this->form_validation->set_message('check_menu', 'Data Menu tidak sesuai');
		$check = $this->db1->check_menu($data['menulist']);
		return $check;		
	}
	public function ajax_menu_load(){
		$temp=$this->db1->menu_load($_POST['id_account']);	
		echo json_encode(array("nilai" => $temp, "csrf" => array("name" => $this->security->get_csrf_token_name(), "hash" => $this->security->get_csrf_hash())));		
	}
	
	//REPORT
	public function report(){
		$data = $this->check();
		if(isset($_POST['submit'])){
			$this->form_validation->set_rules('jenis', 'Jenis Report', 'trim|required|in_list[omset,penjualan,pembelian,stock,pembayaran,retur_beli,retur_jual]');
			$this->form_validation->set_rules('dari', 'Tanggal Dari', 'trim|required|callback_check_tgl');
			$this->form_validation->set_rules('sampai', 'Tanggal Sampai', 'trim|required|callback_check_tgl');
			
			if ($this->form_validation->run() == TRUE){
				$data['load']=$this->db1->report();
				$data['detail']=$this->db1->detail_report();
			}
		}
		$this->load->view('page/report',$data);		
	}

	//LOGOUT
	public function Logout() {
		$data = $this->check();
		$this->session->unset_userdata(array('id_account','username','nama_lengkap','gambar','form_key'));
		redirect('Admin');
	}
}