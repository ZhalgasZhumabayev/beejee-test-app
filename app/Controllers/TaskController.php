<?php

class TaskController extends Controller
{
    function __construct()
    {
        $this->model = new Task();
        $this->view = new View();
    }

    function index()
    {
        include '../config/database.php';
        $conn = OpenCon();
        session_start();
        $sort_type = 1;
        $sort = 'id asc';

        if ($_SESSION['admin'] != '123') {
            $_SESSION['admin'] = '';
        }

        if (isset($_GET['pg_num'])) {
            $pg_num = $_GET['pg_num'];
        } else {
            $pg_num = 1;
        }
        
        if (!isset($_GET['sort_type'])) {
            $sort_type = $_GET['sort'];
        }

        if ($sort_type == 1){
            $sort = 'id asc';
        } else if ($sort_type == 2) {
            $sort = 'id desc';
        } else if ($sort_type == 3) {
            $sort = 'username asc';
        } else if ($sort_type == 4) {
            $sort = 'username desc';
        } else if ($sort_type == 5) {
            $sort = 'email asc';
        } else if ($sort_type == 6) {
            $sort = 'email desc';
        } else if ($sort_type == 7) {
            $sort = 'status asc';
        } else if ($sort_type == 8) {
            $sort = 'status desc';
        }

        $num_of_records = 3;
        $offset = ($pg_num-1) * $num_of_records;

        $num_of_pages = "SELECT COUNT(*) FROM TASKS";
        $result = mysqli_query($conn,$num_of_pages);
        $total_records = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_records / $num_of_records);

        $sql = "SELECT * FROM TASKS ORDER BY $sort LIMIT $offset, $num_of_records";

        $data = $conn->query($sql);

        $params = array(
            'pg_num' => $pg_num,
            'total_pages' => $total_pages,
            'sort_type' => $sort_type,
        );

		$this->view->generate('template.php', 'task.php', $data, $params);
    }

    function addTask()
    {
        include '../config/database.php';
        $conn = OpenCon();

        $username = $_POST['username'];
        $email = $_POST['email'];
        $task_desc = $_POST['task_desc'];
        $status = 0;

        $sql = "INSERT INTO Tasks (username, email, task_desc, status) VALUES ('$username', '$email', '$task_desc', '$status')";

        if (mysqli_query($conn, $sql)) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            // echo $task_desc;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    function editTask() {
        include '../config/database.php';
        $conn = OpenCon();

        $task_id = $_POST['task_id'];

        $sql = "SELECT id,task_desc FROM Tasks WHERE id = '$task_id'";

        if (mysqli_query($conn, $sql)) {
            $data = $conn->query($sql);
            $this->view->generate('template.php', 'editTask.php', $data->fetch_array());
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    function saveTask(){
        include '../config/database.php';
        $conn = OpenCon();

        $task_id = $_POST['task_id'];
        $task_new_desc = $_POST['task_desc_edit'];
        $state = $_POST['stateSelect'];

        $sql = "UPDATE Tasks SET task_desc= '$task_new_desc', status = '$state', edited = 1 WHERE id='$task_id'";

        if (mysqli_query($conn, $sql)) {
            $this->view->generate('template.php', 'success.php');
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    function logout()
	{
		session_start();
		session_destroy();
		header('Location:/public/task/index');
	}
}