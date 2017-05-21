<?php


class Users
{
    public static function find($name = null)
    {
        $sql = "SELECT * FROM users";

        if ( !empty($name) ) {
            $pieces = preg_split('/(?=[A-Z])/',$name);
            if ( count($pieces) === 3 ) {
                $first_name = $pieces[1];
                $last_name = $pieces[2];
                $sql .= " WHERE first_name = '{$first_name}' AND last_name = '{$last_name}'";
            } elseif ( count($pieces) === 2 ) {
                $half_name = $pieces[1];
                $sql .= " WHERE first_name = '{$half_name}' OR last_name = '{$half_name}'";
            } else {
                header( 'Bad Request', true, 400 );
                exit();
            }
        }

        $result = Database::query($sql);

        while ($row = $result->fetch_assoc()) {
            $values[] = $row;
        }

        if (empty($values)) {
            header('No Content', true, 204);
            exit();
        }

        echo json_encode($values);
    }

    public static function update($id)
    {
        $id = intval($id);
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);

        $values = "";

        foreach ($data as $key => $value){
            $values .= " $key = '$value', ";
        }

        $values = rtrim($values, ', ');

        $sql = "UPDATE users SET $values WHERE id = {$id}";

        if ( !Database::query($sql) ) {
            header('Precondition Failed', true, 412);
            exit();
        }

        $sql = "SELECT * FROM users WHERE id = {$id}";
        $result = Database::query($sql);

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode($data[0]);
    }

    public static function delete($id)
    {
        $id = intval($id);
        $sql = "DELETE FROM users WHERE id = {$id}";
        Database::query($sql);

        if ( Database::affected_rows() ) {//if the row was deleted
            echo json_encode(['status' => 'OK']);
        } else {
            header( 'Not found', true, 404 );
            exit();
        }
    }

    public static function add()
    {
        $data = $_POST;
        $keys = implode(', ', array_keys($data));
        $values = implode("', '", $data);

        $sql = "INSERT INTO users ({$keys}) VALUES ('$values')";

        if ( !Database::query($sql) ) {
            header('Precondition Failed', true, 412);
            exit();
        }

        $id = Database::insert_id();//select last updated id
        $sql = "SELECT * FROM users WHERE id = {$id}";
        $result = Database::query($sql);

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        echo json_encode($data[0]);
    }
}

