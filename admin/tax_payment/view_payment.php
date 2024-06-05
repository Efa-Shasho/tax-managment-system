<?php

if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT p.*, p.company_name, p.owner, p.company_registration from `tax_payment_history` p  ");
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
        echo '<script> alert("Pass History ID is invalid."); location.replace("./?page=tax_payment");</script>';
    }
}else{
    echo '<script> alert("Pass History ID is required."); location.replace("./?page=tax_payment");</script>';
}
?>
<div class="mx-0 py-5 px-3 mx-ns-4 bg-gradient-primary">
	<h3><b>Tax Payment Details</b></h3>
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
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">TIN Number</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($company_registration) ? $company_registration : '' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">Business Owner</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($owner) ? $owner : '' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">Company Name</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($company_name) ? $company_name : '' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">Tax Category</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($tax_category) ? $tax_category : '' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">Annual Revenue</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($revenue) ? number_format($revenue,2) : "" ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">Income Tax</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($income_tax) ? number_format($income_tax,2) : '0.00' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">Extra Payment</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($extra_payment) ? number_format($extra_payment,2) : '0.00' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">Tax Penalty</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($tax_penalty) ? number_format($tax_penalty,2) : '0.00' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">Total Tax Paid</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($total_tax_amount) ? number_format($total_tax_amount,2) : '0.00' ?></div>
						<div class="col-4 border py-2 m-0 font-weight-bolder text-muted">Collected By</div>
						<div class="col-8 border py-2 m-0 font-weight-bolder"><?= isset($user_name) ? ucwords($user_name) : "N/A" ?></div>
					</div>
				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<button class="btn btn-light btn-sm bg-gradient-light border rounded-0" type="button" id="print-data"><i class="fa fa-print"></i> Print</button>
				<a class="btn btn-primary btn-sm bg-gradient-primary rounded-0" href="./?page=tax_payment/manage_payment&id=<?= isset($id) ? $id :'' ?>"><i class="fa fa-edit"></i> Edit</a>
				<button class="btn btn-danger btn-sm bg-gradient-danger rounded-0" type="button" id="delete-data"><i class="fa fa-trash"></i> Delete</button>
				<a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?page=tax_payment"><i class="fa fa-angle-left"></i> Back to List</a>
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
					<h3 class="text-center">Toll Pass History Details</h3>
				</div>
			</div>
		</div>
		<hr>
	</div>
</noscript>
<script>
	
	$(document).ready(function(){
        $('#delete-data').click(function(){
			_conf("Are you sure to delete this payment record permanently?","delete_pass_history",['<?= isset($id) ? $id : '' ?>'])
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
    function delete_pass_history($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_pass_history",
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
					location.replace("./?page=tax_payment");
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>