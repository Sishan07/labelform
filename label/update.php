<?php
require_once('config/db.php');

if (isset($_POST['id'], $_POST['label'], $_POST['inputType'])) {
    $id = $_POST['id'];
    $label = $_POST['label'];
    $inputType = $_POST['inputType'];

    $query = "UPDATE users SET label='$label', input_type='$inputType' WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Data updated successfully!";
    } else {
        echo "Error updating data: " . mysqli_error($conn);
    }
}

$conn->close();
?>
