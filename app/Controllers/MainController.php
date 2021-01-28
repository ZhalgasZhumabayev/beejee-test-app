<?php

class MainController extends Controller
{
    function index()
    {
        $this->view->generate('template.php', 'main.php');
    }
}