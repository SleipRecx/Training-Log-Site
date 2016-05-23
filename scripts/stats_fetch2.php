<?php
session_start();
include_once("login_required.php");
include_once ("db_connection.php");

$sql = /** @lang text */
    "select exercise_name,count(*) as number_of_sets
    from sessions join results on sessionid= sessionid_fk
    join execution on resultid = resultid_fk
    join exercise on exerciseid = exerciseid_fk
    join persons on personid = sessions.personid_fk
    where personid = $_SESSION[personid]
    group by exercise_name
    order by number_of_sets DESC";

$output = array();
$result = $conn->query($sql) or die();
while ($row = $result->fetch_assoc()) {
    $output[] = $row;
}

echo json_encode($output);
$result->close();
$conn->close();

