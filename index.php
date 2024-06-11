<?php
require_once('connect.php');

$sql = $thread->prepare("select * from tb_employees order by employee_id asc");
$sql->execute();
$data = $sql->fetchAll();


//delete data--------
if(isset($_POST['delete_data'])) {
	$delete_id = $_POST['delete_id'];
	if(!$delete_id) {
		echo '<script>alert("Something error ..")</script>';
		header("refresh:1; url=index.php");
	} else {
		$querydelete = $thread->prepare("delete from tb_employees where employee_id=?");
		$response = $querydelete->execute(array($delete_id));
		if($response) {
			echo '<script>alert("Delete successfully ..")</script>';
			header("refresh:2; url=index.php");
		} else {
			echo '<script>alert("Something error ..")</script>';
		}
	}
}

//get employees data to edit -------
if(isset($_POST['edit_status'])) {
	$employeee_id = $_POST['employeed_id'];
	$result_array = [];

	try {
	    $sql = $thread->prepare("SELECT * FROM tb_employees WHERE employee_id = ?");
	    $sql->execute(array($employeee_id));

	    $data = $sql->fetchAll(PDO::FETCH_ASSOC);
	    if(count($data) > 0) {
	    	foreach($data as $row) {
	    		array_push($result_array, $row);
	    	}
	    }
	    echo json_encode($result_array);
	} catch (PDOException $e) {
	    echo "Error: " . $e->getMessage();
	}
	die();
}

//get job data ---------
if(isset($_POST['get_status_job'])) {
	$dept_id = $_POST['dept_id'];
	$result_job = [];
	
	try {
		$sql = $thread->prepare("select * from tb_job where dept_id=?");
		$sql->execute(array($dept_id));

		$data = $sql->fetchAll(PDO::FETCH_ASSOC);
		if(count($data) > 0) {
			foreach($data as $row) {
				array_push($result_job, $row);
			}
		}
		echo json_encode($result_job);
	} catch(PDOExecption $e) {
		echo "error " . $e->getMessage();
	};
	die();
}


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
  </head>
  <body>
  	<center><h1>Employees List.</h1></center><br>
  	<div class="row">
  		<div class="col-md-10 container overflow-hidden">
		<button type="button" class="btn btn-success addButton">Add new Employees</button>
  		</div>
  	</div>
  	<div class="row">
  		<div class="col-md-10 container overflow-hidden text-center">
  			<table class="table table-striped">
	  <thead>
	    <tr>
	      <th scope="col">Employee ID</th>
	      <th scope="col">First Name</th>
	      <th scope="col">Last Name</th>
	      <th scope="col">Email</th>
	      <th scope="col">Phone Number</th>
	      <th scope="col">Join Date</th>
	      <th scope="col">Dept. ID</th>
	      <th scope="col">Salary</th>
	      <th scope="col">Job ID</th>
	      <th scope="col">Last Update</th>
	      <th scope="col">#</th>
	    </tr>
	  </thead>
	  <tbody>
	  	<tr>
	  		<?php
	  		if(count($data) > 0) {
	  			foreach($data as $row) { ?>
	  				<tr>
		  				<td class="employee_id"><?= $row['employee_id']; ?></td>
		  				<td><?= $row['first_name']; ?></td>
		  				<td><?= $row['last_name']; ?></td>
		  				<td><?= $row['email']; ?></td>
		  				<td><?= $row['phone_number']; ?></td>
		  				<td><?= $row['join_date']; ?></td>
		  				<td><?= $row['dept_id']; ?></td>
		  				<td><?= "Rp.".number_format((double)$row['salary'],0,',','.').",-"; ?></td>
		  				<td><?= $row['job_id']; ?></td>
		  				<td><?= $row['last_update']; ?></td>
		  				<td>
		  					<button type="button" class="btn btn-primary update-button"><i class="bi bi-pencil-square"></i></button>
		  					<button type="button" class="btn btn-danger delete-button"><i class="bi bi-trash3"></i></button>
		  				</td>
		  			</tr>
	  			<?php }
	  		} else { ?>
	  			<td colspan="11" align="center"><h4>No data employees</h4></td>
	  		<?php }
	  	?>
	  	</tr>
	  </tbody>
	</table>
  		</div>
  	</div>

	<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="DeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="DeleteModalLabel">Confirm Delete!</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="">
      <div class="modal-body">
        	<input type="hidden" name="delete_id" id="delete_id" reaonly />
        	Are you sure you want to delete this data ??
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="delete_data" class="btn btn-danger">Delete!</button>
      </div>
  	</form>
    </div>
  </div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="UpdateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="UpdateModalLabel">Update Data Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="update.php">
      <div class="modal-body">
      	<div class="row">
      		<input type="hidden" id="id_edit" name="id_edit"/>
      		<div class="col-6">
      			<div class="mb-3">
				  <label for="first_name" class="form-label">First Name</label>
				  <input type="text" class="form-control" id="first_name" name="first_name" placeholder="John">
				</div>
				<div class="mb-3">
				  <label for="last_name" class="form-label">Last Name</label>
				  <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Doe">
				</div>
	        	<div class="mb-3">
				  <label for="email" class="form-label">Email address</label>
				  <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
				</div>
				<div class="mb-3">
				  <label for="phone_number" class="form-label">Phone Number</label>
				  <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="62812779xxx">
				</div>
      		</div>
      		<div class="col-6">
				<div class="mb-3">
				  <label for="department" class="form-label">Department</label>
				  <select class="form-select" id="department" name="department" aria-label="Default select example">
				  	<option disabled>--select--</option>
					<?php
						$sql = $thread->prepare('select * from tb_department order by dept_name asc');
						$sql->execute();
						$data = $sql->fetchAll();
						foreach($data as $r) { ?>
							<option name="dept_id" value="<?= $r['dept_id']; ?>"><?= $r['dept_name']; ?></option>
						<?php }
					?>
				  </select>
				</div>
				<div class="mb-3">
				  <label for="job_title" class="form-label">Job Title</label>
				  <select class="form-select" id="job" name="job" aria-label="Default select example">
				  	<option value="">--select--</option>
				  </select>
				</div>
				<div class="mb-3">
				  <label for="salary" class="form-label">Salary</label>
				  <input type="text" class="form-control" id="salary" name="salary" placeholder="5000000">
				</div>
				<div class="mb-3">
				  <label for="join_date" class="form-label">Join Date</label>
				  <input type="date" class="form-control" id="join_date" name="join_date" />
				</div>
			</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="update_data" class="btn btn-success">Update</button>
      </div>
  	</form>
    </div>
  </div>
