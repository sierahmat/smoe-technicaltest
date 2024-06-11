<?php

require_once('connect.php');

if(isset($_POST['insert_data'])) {
	$emp_id = rand(1111111111,9999999999);
	$firstname = $_POST['first_name'];
	$lastname = $_POST['last_name'];
	$email = $_POST['email'];
	$phone  = $_POST['phone_number'];
	$join_date = $_POST['join_date'];
	$dept_id = $_POST['dept_id'];
	$job_id = $_POST['job_id'];
	$salary = $_POST['salary'];
	$last_update = date("Y-m-d");
	// echo $emp_id;

	// echo $last_update;
	if(!$firstname || !$lastname || !$email || !$phone || !$join_date || !$dept_id || !$job_id || !$salary) {
		echo '<script>alert("ada yang kosong ..");</script>';
		header('refresh:1; url=index.php');
	} else {
		$query = $thread->prepare("insert into tb_employees values (?,?,?,?,?,?,?,?,?,?)");
		$insert = $query->execute([$emp_id, $firstname, $lastname, $email, $phone, $join_date, $dept_id, $salary, $job_id, $last_update]);
		if($insert) {
			echo '<script>alert("Insert successfully");</script>';
			header('refresh:1; url=index.php');
		} else {
			echo $query;
		}
	}
} else {
	header('location:index.php');
}
