<?php
require('../../src/config.php');

$_SESSION = [];
session_destroy();

header ("Location: ../products/index.php?logout")
?>