</div>

<div class="modal fade" id="addButton" tabindex="-1" aria-labelledby="AddWModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="AddWModalLabel">Add new Data Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="insert.php">
      <div class="modal-body">
      	<div class="row">
      		<div class="col-6">
      			<div class="mb-3">
				  <label for="first_name" class="form-label">First Name</label>
				  <input type="text" class="form-control" id="first_name" name="first_name" placeholder="John">
				</div>
				<div class="mb-3">
				  <label for="last_name" class="form-label">Last Name</label>
				  <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Doe">
				</div>
	        	<div class="mb-3">
				  <label for="email" class="form-label">Email address</label>
				  <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
				</div>
				<div class="mb-3">
				  <label for="phone_number" class="form-label">Phone Number</label>
				  <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="62812779xxx">
				</div>
      		</div>
      		<div class="col-6">
				<div class="mb-3">
				  <label for="dept_id" class="form-label">Department</label>
				  <select class="form-select" id="dept_id" name="dept_id" aria-label="Default select example">
				  	<option>--select--</option>
					<?php
						$sql = $thread->prepare('select * from tb_department order by dept_name asc');
						$sql->execute();
						$data = $sql->fetchAll();
						foreach($data as $r) { ?>
							<option	 value="<?= $r['dept_id']; ?>"><?= $r['dept_name']; ?></option>
						<?php }
					?>
				  </select>
				</div>
				<div class="mb-3">
				  <label for="job_id" class="form-label">Job Title</label>
				  <select class="form-select" id="job_id" name="job_id" aria-label="Default select example">
				  	<option value="">--select--</option>
				  </select>
				</div>
				<div class="mb-3">
				  <label for="salary" class="form-label">Salary</label>
				  <input type="text" class="form-control" id="salary" name="salary" placeholder="5000000">
				</div>
				<div class="mb-3">
				  <label for="join_date" class="form-label">Join Date</label>
				  <input type="date" class="form-control" id="join_date" name="join_date" />
				</div>
			</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" name="insert_data" class="btn btn-success">Update</button>
      </div>
  	</form>
    </div>
  </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

	<script>
		$(document).ready(function () {
			$('.addButton').click(function (e) {
				e.preventDefault();
				$('#addButton').modal('show');
			});

			$('.delete-button').click(function (e) {
				e.preventDefault();
				var employee_id = $(this).closest('tr').find('.employee_id').text();
				console.log(employee_id);
				$('#delete_id').val(employee_id);
				$('#deleteModal').modal('show');	
			})

			$('.update-button').click(function (e) {
				e.preventDefault();
				var employee_id = $(this).closest('tr').find('.employee_id').text();
				// console.log(employee_id);

				$.ajax({
					type: "POST",
					data: {
						'employeed_id': employee_id,
						'edit_status': true,
					},
					url: "index.php",
					success: function(response) {
						var datas = $.parseJSON(response);
						$('#id_edit').val(datas[0].employee_id);
						$('#first_name').val(datas[0].first_name);
						$('#last_name').val(datas[0].last_name);
						$('#email').val(datas[0].email);
						$('#phone_number').val(datas[0].phone_number);
						$('#join_date').val(datas[0].join_date);
						// $('#department').val(datas[0].dept_id);
						$('#job_title').val(datas[0].job_id);
						$('#salary').val(datas[0].salary);
					}
				});
				$('#updateModal').modal('show');
			});

			$('#department').change(function () {
				var dept_id = $(this).val();
				console.log(dept_id);

				$.ajax({ 
					type: "POST",
					data: {
						'get_status_job': true,
						'dept_id':dept_id 
					},
					url: "index.php",
					success: function(response) {
						var datas = $.parseJSON(response);
						$('#job').empty();
						datas.forEach(function (tadas) {
							$('#job').append('<option disabled>--select--</option>');
							$('#job').append('<option value='+tadas.job_id+'>'+ tadas.job_name+'</option');
						});

					}
				})
			});

			$('#dept_id').change(function () {
				var dept_id = $(this).val();
				console.log(dept_id);

				$.ajax({ 
					type: "POST",
					data: {
						'get_status_job': true,
						'dept_id':dept_id 
					},
					url: "index.php",
					success: function(response) {
						var datas = $.parseJSON(response);
						$('#job_id').empty();
						datas.forEach(function (tadas) {
							$('#job_id').append('<option disabled>--select--</option>');
							$('#job_id').append('<option value='+tadas.job_id+'>'+ tadas.job_name+'</option');
						});

					}
				})
			});
		});
	</script>
  </body>
</html>