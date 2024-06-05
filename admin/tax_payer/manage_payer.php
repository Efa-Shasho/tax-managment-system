<?php

if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `tax_payer_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="mx-0 py-5 px-3 mx-ns-4 bg-gradient-primary">
	<h3><b><?= isset($id) ? "Update Tax Payer Details" : "Register Tax Payer" ?></b></h3>
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
						<form action="" id="pass-form">
							
							<div class="form-group mb-3">
								<label for="owner" class="control-label">Full Name</label>
								<input type="text" class="form-control form-control-sm rounded-0" id="owner" name="owner" value="<?= isset($owner) ? $owner : '' ?>" required="required">
							</div>
							<div class="form-group mb-3">
								<label for="age" class="control-label">Age</label>
								<input type="text" class="form-control form-control-sm rounded-0" id="age" name="age" value="<?= isset($age) ? $age : '' ?>" required="required">
							</div>
							<div class="form-group mb-3">
								<label for="sex" class="control-label">Sex</label>
								<select class="form-select form-control form-control-sm rounded-0" name="sex" aria-label="Default select example">
									<option selected></option>
									<option value="Male">Male</option>
									<option value="Female">Female</option>
								</select>
							</div>
							<div class="form-group mb-3">
								<label for="address" class="control-label">Address</label>
								<input type="text" class="form-control form-control-sm rounded-0" id="address" name="address" value="<?= isset($address) ? $address : '' ?>" required="required">
							</div>
							<div class="form-group mb-3">
								<label for="house_size" class="control-label">House No.</label>
								<input type="text" class="form-control form-control-sm rounded-0" id="house_number" name="house_number" value="<?= isset($house_number) ? $house_number : '' ?>" required="required">
							</div>
							<div class="form-group mb-3">
								<label for="house_size" class="control-label">Tel.</label>
								<input type="text" class="form-control form-control-sm rounded-0" id="phone_number" name="phone_number" value="<?= isset($phone_number) ? $phone_number : '' ?>" required="required">
							</div>
							<div class="form-group mb-3">
								<label for="house_size" class="control-label">House Size</label>
								<input type="text" class="form-control form-control-sm rounded-0" id="house_size" name="house_size" value="<?= isset($house_size) ? $house_size : '' ?>" required="required">
							</div>
							<div class="form-group mb-3">
								<label for="house_ownership" class="control-label">House Ownership</label>
								<input type="text" class="form-control form-control-sm rounded-0" id="house_ownership" name="house_ownership" value="<?= isset($house_ownership) ? $house_ownership : '' ?>" required="required">
							</div>
							
							<div class="form-group mb-3">
								<label for="company_name" class="control-label">Business Name</label>
								<input type="text" class="form-control form-control-sm rounded-0" id="company_name" name="company_name" value="<?= isset($company_name) ? $company_name : '' ?>" required="required">
							</div>
							
						</form>
					</div>
				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<button class="btn btn-primary btn-sm bg-gradient-primary rounded-0" form="pass-form"><i class="fa fa-save"></i> Save</button>
				<a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?page=tax_payer"><i class="fa fa-angle-left"></i> Cancel</a>
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
		console.log(<?php echo isset($id) ?> "wtd")
		$('.tin_number').val()

		$('#category_id').select2({
			placeholder:'Please Select Category Here',
			containerCssClass:'form-control form-control-sm rounded-0'
		})
		$('#pass-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_pass",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=tax_payer/view_payer&id="+resp.rid
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