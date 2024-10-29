<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Flatpickr CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Date Picker
        flatpickr("#update-date-picker", {
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr) {
                document.getElementById("update-date-picker").innerText = dateStr;
                document.getElementById("update-date-input").value = dateStr;
            }
        });

        // Start Time Picker
        flatpickr("#update-start-time-picker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            onChange: function(selectedDates, timeStr) {
                document.getElementById("update-start-time-picker").innerText = timeStr;
                document.getElementById("update-start-time-input").value = timeStr;
            }
        });

        // End Time Picker
        flatpickr("#update-end-time-picker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            onChange: function(selectedDates, timeStr) {
                document.getElementById("update-end-time-picker").innerText = timeStr;
                document.getElementById("update-end-time-input").value = timeStr;
            }
        });

    });
</script>

<body>
    <div class="modal" id="update-event-form">
        <div class="form-container modal-content">
            <span class="close" id="close-btn">&times;</span>
            <h1>Edit Event</h1>
            <div class="card-form" id="card-form">
                <form action="" method="post">
                    <label for="title">Title:</label>
                    <input type="text" name="update-title" id="update-title" />

                    <label for="description">Description:</label>
                    <textarea name="update-description" id="update-description" rows="4"></textarea>

                    <div class="select-date-container">
                        <label for="date-picker">Date:</label>
                        <p id="update-date-picker" class="select-date">Click to select a date</p>
                        <input type="hidden" id="update-date-input" name="update-date">
                    </div>

                    <div class="select-time-container">
                        <label for="start-time-picker">Start Time:</label>
                        <p id="update-start-time-picker" class="select-time">00:00</p>
                        <input type="hidden" id="update-start-time-input" name="update-start_time">
                    </div>

                    <div class="select-time-container">
                        <label for="end-time-picker">End Time:</label>
                        <p id="update-end-time-picker" class="select-time">00:00</p>
                        <input type="hidden" id="update-end-time-input" name="update-end_time">
                    </div>

                    <input type="hidden" id="update-event-id" name="update-event_id">
                    <div class="button-container">
                        <input class="button" type="submit" value="Update" id="create">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>