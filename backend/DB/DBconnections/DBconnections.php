<?php
include("DB/Configs/config.php");
include('DB/Models/DB.php');

global $servername, $username, $DBpassword, $dbname;

$db = new DB($servername, $username, $DBpassword, $dbname);
$db->connect();