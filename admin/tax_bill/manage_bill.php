<?php

if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `bill_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="mx-0 py-5 px-3 mx-ns-4 bg-gradient-primary">
	<h3><b><?= isset($id) ? "Update Bill Details" : "Create New Bill" ?></b></h3>
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
						<form action="" id="recipient-form">
							<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
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
								<input type="text" class="form-control form-control-sm rounded-0 text-right tin_number" id="company_registration" name="company_registration" value="<?php echo isset($company_registration) ? $company_registration : '' ?>" required="required" readonly>
							</div>
							<div class="form-group mb-3">
								<label for="owner" class="control-label">Business Owner</label>
								<input type="text" class="form-control form-control-sm rounded-0 text-right owner" id="owner" name="owner" value="<?php echo isset($owner) ? $owner : '' ?>" required="required" readonly>
							</div>
							<div class="form-group mb-3">
								<label for="comapny_name" class="control-label">Company Name</label>
								<input type="text" class="form-control form-control-sm rounded-0 text-right company_name" id="company_name" name="company_name" value="<?php echo isset($company_name) ? $company_name : '' ?>" required="required" readonly>
							</div>
							<div class="form-group mb-3">
								<label for="category_id" class="control-label">Tax Category</label>
								<select class="form-control form-control-sm rounded-0" id="tax_category" name="tax_category" required="required">
									<option <?= !isset($category_id) ? 'selected' : '' ?> value="" disabled="disabled"></option>
									<?php 
									$qry = $conn->query("SELECT * FROM `category_list` where delete_flag = 0 and `status` = 1 ".(isset($category_id) && $category_id > 0 ? " or id = '{$category_id}' " : '')." ");
									while($row= $qry->fetch_assoc()):
									?>
									<option value="<?= $row['name'] ?>" <?= isset($category_id) && $category_id == $row['name'] ? "selected" : '' ?>><?= $row['name'] ?></option>
									<?php endwhile; ?>
								</select>
							</div>
							
							<div class="form-group mb-3">
								<label for="revenue" class="control-label">Annual Revenue</label>
								<input type="number" step="any" class="form-control form-control-sm rounded-0 text-right" id="revenue" name="revenue" value="<?= isset($revenue) ? $revenue : '' ?>" required="required">
							</div>
							<div class="form-group mb-3">
								<label for="income_tax" class="control-label">Income Tax</label>
								<input type="number" step="any" class="form-control form-control-sm rounded-0 text-right" id="income_tax" name="income_tax" value="<?= isset($income_tax) ? $income_tax : '' ?>" required="required">
							</div>
							<div class="form-group mb-3">
								<label for="tax_penalty" class="control-label">Tax Penalty</label>
								<input type="number" step="any" class="form-control form-control-sm rounded-0 text-right" id="tax_penalty" name="tax_penalty" value="<?= isset($tax_penalty) ? $tax_penalty : '' ?>" required="required">
							</div>
							<div class="form-group mb-3">
								<label for="extra_payment" class="control-label">Extra Payment</label>
								<input type="number" step="any" class="form-control form-control-sm rounded-0 text-right" id="extra_payment" name="extra_payment" value="<?= isset($extra_payment) ? $extra_payment : '' ?>" required="required">
							</div>
							<div class="form-group mb-3">
								<label for="tin" class="control-label">Total Income Tax</label>
								<input type="text" class="form-control form-control-sm rounded-0 text-right total_income_tax" id="total_tax_amount" name="total_tax_amount" value="<?php echo isset($total_tax_amount) ? $total_tax_amount : '' ?>" required="required">
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<button class="btn btn-primary btn-sm bg-gradient-primary rounded-0" form="recipient-form"><i class="fa fa-save"></i> Save</button>
				<a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?page=tax_bill"><i class="fa fa-angle-left"></i> Cancel</a>
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
		$('#category_id').select2({
			placeholder:'Please Select Category Here',
			containerCssClass:'form-control form-control-sm rounded-0'
		})
		$('#toll_id.select2').select2({
			placeholder:'Please Select Toll Here',
			containerCssClass:'form-control form-control-sm rounded-0'
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
				url:_base_url_+'classes/Master.php?f=search_pass_code_payer',
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
						$('.category').val(resp.category)
						$('.income_tax').val(resp.tax_amount)
						$('.extra_payment').val(resp.extra_payment)
						$('.tax_penalty').val(resp.tax_penalty)
						$('.total_income_tax').val(parseFloat(resp.tax_amount) + parseFloat(resp.tax_penalty) + parseFloat(resp.extra_payment))
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

		$('#recipient-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_recipient",
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
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=tax_bill/view_bill&id="+resp.rid
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body, .modal").scrollTop(0)
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

	})
</script>