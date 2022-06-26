<?php

session_start();
include "config.php";

if ($_SESSION["user"]) {
    header("location: index.php");
}