<?php
/**
 * Created by PhpStorm.
 * User: skram
 * Date: 28.01.2021
 * Time: 14:56
 */

function OpenCon()
{
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $db = "test";
    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

    return $conn;
}

function CloseCon($conn)
{
    $conn -> close();
}
