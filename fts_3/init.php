<?php


function isPrivileged($connection, $file_id) {
    $fileQuery =  "SELECT  *  FROM `files` WHERE id = $file_id;";
    $getFileResult = mysqli_query($connection,$fileQuery );
    $fileObject = mysqli_fetch_object($getFileResult);
    return $fileObject;
}

function isDispatchable($connection, $file_id) {
    $fileQuery =  "SELECT  *  FROM `movements` WHERE file_id = $file_id ORDER BY created_at desc LIMIT 1;";
    $getFileResult = mysqli_query($connection,$fileQuery );
    $fileObject = mysqli_fetch_object($getFileResult);
    if ($fileObject->to_id == $_SESSION['user']) {
        return true;
    }
    return false;
}

?>