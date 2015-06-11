<?php

namespace Api\Model;

class BaseModel {

    private $connection = null;

    protected function getConn() {
        $this->connection = mysqli_connect('localhost', 'testUser', 'test', 'test');
        if (!$this->connection) {
            error_log("could not connect to server");
            return false;
        } else {
            return $this->connection;
        }
    }

    protected function closeConnection() {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }

    protected function fetchQuery($dbc, $query) {
        $result = mysqli_query($dbc, $query);
        if (!$result) {
            $error = mysqli_error($dbc);
            error_log("Couldnt Execute SQL: " . $error . ' - ' . $query);
            throw new \Exception("Couldnt Execute SQL: " . $error . ' - ' . $query);
        }
        $return = array();
        if (isset($result->num_rows)) {
            while ($row = mysqli_fetch_assoc($result))
                $return[] = $row;
        }

        return $return;
    }

    protected function insertQuery($dbc, $query) {
        $result = mysqli_query($dbc, $query);
        if (!$result) {
            $error = mysqli_error($dbc);
            error_log("Couldnt Execute SQL: " . $error . ' - ' . $query);
            throw new \Exception("Couldnt Execute SQL: " . $error . ' - ' . $query);
        }
        $id = mysqli_insert_id($dbc);

        return $id;
    }

    protected function updateQuery($dbc, $query) {
        $result = mysqli_query($dbc, $query);
        if (!$result) {
            $error = mysqli_error($this->connection);
            $this->error("Couldnt Execute SQL: " . $error, $query);
        }
        return $result;
    }

    protected function deleteQuery($dbc, $query) {
        $result = mysqli_query($dbc, $query);
        if (!$result) {
            $error = mysqli_error($this->connection);
            $this->error("Couldnt Execute SQL: " . $error, $query);
        }
        return $result;
    }

}
