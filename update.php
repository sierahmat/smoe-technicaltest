<?php

require_once('connect.php');

if(isset($_POST['update_data'])) {
	$emp_id = $_POST['id_edit'];
	$firstname = $_POST['first_name'];
	$lastname = $_POST['last_name'];
	$email = $_POST['email'];
	$phone  = $_POST['phone_number'];
	$join_date = $_POST['join_date'];
	$dept_id = $_POST['department'];
	$job_id = $_POST['job'];
	$salary = $_POST['salary'];
	$last_update = date("Y-m-d");

	// echo $last_update;
	if(!$firstname || !$lastname || !$email || !$phone || !$dept_id || !$job_id || !$salary) {
		echo '<script>alert("ada yang kosong ..");</script>';
		header('refresh:1; url=index.php');
	} else {
		$sql = $thread->prepare("select * from tb_employees where employee_id=?");
		$sql->execute(array($emp_id));

		$data = $sql->fetchAll(PDO::FETCH_ASSOC);

		if(count($data) > 0) {
			$query = $thread->prepare("update tb_employees set first_name=?, last_name=?, email=?, phone_number=?, join_date=?, dept_id=?, job_id=?, salary=?, last_update=? where employee_id=?");
			$update = $query->execute([$firstname, $lastname, $email, $phone, $join_date, $dept_id, $job_id, $salary, $last_update, $emp_id]);

			if($update) {
				echo '<script>alert("Update successfully");</script>';
				header('refresh:1; url=index.php');
			} else {
				echo $query;
			}

		}
	}
} else {
	header('location:index.php');
}

