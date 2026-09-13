<?php
session_start();

session_unset();
session_destroy();

header("Location: https://pukaar.hireflow.fun");
exit();
?>