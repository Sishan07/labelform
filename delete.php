<?php
require_once('config/db.php');

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "DELETE FROM users WHERE id = '$id'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: form.php");
        exit();
    } else {
        die("Query unsuccessful.");
    }
}
?>
