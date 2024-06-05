<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_category(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `category_list` where `name` = '{$name}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Category Name already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `category_list` set {$data} ";
		}else{
			$sql = "UPDATE `category_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Category successfully saved.";
			else
				$resp['msg'] = " Category successfully updated.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_category(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `category_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Category successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_toll(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `compliant_list` where `name` = '{$name}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Complainant already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `compliant_list` set {$data} ";
		}else{
			$sql = "UPDATE `compliant_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Compliant successfully saved.";
			else
				$resp['msg'] = " Compliant successfully updated.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_toll(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `compliant_list` where id = '{$id}'");

		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Compliant successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_recipient(){
		if(empty($_POST['id']))
		$_POST['user_id'] = $this->settings->userdata('id');
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$search = $this->conn->query("SELECT b.* FROM `bill_list` b where b.company_registration = '{$company_registration}'");
			
			if($search->num_rows == 0) {
				$sql = "INSERT INTO `bill_list` set {$data} ";
			}
			else {
				$resp['status'] = 'failed';
				$resp['err'] = "Bill Already Generated";
				return json_encode($resp);
			}
		}else{
			$sql = "UPDATE `bill_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$rid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			$resp['rid'] = $rid;
			if(empty($id))
				$resp['msg'] = "New Bill successfully saved.";
			else
				$resp['msg'] = " Bill successfully updated.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
			$resp['sql'] = $sql;
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_recipient(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `bill_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Recipient successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}

	function generate_tin_number() {
    // Define the format of a TIN number
    $tin_format = "###-###-###-#";

    // Replace # with random digits
    $tin_number = str_replace("#", rand(0, 9), $tin_format);

    return $tin_number;
}
	function save_pass(){
		if(empty($_POST['id'])){
			$_POST['user_id'] = $this->settings->userdata('id');
			$prefix = generate_tin_number();
			$_POST['code'] = $prefix;
			$_POST['company_registration'] = $prefix;
		}
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		
		if(empty($id)){
			$sql = "INSERT INTO `tax_payer_list` set {$data} ";
		}else{
			$sql = "UPDATE `tax_payer_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$rid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			$resp['rid'] = $rid;
			if(empty($id))
				$resp['msg'] = "Payer Info successfully saved.";
			else
				$resp['msg'] = " Payer Info successfully updated.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
			$resp['sql'] = $sql;
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_pass(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `tax_payer_list`  where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function search_pass_code_payer(){
		extract($_POST);
		$data = [];
		$search = $this->conn->query("SELECT b.* FROM `tax_payer_list` b where b.company_registration = '{$code}'");
		//echo $code;
		if($search->num_rows > 0){
			$search_data = $search->fetch_array();
			$data = $search_data;
		}
		return json_encode($data);
	}
	function search_pass_code_bill(){
		extract($_POST);
		$data = [];
		$search = $this->conn->query("SELECT b.* FROM `bill_list` b where b.company_registration = '{$code}'");
		if($search->num_rows > 0){
			$search_data = $search->fetch_array();
			$data = $search_data;
		}
		return json_encode($data);
	}
	function save_pass_history(){
		if(empty($_POST['id']))
		$_POST['user_id'] = $this->settings->userdata('id');
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$search = $this->conn->query("SELECT p.* FROM `tax_payment_history` p where p.company_registration = '{$company_registration}'");
			
			if($search->num_rows == 0) {
				$sql = "INSERT INTO `tax_payment_history` set {$data} ";
				$sql2 = "UPDATE `bill_list` set {$data} where company_registration = '{$company_registration}' ";

			}
			else {
				$resp['status'] = 'failed';
				$resp['err'] = "payment already recorded";
				return json_encode($resp);
			}
			
		}else{
			$sql = "UPDATE `tax_payment_history` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
			$save2 = $this->conn->query($sql2);
		if($save){
			$rid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			$resp['rid'] = $rid;
			if(empty($id))
				$resp['msg'] = "Successfully saved.";
			else
				$resp['msg'] = " Successfully updated.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error;
			$resp['sql'] = $sql;
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}

	function delete_pass_history(){
		if(empty($_POST['id']))
		$_POST['user_id'] = $this->settings->userdata('id');
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$search = $this->conn->query("SELECT p.* FROM `tax_payment_history` p where p.id = '{$id}'");

		$del = $this->conn->query("DELETE FROM `tax_payment_history` where id = '{$id}'");
		$del2 = $this->conn->query("UPDATE `bill_list` set payment_status = '0' where id = '{$id}'");

		if($del && $del2){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Tax Payment Successfully Deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'delete_img':
		echo $Master->delete_img();
	break;
	case 'save_category':
		echo $Master->save_category();
	break;
	case 'delete_category':
		echo $Master->delete_category();
	break;
	case 'save_toll':
		echo $Master->save_toll();
	break;
	case 'delete_toll':
		echo $Master->delete_toll();
	break;
	case 'save_recipient':
		echo $Master->save_recipient();
	break;
	case 'delete_recipient':
		echo $Master->delete_recipient();
	break;
	case 'save_pass':
		echo $Master->save_pass();
	break;
	case 'delete_pass':
		echo $Master->delete_pass();
	break;
	case 'search_pass_code_bill':
		echo $Master->search_pass_code_bill();
	break;
	case 'search_pass_code_payer':
		echo $Master->search_pass_code_payer();
	break;
	case 'save_pass_history':
		echo $Master->save_pass_history();
	break;
	case 'delete_pass_history':
		echo $Master->delete_pass_history();
	break;
	default:
		// echo $sysset->index();
		break;
}