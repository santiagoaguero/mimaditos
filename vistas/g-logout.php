<?php
unset($_SESSION['user_token']);
session_destroy();
header("Location: index.php");