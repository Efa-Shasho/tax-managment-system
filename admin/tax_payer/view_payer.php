<?php

if(isset($_GET['id']) ){
    $qry = $conn->query("SELECT p.* from `tax_payer_list` p where p.id = '{$_GET['id']}'");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
		if(isset($user_id) && !is_null($user_id)){
			$user = $conn->query("SELECT concat(lastname, ', ', firstname, ' ', coalesce(middlename,'')) as `name` FROM `users` where id = '{$user_id}'");
			if($user->num_rows > 0){
				$user_name = $user->fetch_array()['name'];
			}
		}
    }else{
        echo '<script> alert("ID is invalid."); location.replace("./?page=tax_payer");</script>';
    }
}else{
    echo '<script> alert("ID is required."); location.replace("./?page=tax_payer");</script>';
}
?>
<div class="mx-0 py-5 px-3 mx-ns-4 bg-gradient-primary">
	<h3><b>Tax Payer Details</b></h3>
</div>
<style>
	img#cimg{
      max-height: 15em;
      object-fit: scale-down;
    }
</style>
<div class="row justify-content-center" style="margin-top:-2em;">
	<div class="col-lg-10 col-md-11 col-sm-11 col-xs-11">
		<div class="card rounded-0 shadow">
			<div class="card-body">
				<div class="container-fluid" id="printout">
					<div class="row w-100">
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">DateTime Created</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($date_created) ? date("F d, Y h:i A", strtotime($date_created)) : '' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">Full Name</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($owner) ? $owner : '' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">Age</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($age) ? $age : '' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">Sex</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($sex) ? $sex : '' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">Address</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($address) ? $address : '0.00' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">House No.</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($house_number) ? $house_number : '' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">House Size</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($house_size) ? $house_size : '' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">House Ownership</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($house_ownership) ? $house_ownership : '' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">Business Name</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($company_name) ? $company_name : '' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">TIN Number</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($company_registration) ? $company_registration : "" ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">Registered By</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($user_name) ? ucwords($user_name) : "N/A" ?></div>
					</div>
				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<button class="btn btn-light btn-sm bg-gradient-light border rounded-0" type="button" id="print-data"><i class="fa fa-print"></i> Print</button>
				<a class="btn btn-primary btn-sm bg-gradient-primary rounded-0" href="./?page=tax_payer/manage_payer&id=<?= isset($id) ? $id :'' ?>"><i class="fa fa-edit"></i> Edit</a>
				<button class="btn btn-danger btn-sm bg-gradient-danger rounded-0" type="button" id="delete-data"><i class="fa fa-trash"></i> Delete</button>
				<a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?page=tax_payer"><i class="fa fa-angle-left"></i> Back to List</a>
			</div>
		</div>
	</div>
</div>
<noscript id="print-header">
	<div>
		<div class="d-flex w-100 align-items-center">
			<div class="col-2 text-center">
				<img src="<?= validate_image($_settings->info('logo'))?>" class="img-fluid img-thumbnail rounded-circle" style="height:5em;width:5em;object-fit:cover;object-position:center center" alt="">
			</div>
			<div class="col-8 text-center">
				<div style="line-height:.7em">
					<h4 class="text-center"><?= $_settings->info('name') ?></h4>
					<h3 class="text-center">Toll Pass Details</h3>
				</div>
			</div>
		</div>
		<hr>
	</div>
</noscript>
<script>
	
	$(document).ready(function(){
        $('#delete-data').click(function(){
			_conf("Are you sure to delete this pass permanently?","delete_pass",['<?= isset($id) ? $id : '' ?>'])
		})
		$('#print-data').click(function(){
			var h = $('head').clone()
			var ph = $($('noscript#print-header').html()).clone()
			var p = $('#printout').clone()
			h.find('title').text("pass Details - Print View")
			// console.log(ph[0].outerHTML)
			start_loader()
			var nw = window.open('', '_blank','width=1000,height=800')
				nw.document.querySelector('head').innerHTML = h.html()
				nw.document.querySelector('body').innerHTML = ph[0].outerHTML + p[0].outerHTML
				nw.document.close()
				setTimeout(() => {
					nw.print()
					setTimeout(() => {
						nw.close()
						end_loader()
					}, 300);
				}, (300));
		})
	})
    function delete_pass($id){
		start_loader();
		console.log($id)
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_pass",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.replace("./?page=passes");
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>