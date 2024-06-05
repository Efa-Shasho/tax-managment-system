<?php

if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `tax_payment_history` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
	if(isset($pass_id)){
		$pass_qry = $conn->query("SELECT p.* FROM `bill_list` p where p.id = '{$pass_id}' ");
		if($pass_qry->num_rows > 0){
			foreach($pass_qry->fetch_array() as $k => $v){
				if(!is_numeric($k))
				$pass[$k] = $v;
			}
		}
	}
}
?>
<div class="mx-0 py-5 px-3 mx-ns-4 bg-gradient-primary">
	<h3><b><?= isset($id) ? "Update Payment History" : "Record Tax Payment" ?></b></h3>
</div>
<style>
	img#cimg{
      max-height: 15em;
      width: 100%;
      object-fit: scale-down;
    }
</style>
<div class="row justify-content-center" style="margin-top:-2em;">
	<div class="col-lg-6 col-md-8 col-sm-11 col-xs-11">
		<div class="card rounded-0 shadow">
			<div class="card-body">
				<div class="container-fluid">
					<div class="container-fluid">
						<form action="" id="pass_history-form">
							<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
							<input type="hidden" name ="payment_status" value="<?php echo isset($payment_status) ? 0 : 1 ?>">
							<?php if(!isset($id)): ?>
							<div class="form-group mb-3">
								<label for="code" class="control-label">Search with TIN Number</label>
								<div class="input-group input-group-sm">
									<input type="search" class="form-control form-control-sm rounded-0" id="code" value="<?= isset($code) ? $code : '' ?>" required="required">
									<button class="btn btn-outline-secondary btn-sm rounded-0" type="button" id="search_pass"><i class="fa fa-search"></i></button>
								</div>
							</div>
							<?php endif; ?>
							<div class="form-group mb-3">
								<label for="tin" class="control-label">TIN Number</label>
								<input type="text" class="form-control form-control-sm rounded-0 text-right tin_number" id="company_registration" name="company_registration" required="required" readonly>
							</div>
							<div class="form-group mb-3">
								<label for="owner" class="control-label">Business Owner</label>
								<input type="text" class="form-control form-control-sm rounded-0 text-right owner" id="owner" name="owner" required="required" readonly>
							</div>
							<div class="form-group mb-3">
								<label for="comapny_name" class="control-label">Company Name</label>
								<input type="text" class="form-control form-control-sm rounded-0 text-right company_name" id="company_name" name="company_name" required="required" readonly>
							</div>
							<div class="form-group mb-3">
								<label for="tax_category" class="control-label">Tax Category</label>
								<input type="text" class="form-control form-control-sm rounded-0 text-right category" id="tax_category" name="tax_category" required="required" readonly>
							</div>
							<div class="form-group mb-3">
								<label for="revenue" class="control-label">Annual Revenue</label>
								<input type="text" class="form-control form-control-sm rounded-0 text-right revenue" id="revenue" name="revenue" required="required" readonly>
							</div>
							<div class="form-group mb-3">
								<label for="income_tax" class="control-label">Income Tax</label>
								<input type="text" class="form-control form-control-sm rounded-0 text-right income_tax" id="income_tax" name="income_tax" required="required" readonly>
							</div>
							<div class="form-group mb-3">
								<label for="extra_payment" class="control-label">Extra Payment</label>
								<input type="text" class="form-control form-control-sm rounded-0 text-right extra_payment" id="extra_payment" name="extra_payment" required="required" readonly>
							</div>
							<div class="form-group mb-3">
								<label for="tax_penalty" class="control-label">Tax Penalty</label>
								<input type="text" class="form-control form-control-sm rounded-0 text-right tax_penalty" id="tax_penalty" name="tax_penalty" required="required" readonly>
							</div>
							<div class="form-group mb-3">
								<label for="tin" class="control-label">Total Income Tax</label>
								<input type="text" class="form-control form-control-sm rounded-0 text-right total_income_tax" id="total_tax_amount" name="total_tax_amount" required="required" readonly>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<button class="btn btn-primary btn-sm bg-gradient-primary rounded-0" form="pass_history-form"><i class="fa fa-save"></i> Save</button>
				<a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?page=tax_payment"><i class="fa fa-angle-left"></i> Cancel</a>
			</div>
		</div>
	</div>
</div>
<script>
	function displayImg(input,_this) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#cimg').attr('src', e.target.result);
				_this.siblings('label').text(input.files[0].name)
			}

			reader.readAsDataURL(input.files[0]);
		}else{
			$('#cimg').attr('src', "<?php echo validate_image(isset($image_path) ? $image_path : '') ?>");
			_this.siblings('label').text('Choose File')
		}
	}
	$(document).ready(function(){
		$('#code').keypress(function(e){
			if(e.which == 13){
				$('#search_pass').click()
				e.preventDefault()
			}
		})
		$('#search_pass').click(function(){
			var code = $('#code').val()
			var _this = $(this).parent()
			$('.err-msg').remove();
			var el = $('<div>')
			el.addClass("alert alert-danger err-msg my-1 rounded-0")
			el.hide()
			start_loader();
			$.ajax({
				url:_base_url_+'classes/Master.php?f=search_pass_code_bill',
				method:'POST',
				data:{code:code},
				dataType:'json',
				error:err=>{
					console.log(err)
					alert("An error occurred")
					end_loader()
				},
				success:function(resp){
					console.log(resp)
					if(Object.keys(resp).length > 0){
						$('.tin_number').text(resp.company_registration)
						$('.tin_number').val((resp.company_registration))
						$('.owner').val(resp.owner)
						$('.company_name').val(resp.company_name)
						$('.category').val(resp.tax_category)
						$('.income_tax').val(resp.income_tax)
						$('.extra_payment').val(resp.extra_payment)
						$('.tax_penalty').val(resp.tax_penalty)
						$('.total_income_tax').val(parseFloat(resp.total_tax_amount))
						$('.revenue').val(resp.revenue)
					}else{
						el.text('TIN number not found')
						_this.after(el)
						el.show('slow')
					}
					end_loader()
				}
			})
		})
		$('#pass_history-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_pass_history",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast(err.err,'error');
					end_loader();
				},
				success:function(resp){
					console.log(resp)
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=tax_payment/view_payment&id="+resp.id
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body, .modal").scrollTop(0)
                            end_loader()
                    }else{
						alert_toast(resp.err,'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

	})
</script>