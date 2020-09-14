<?php
session_start();
if ($_SESSION["loggedin"] == 'true') {
  session_destroy();
    echo "<script type='text/javascript'> document.location = '../index.php'; </script>";
}
else {
    echo "<script>alert('Please login first.');</script>";
}
?>

