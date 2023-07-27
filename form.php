<?php
require_once('config/db.php');
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form repeater</title>
</head>

<body>
    <h1>Form</h1>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $label = $row['label'];
        $inputType = $row['input_type'];
    ?>
        <div class="row" data-id="<?php echo $id; ?>">
            <input type="text" name="label[]" value="<?php echo $label ?>">
            <select name="inputType[]">
                <option value="text" <?php if ($inputType === 'text') echo 'selected'; ?>>Text</option>
                <option value="number" <?php if ($inputType === 'number') echo 'selected'; ?>>Number</option>
                <option value="email" <?php if ($inputType === 'email') echo 'selected'; ?>>Email</option>
            </select>
            <button onclick="deleteFile('<?php echo $id; ?>')" class="delete">Delete</button>
        </div>
    <?php
    }
    $conn->close();
    ?>

    <form action="connect.php" method="POST" id="frmBox">
        <div id="repeater-container"></div>
        <div id="button-container">
            <button type="button" id="add-btn">Add Row</button>
            <input type="submit" name="submit" id="submit" value="Submit">
        </div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add button click event
            $('#add-btn').click(function() {
                var newRow = '<div class="row">' +
                    '<input type="text" name="label[]" placeholder="Label">' +
                    '<select name="inputType[]">' +
                    '<option value="text">Text</option>' +
                    '<option value="number">Number</option>' +
                    '<option value="email">Email</option>' +
                    '</select>' +
                    '<button class="delete">Delete</button>' +
                    '</div>';
                $('#repeater-container').append(newRow);
            });


            $(document).on('click', '.delete', function() {
                var id = $(this).closest('.row').data('id');
                deleteFile(id);
            });

            $(document).on('click', '#submit', function(event) {
                event.preventDefault();
                var rows = $('.row');
                rows.each(function() {
                    var id = $(this).data('id');
                    updateFile(id);
                });
                formSubmit();
            });

            function formSubmit() {
                var form = $('#frmBox');
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(response) {
                        $('#success').html(response);
                        $('#repeater-container').empty();
                        form[0].reset();
                        location.reload();
                    }
                });
            }

            function deleteFile(id) {
                $.ajax({
                    type: 'POST',
                    url: 'delete.php?id=' + id,
                    success: function(response) {
                        location.reload();
                    }
                });
            }

            function updateFile(id) {
                var row = $('.row[data-id="' + id + '"]');
                var label = row.find('input[name="label[]"]').val();
                var inputType = row.find('select[name="inputType[]"]').val();

                $.ajax({
                    type: 'POST',
                    url: 'update.php',
                    data: {
                        id: id,
                        label: label,
                        inputType: inputType
                    },
                    success: function(response) {
                        console.log(response);
                    }
                });
            }
        });
    </script>
</body>

</html>