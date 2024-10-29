<?php
class EventHandler
{
    function create_event($db, $user_id, $title, $description, $date, $start_time, $end_time)
    {
        $error = null;

        $sql = "INSERT INTO events (
                                user_id,
                                title,
                                description,
                                date,
                                start_time,
                                end_time,
                                created_at,
                                updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";

        if (!($stmt = $db->prepare($sql))) {
            $error = "Prepare failed: (" . $db->errno . ") " . $db->error;
            return $error;
        }

        if (!$stmt->bind_param("isssss", $user_id, $title, $description, $date, $start_time, $end_time)) {
            $error = "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }

        try {
            if ($stmt->execute()) {
                if (is_int($db->insert_id)) {
                    return $db->insert_id;
                } else {
                    $error = "insert_id not int";
                    return $error;
                }
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) { // MySQL error code for duplicate entry
                $error = "Error: Username already exists.";
                return $error;
            } else {
                $error = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                return $error;
            }
        }
    }

    function update_event($db, $input_username, $input_password)
    {
        $error = null;
        $sql = "SELECT id, password FROM users WHERE users.username = ?";

        $stmt = $db->prepare($sql);
        $stmt->bind_param('s', $input_username);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $result_array = $result->fetch_array(MYSQLI_NUM);

            $user_id = $result_array[0];
            $password = $result_array[1];

            if (password_verify($input_password, $password)) {
                return $user_id;
            } else {
                $error .= "Incorrect username or password";
            }
        } else {
            $error .= "Incorrect username or password";
        }

        return $error;
    }

    function delete_event($db, $event_id)
    {
        $sql = "DELETE FROM events WHERE id = ?";
    
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            echo "Prepare failed: (" . $db->errno . ") " . $db->error;
            return false;
        }
    
        $stmt->bind_param('i', $event_id);
    
        if ($stmt->execute()) {
            // Confirm if a row was actually deleted
            if ($stmt->affected_rows > 0) {
                return true; // Successfully deleted
            } else {
                return "No event found with the specified ID.";
            }
        } else {
            echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }
    }

    function get_all_events($db, $user_id)
    {
        $sql = "SELECT * FROM events WHERE user_id = ?";

        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $user_id);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        return [];
    }
}
