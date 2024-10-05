<?php

//ถ้ามีค่าส่งมาจากฟอร์ม
 if(isset($_POST['id']) && isset($_POST['action']) && $_POST['action']=='delete'){

// echo '<pre>';
// print_r($_POST);
// exit();


//ไฟล์เชื่อมต่อฐานข้อมูล
require_once 'config/condb.php'; 


   echo ' <!-- sweet alert -->
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

//trigger exception in a "try" block
try { 

    //sql delete
    $stmtDelete = $condb->prepare("DELETE FROM  tbl_upload WHERE id=:id");
    //bindparam STR // INT
    $stmtDelete->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
    $stmtDelete->execute();

   //$stmtDelete->rowCount() นับจำนวน row ที่คิวรี่ได้

    //ถ้า stmt ทำงานถูกต้อง 
     if($stmtDelete->rowCount() ==1){
        //ลบไฟล์ภาพ
        unlink('upload/'.$_POST['img_file_name']);

        echo '<script>
             setTimeout(function() {
              swal({
                  title: "ลบข้อมูลสำเร็จ",
                  type: "success"
              }, function() {
                  window.location = "upload.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
    } //if

} //catch exception
catch(Exception $e) {
  //echo 'Message: ' .$e->getMessage();
  //exit;
   echo '<script>
             setTimeout(function() {
              swal({
                  title: "เกิดข้อผิดพลาด",
                  text: "กรุณาติดต่อผู้ดูแลระบบ",
                  type: "error"
              }, function() {
                  window.location = "upload.php";
              });
            }, 1000);
        </script>';
  }  //catch
} //isset

?>