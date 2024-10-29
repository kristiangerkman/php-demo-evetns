<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Dashboard</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

</head>

<?php
require_once 'classes/eventHandler.php';
require_once 'classes/dbHandler.php';
?>


<?php
$db_handler = new DatabaseHandler();
$db = $db_handler->connect();
$event_handler = new EventHandler();

$all_events = $event_handler->get_all_events($db, $_SESSION['user_id']);

$error = null;

function generateError($e)
{
    return '<div class="error-container" id="error-container"><p id="error-message">' . $e . '</p></div>';
}
?>

<!-- CREATE -->
<?php
if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['create-title']) &&
    isset($_POST['create-description']) &&
    isset($_POST['create-date']) &&
    isset($_POST['create-start_time']) &&
    isset($_POST['create-end_time'])
) {

    if (empty($db)) {
        die("connection error.");
    }

    $title = $db->real_escape_string(strip_tags($_POST['create-title']));
    $description = $db->real_escape_string(strip_tags($_POST['create-description']));
    $date = $db->real_escape_string(strip_tags($_POST['create-date']));
    $start_time = $db->real_escape_string(strip_tags($_POST['create-start_time']));
    $end_time = $db->real_escape_string(strip_tags($_POST['create-end_time']));

    $res = $event_handler->create_event(
        $db,
        $_SESSION['user_id'],
        $title,
        $description,
        $date,
        $start_time,
        $end_time,
    );

    if (is_int($res)) {
        echo '<script>window.history.replaceState(null, null, window.location.href);window.location.reload();</script>';
        exit;
    } else {
        $error = generateError($res);
    }
}
?>


<!-- UPDATE -->
<?php

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['update-title']) &&
    isset($_POST['update-description']) &&
    isset($_POST['update-date']) &&
    isset($_POST['update-start_time']) &&
    isset($_POST['update-end_time']) &&
    isset($_POST['update-event_id'])
) {
    if (empty($db)) {
        die("connection error.");
    }

    $title = $db->real_escape_string(strip_tags($_POST['update-title']));
    $description = $db->real_escape_string(strip_tags($_POST['update-description']));
    $date = $db->real_escape_string(strip_tags($_POST['update-date']));
    $start_time = $db->real_escape_string(strip_tags($_POST['update-start_time']));
    $end_time = $db->real_escape_string(strip_tags($_POST['update-end_time']));
    $event_id = $db->real_escape_string(strip_tags($_POST['update-event_id']));


    $res = $event_handler->update_event(
        $db,
        $event_id,
        $title,
        $description,
        $date,
        $start_time,
        $end_time,
    );

    if ($res === true) {
        echo '<script>window.history.replaceState(null, null, window.location.href);window.location.reload();</script>';
        exit;
    } else {
        $error = generateError($res);
    }
}
?>


<!-- DELETE -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $db = (new DatabaseHandler())->connect();
    $event_id = intval($_POST['event_id']);

    $result = $event_handler->delete_event($db, $event_id);

    if ($result === true) {
        exit;
    } else {
        $error = "Failed to delete event";
    }
}
?>

<?php 
include 'components/card_form.php';
?>
<?php include 'components/edit_card_form.php'; ?>

<script>
    const calculateDuration = (st, et) => {
        st = st.split(':')
        et = et.split(':')

        sh = st[0]
        eh = et[0]

        sm = st[1]
        em = et[1]

        var hours = Number(eh) - Number(sh)
        var mins = Number(sm) + Number(em)

        console.log(hours)
        console.log(mins)

        if (mins >= 60) {
            hours += Math.round(mins / 60)
            mins = mins % 60
        }

        console.log(hours)
        console.log(mins)


        var txh = `Duration: ${hours} hours`
        var txm = mins ? ` ${mins} minutes` : ''

        if (hours > 0 && mins > 0) {
            txh = txh + " and"
        } else if (hours == 0 && mins > 0) {
            txh = "Duration: "
        }

        return txh + txm;
    }
</script>

<body>
    <div class="dashboard">
        <?php echo $error ?>
        <a href="actions/logout.php" class="logout-button" id="logout-btn">Log out</a>
        <button type="button" class="button" id="create-new-event-btn">Create new event</button>

        <?php
        if (!empty($all_events)) {
            foreach ($all_events as $event) { ?>
                <div class="event-card">
                    <p class="card-title"><?php echo $event["title"]; ?></p>
                    <p class="card-description"><?php echo nl2br($event["description"]); ?></p>
                    <p class="card-datetime"><?php echo $event["date"]; ?> <?php echo $event["start_time"]; ?> - <?php echo $event["end_time"]; ?></p>
                    <p id="card-duration-<?php echo $event["id"] ?>" class="card-duration"></p>
                    <span
                        class="close update-event-btn"
                        data-event-id="<?php echo $event['id']; ?>"
                        data-title="<?php echo $event['title']; ?>"
                        data-desc="<?php echo htmlspecialchars($event['description']); ?>"
                        data-date="<?php echo $event['date']; ?>"
                        data-start="<?php echo $event['start_time']; ?>"
                        data-end="<?php echo $event['end_time']; ?>"
                    >
                        &#9998;
                    </span> <!-- Edit icon -->
                    <span class="close delete-btn" data-event-id="<?php echo $event['id']; ?>">&#128465;</span> <!-- Delete icon -->
                </div>
                <script>
                    var id_name = "#card-duration-<?php echo $event["id"] ?>";
                    var start_time = "<?php echo $event["start_time"] ?>";
                    var end_time = "<?php echo $event["end_time"] ?>";
                    console.log(id_name, start_time, end_time)
                    $(id_name).text(calculateDuration(start_time, end_time));
                </script>
        <?php }
        } else {
            echo '<p class="card-title">No events found.</p>';
        }
        ?>
    </div>

    <script>
        $(document).ready(function() {
            $('.delete-btn').on('click', function() {
                const event_id = $(this).data('event-id');

                if (confirm("Are you sure you want to delete this event?")) {
                    $.ajax({
                        url: '.',
                        type: 'POST',
                        data: {
                            event_id
                        },
                        success: function(response) {
                            console.log("deleted post successfully")
                            window.history.replaceState(null, null, window.location.href);
                            window.location.reload();
                        },
                        error: function() {
                            alert("There was an error processing your request.");
                        }
                    });
                }
            })
            $("#create-new-event-btn").on("click", function() {
                $("#create-new-event-form").fadeIn();
            });

            $(".update-event-btn").on("click", function() {
                const title = $(this).data('title');
                const description = $(this).data('desc');
                const date = $(this).data('date');
                const event_id = $(this).data('event-id');
                const start_time = $(this).data('start').substring(0, 5); // get rid of mysql time seconds
                const end_time = $(this).data('end').substring(0, 5);

                $('#update-title').val(title)
                $('#update-description').val(description)
                $('#update-date-picker').text(date)
                $('#update-date-input').val(date)
                $('#update-start-time-picker').text(start_time)
                $('#update-start-time-input').val(start_time)
                $('#update-end-time-picker').text(end_time)
                $('#update-end-time-input').val(end_time)
                $('#update-event-id').val(event_id)

                $("#update-event-form").fadeIn();
            });

            $("#close-btn, .modal").on("click", function(event) {
                if (event.target === this) {

                    $("#create-new-event-form").fadeOut();
                    $("#update-event-form").fadeOut();
                }
            });
        });
    </script>


</body>

</html>