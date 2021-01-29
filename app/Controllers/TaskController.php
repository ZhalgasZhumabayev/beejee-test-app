<?php

include '../config/database.php';

class TaskController extends Controller
{
    function __construct()
    {
        $this->model = new Task();
        $this->view = new View();
    }

    function index()
    {
        $conn = OpenCon();
        session_start();
        $sort_type = 1;
        $sort = 'id asc';

        if ($_SESSION['admin'] != '123')
        {
            $_SESSION['admin'] = '';
        }

        if (isset($_GET['pg_num']))
        {
            $pg_num = $_GET['pg_num'];
        } else {
            $pg_num = 1;
        }
        
        if (!isset($_GET['sort_type']))
        {
            $sort_type = $_GET['sort'];
        }

        if ($sort_type == 1)
        {
            $sort = 'id asc';
        } else if ($sort_type == 2)
        {
            $sort = 'id desc';
        } else if ($sort_type == 3)
        {
            $sort = 'username asc';
        } else if ($sort_type == 4)
        {
            $sort = 'username desc';
        } else if ($sort_type == 5)
        {
            $sort = 'email asc';
        } else if ($sort_type == 6)
        {
            $sort = 'email desc';
        } else if ($sort_type == 7)
        {
            $sort = 'status asc';
        } else if ($sort_type == 8)
        {
            $sort = 'status desc';
        }

        $num_of_records = 3;
        $offset = ($pg_num-1) * $num_of_records;

        $num_of_pages = "SELECT COUNT(*) FROM Tasks";
        $result = mysqli_query($conn,$num_of_pages);
        $total_records = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_records / $num_of_records);

        $sql = "SELECT * FROM Tasks ORDER BY $sort LIMIT $offset, $num_of_records";

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
        $conn = OpenCon();

        $username = $_POST['username'];
        $email = $_POST['email'];
        $task_desc = $_POST['task_desc'];
        $status = 0;

        if ($username == "" && $email == "" && $task_desc == "")
        {
            $data = array(
                'desc' => 'All fields are required',
            );
            $this->view->generate('template.php', 'error.php', $data);
        } else
        {
            $sql = "INSERT INTO Tasks (username, email, task_desc, status) VALUES ('$username', '$email', '$task_desc', '$status')";

            if (mysqli_query($conn, $sql))
            {
                $data = array(
                    'desc' => 'Task successfully added',
                );
                $this->view->generate('template.php', 'success.php', $data);
            } else
            {
                $data = array(
                    'desc' => 'Error in fields',
                );
                $this->view->generate('template.php', 'error.php', $data);
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }

    function editTask()
    {
        $conn = OpenCon();

        $task_id = $_POST['task_id'];

        $sql = "SELECT id,task_desc FROM Tasks WHERE id = '$task_id'";

        if (mysqli_query($conn, $sql))
        {
            $data = $conn->query($sql);
            $this->view->generate('template.php', 'editTask.php', $data->fetch_array());
        } else
        {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    function saveTask()
    {
        $conn = OpenCon();

        $task_id = $_POST['task_id'];
        $task_new_desc = $_POST['task_desc_edit'];
        $task_desc_sql = "SELECT task_desc, status FROM Tasks where id = '$task_id'";
        $task_query = mysqli_query($conn, $task_desc_sql);
        $task_desc = mysqli_fetch_array($task_query)[0];
        $task_status = mysqli_fetch_array($task_query)[1];
        $state = (int)$_POST['stateSelect'];

        if ($task_new_desc != $task_desc && $state != $task_status)
        {
            $sql = "UPDATE Tasks SET task_desc= '$task_new_desc', status = '$state', edited = 1 WHERE id='$task_id'";
        } elseif ($task_new_desc != $task_desc)
        {
            $sql = "UPDATE Tasks SET task_desc= '$task_new_desc', edited = 1 WHERE id='$task_id'";
        } else
        {
            $sql = "UPDATE Tasks SET status = '$state' WHERE id='$task_id'";
        }

        if (mysqli_query($conn, $sql))
        {
            $data = array(
                'desc' => 'Task successfully edited',
            );
            $this->view->generate('template.php', 'success.php', $data);
        } else
        {
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