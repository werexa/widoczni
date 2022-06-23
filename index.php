<?php
require("WNzadRekrutacyjne/controllers/Page.php");

$name = $_GET["action"];

//var_dump($name);
$page = new Page($name);

$page->makePage();
