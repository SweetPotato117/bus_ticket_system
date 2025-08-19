<?php
include 'dbconn.php';


function insertRecord($table, $data)
{
    global $conn;
    $columns = implode(", ", array_keys($data));
    $values  = implode("', '", array_values($data));
    $query = "INSERT INTO $table ($columns) VALUES ('$values')";
    return mysqli_query($conn, $query);
}

function editRecord($table, $data, $condition)
{
    global $conn;
    $updateData = [];
    foreach ($data as $column => $value) {
        $updateData[] = "$column = '$value'";
    }
    $updateString = implode(", ", $updateData);
    $query = "UPDATE $table SET $updateString WHERE $condition";
    return mysqli_query($conn, $query);
}

function deleteRecord($table, $condition)
{
    global $conn;
    $query = "DELETE FROM $table WHERE $condition";
    return mysqli_query($conn, $query);
}

function getAllRecords($table, $condition = '')
{
    global $conn;
    $query = "SELECT * FROM $table $condition";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getRecord($table, $condition)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE $condition";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function getRecordMultiTable($table1, $table2, $onCondition, $whereCondition)
{
    global $conn;
    $query = "SELECT * FROM $table1 LEFT JOIN $table2 ON $onCondition WHERE $whereCondition";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}


function countAllRecords($table, $whereCondition = '1')
{
    global $conn;
    $query = "SELECT COUNT(*) as total FROM $table WHERE $whereCondition";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function updateRecord($table, $data, $condition)
{
    global $conn;

    $updates = [];
    foreach ($data as $key => $value) {
        if ($value === null || $value === 'NULL') {
            $updates[] = "$key = NULL";  // No quotes around NULL
        } else {
            $updates[] = "$key = '" . mysqli_real_escape_string($conn, $value) . "'";
        }
    }

    $sql = "UPDATE $table SET " . implode(', ', $updates) . " WHERE $condition";
    return mysqli_query($conn, $sql);
}


// User helpers
function getUserByEmail($email)
{
    global $conn;
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ? LIMIT 1");
    if (!$stmt) return null;
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $user;
}

function createUser($name, $email, $password)
{
    global $conn;
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $created_at = date('Y-m-d H:i:s');
    $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, ?)");
    if (!$stmt) return false;
    mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $hashed, $created_at);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}
