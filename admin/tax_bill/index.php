
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">List of Bills</h3>
		<div class="card-tools">
			<a href="./?page=tax_bill/manage_bill" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Generate Bill</a>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Business Owner</th>
						<th>Company Name</th>
						<th>TIN No.</th>
						<th>Revenue</th>
						<th>Tot. Income Tax</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$uwhere = "";
					//if($_settings->userdata('type') >=0)
					//$uwhere =" where r.user_id = '{$_settings->userdata('id')}' ";
					$qry = $conn->query("SELECT r.*, t.owner as `owner` from `bill_list` r inner join `bill_list` t on r.id = t.id {$uwhere} order by unix_timestamp(r.`date_created`) desc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['owner'] ?></td>
							<td><?php echo $row['company_name'] ?></td>
							<td><?php echo $row['company_registration'] ?></td>
							<td><?php echo $row['revenue'] ?></td>
							<td><?php echo $row['total_tax_amount'] ?></td>
							<td>
								<?php if($row['payment_status'] == 1): ?>
                                    <span class="badge badge-success px-3 rounded-pill">Paid</span>
									<?php else: ?>
										<span class="badge badge-danger px-3 rounded-pill">Unpaid</span>
								<?php endif; ?>
							</td>
							<!-- <td><?php echo date("Y-m-d",strtotime($row['date_created'])) ?></td> -->
							<td align="center">
								 <button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="./?page=tax_bill/view_bill&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
									<?php if($_settings->userdata('type') == 1): ?> 
				                    <div class="dropdown-divider"></div>
									<a class="dropdown-item edit_data" href="./?page=tax_bill/manage_bill&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
									<?php endif ?>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this bill permanently?","delete_recipient",[$(this).attr('data-id')])
		})
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [4] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	function delete_recipient($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_recipient",
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
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>