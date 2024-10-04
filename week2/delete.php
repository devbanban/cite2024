<?php
//ถ้ามีค่าส่งมาจากฟอร์ม
 if(isset($_GET['id']) && isset($_GET['act']) && $_GET['act']=='delete'){

echo '<pre>';
print_r($_GET);
exit();

//ไฟล์เชื่อมต่อฐานข้อมูล
require_once 'config/condb.php'; 


   echo ' <!-- sweet alert -->
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

//trigger exception in a "try" block
try { 

    //sql delete
    $stmtDelete = $condb->prepare("DELETE FROM  tbl_member WHERE member_id=:id");

    //bindparam STR // INT
    $stmtDelete->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmtDelete->execute();

   //$stmtDelete->rowCount() นับจำนวน row ที่คิวรี่ได้

    //ถ้า stmt ทำงานถูกต้อง 
     if($stmtDelete->rowCount() ==1){
        echo '<script>
             setTimeout(function() {
              swal({
                  title: "ลบข้อมูลสำเร็จ",
                  type: "success"
              }, function() {
                  window.location = "index.php"; //หน้าที่ต้องการให้กระโดดไป
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
                  window.location = "index.php";
              });
            }, 1000);
        </script>';
  }  //catch
} //isset

?>