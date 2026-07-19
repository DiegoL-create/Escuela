<?php
session_start();
session_destroy();
header("Location: loginE.php");
exit();