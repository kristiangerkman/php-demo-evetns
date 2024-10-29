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
        flatpickr("#date-picker", {
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr) {
                document.getElementById("date-picker").innerText = dateStr;
                document.getElementById("date-input").value = dateStr;
            }
        });

        // Start Time Picker
        flatpickr("#start-time-picker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            onChange: function(selectedDates, timeStr) {
                document.getElementById("start-time-picker").innerText = timeStr;
                document.getElementById("start-time-input").value = timeStr;
            }
        });

        // End Time Picker
        flatpickr("#end-time-picker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            onChange: function(selectedDates, timeStr) {
                document.getElementById("end-time-picker").innerText = timeStr;
                document.getElementById("end-time-input").value = timeStr;
            }
        });

    });
</script>

<body>
    <div class="modal" id="create-new-event-form">
        <div class="form-container modal-content">
            <span class="close">&times;</span>
            <h1>Create Event</h1>
            <div class="card-form" id="card-form">
                <form action="" method="post">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="create-title" />

                    <label for="description">Description:</label>
                    <textarea id="description" rows="4" name="create-description"></textarea>

                    <div class="select-date-container">
                        <label for="date-picker">Date:</label>
                        <p id="date-picker" class="select-date">Click to select a date</p>
                        <input type="hidden" id="date-input" name="create-date">
                    </div>

                    <div class="select-time-container">
                        <label for="start-time-picker">Start Time:</label>
                        <p id="start-time-picker" class="select-time">00:00</p>
                        <input type="hidden" id="start-time-input" name="create-start_time">
                    </div>

                    <div class="select-time-container">
                        <label for="end-time-picker">End Time:</label>
                        <p id="end-time-picker" class="select-time">00:00</p>
                        <input type="hidden" id="end-time-input" name="create-end_time">
                    </div>

                    <div class="button-container">
                        <input class="button" type="submit" value="Create" id="create">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>