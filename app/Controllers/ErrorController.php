<?php

class ErrorController extends Controller
{

    function action_index()
    {
        $this->view->generate('error.php', 'template.php');
    }

}