<?php
require("WNzadRekrutacyjne/controllers/Page.php");

$name = $_GET["action"]  ?? "";
$page = new Page($name);

$page->makePage();
