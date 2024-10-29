<?php
class UserHandler
{
    function create_user($db, $username, $password)
    {
        $error = null;
        $sql = "INSERT INTO users (username, password, created_at) VALUES (?, ?, NOW())";

        if (!($stmt = $db->prepare($sql))) {
            $error = "Prepare failed: (" . $db->errno . ") " . $db->error;
            return $error;
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        if (!$stmt->bind_param("ss", $username, $password_hash)) {
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

    function login($db, $input_username, $input_password)
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
}
