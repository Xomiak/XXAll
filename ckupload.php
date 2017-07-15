<?php
    $callback = $_GET['CKEditorFuncNum'];
    $file_name = $_FILES['upload']['name'];
    @mkdir($_SERVER['DOCUMENT_ROOT'].'/upload/ckedit/'.date("Y-m-d")."/");
    $full_path = dirname(__FILE__) . '/upload/ckedit/'.date("Y-m-d")."/" . $file_name;
    $http_path = '/upload/ckedit/'.date("Y-m-d")."/".$file_name;
    $error = '';
    if( move_uploaded_file($_FILES['upload']['tmp_name'], $full_path) ) {
    } else {
     $error = 'Some error occured please try again later';
     $http_path = '';
    }
    echo "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(".$callback.",  \"".$http_path."\", \"".$error."\" );</script>";
?>