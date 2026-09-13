<?php
session_start();
session_unset();
session_destroy();

// Redirect back to the Responder login page
header("Location: ../index.php");
exit();
?>