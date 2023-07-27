<?php
$conn = mysqli_connect("localhost", "root", "", "db6");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['label']) && isset($_POST['inputType'])) {
        $labels = $_POST['label'];
        $inputTypes = $_POST['inputType'];

        foreach ($labels as $key => $label) {
            if (isset($inputTypes[$key]) && !empty($label) && !empty($inputTypes[$key])) {
                $label = mysqli_real_escape_string($conn, $label);
                $inputType = mysqli_real_escape_string($conn, $inputTypes[$key]);

                $query = "INSERT INTO users (label, input_type) VALUES ('$label', '$inputType')";
                $query_run = mysqli_query($conn, $query);

                if (!$query_run) {
                    echo "Something went wrong";
                    exit;
                }
            }
        }

        echo "Register Successfully";
    } else {
        echo "No input data received";
    }
}
?>
