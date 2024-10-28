<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Dashboard</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>

<?php include 'components/card_form.php'; ?>

<body>
    <div class="dashboard">
        <button type="button" class="button" id="create-new-event-btn"> Create new event </button>

        <div class="event-card">
            <p class="card-title">Title</p>
            <p class="card-description">This is a sample description for the event. It gives a brief overview of what the event is about.</p>
            <p class="card-datetime"> @ 04-20-2000 15:00 - 16:00</p>
            <p class="card-duration"> Duration: 1 hour</p>
            <span class="close" data-title="" data-desc="" data-date="" data-start="" data-end="">&#9998;</span> <!-- Edit icon -->
            <span class="close">&#128465;</span> <!-- Delete icon -->
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $("#create-new-event-btn").on("click", function() {
                $("#create-new-event-form").fadeIn();
            });

            $(".close, .modal").on("click", function(event) {
                if (event.target === this) {

                    $("#create-new-event-form").fadeOut();
                }
            });
        });
    </script>


</body>

</html>