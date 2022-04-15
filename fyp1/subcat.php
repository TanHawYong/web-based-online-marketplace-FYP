<?php
include "Server_Access.php"; 

$catid = 0;

if(isset($_POST['Category'])){
   $catid = mysqli_real_escape_string($conn,$_POST['Category']); 
}

$users_arr = array();

if($catid > 0){
    $sql = "SELECT * FROM service_sub_category WHERE Category = '$catid' or Category = '4';";

    $result = mysqli_query($conn,$sql);
    
    while( $row = mysqli_fetch_array($result) ){
        $subcatid = $row['id'];
        $cat = $row['SubCategory'];
    
        $subcat_arr[] = array("id" => $subcatid, "SubCategory" => $cat);
    }
}

// encoding array to json format
echo json_encode($subcat_arr);