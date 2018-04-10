<?php
    $output='';
    if(isset($_POST['action']) && !empty($_POST['action'])) {
        //echo json_encode(array("blablabla"=>$variable));
        $output =$_POST['action'];
        echo json_encode($output);

    }
    if(isset($_GET['action']) && !empty($_GET['action'])) {
        $output =$_GET['action'];
        echo json_encode($output);
    }
?>
