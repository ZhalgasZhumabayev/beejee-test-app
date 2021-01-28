<?php

class LoginController extends Controller
{

    function __construct()
    {
        $this->view = new View();
    }

	function index()
	{

		if(isset($_POST['login']) && isset($_POST['password']))
		{
			$login = $_POST['login'];
            $password = $_POST['password'];
            
			if($login=="admin" && $password=="123")
			{
				$data["login_status"] = "access_granted";
				session_start();
                echo $_SESSION['admin'];
                $_SESSION['admin'] = $password;
                
				header('Location:/public/task/index');
			}
			else
			{
				$data["login_status"] = "access_denied";
			}
		}
		else
		{
			$data["login_status"] = "";
		}
		
		$this->view->generate('template.php', 'login.php', $data);
	}
	
}
