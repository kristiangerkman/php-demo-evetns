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


        if ($stmt->execute()) {
            if (is_int($db->insert_id)) {
                return $db->insert_id;
            } else {
                $error = "insert_id not int";
                return $error;
            }
        } else {
            $error = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }
    }

    function update_event($db, $event_id, $title, $description, $date, $start_time, $end_time)
    {
        $error = null;
    
        $sql = "UPDATE events SET
                    title = ?,
                    description = ?,
                    date = ?,
                    start_time = ?,
                    end_time = ?,
                    updated_at = NOW()
                WHERE id = ?";
    
        if (!($stmt = $db->prepare($sql))) {
            $error = "Prepare failed: (" . $db->errno . ") " . $db->error;
            return $error;
        }
    
        if (!$stmt->bind_param("sssssi", $title, $description, $date, $start_time, $end_time, $event_id)) {
            $error = "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }
    
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                return true;
            } else {
                $error = "No rows updated. Check if the event ID exists.";
                return $error;
            }
        } else {
            $error = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }
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
