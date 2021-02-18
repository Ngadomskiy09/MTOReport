<?php
session_start();
session_unset();
session_destroy();
$_SESSION = array();

//header("location:/355/NC-Document-Online");
header("location:/");