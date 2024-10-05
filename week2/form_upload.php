<?php
//ถ้ามีค่าส่งมาจากฟอร์ม
if(isset($_POST['img_name'])  && isset($_POST['action']) && $_POST['action']=='upload'){

// echo '<pre>';
// print_r($_POST);
// echo '<hr>';
// print_r($_FILES);
// exit();

//ไฟล์เชื่อมต่อฐานข้อมูล
require_once 'config/condb.php'; 

//trigger exception in a "try" block
try { 

   
    //ประกาศตัวแปรตังชื่อไฟล์
    $date1 = date("Ymd_His");
    //สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
    $numrand = (mt_rand());
    $img_file_name = (isset($_POST['img_file_name']) ? $_POST['img_file_name'] : '');
    $upload=$_FILES['img_file_name']['name'];

    if($upload !=''){
    //มีการอัพโหลดไฟล์
    //ตัดขื่อเอาเฉพาะนามสกุล
    $typefile = strrchr($_FILES['img_file_name']['name'],".");
 
    //โฟลเดอร์ที่เก็บไฟล์
    $path="upload/";
    //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
    $newname = 'img_'.$numrand.$date1.$typefile;
    $path_copy=$path.$newname;

}else{ $newname=''; }
    
//ประกาศตัวแปรรับค่าจากฟอร์ม
$img_name = $_POST['img_name'];

    //sql insert
    $stmt = $condb->prepare("INSERT INTO tbl_upload
    (img_file_name, img_name, img_path)
    VALUES 
    ('$newname', :img_name, '$path_copy' )
    ");

    //binparam 
    $stmt->bindParam(':img_name', $img_name, PDO::PARAM_STR);
 
    //ถ้า stmt ทำงานถูกต้อง 
     if($stmt->execute()){
//คัดลอกไฟล์ไปยังโฟลเดอร์
    move_uploaded_file($_FILES['img_file_name']['tmp_name'],$path_copy); 
        echo '<script>
             setTimeout(function() {
              swal({
                  title: "เพิ่มข้อมูลสำเร็จ",
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
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Basic CRUD by devbanban.com 2024</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- sweet alert -->
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
     
    
    <!-- js check file type -->
      <script type="text/javascript">
  var _validFileExtensions = [".jpg", ".jpeg", ".png"];     //กำหนดนามสกุลไฟล์ที่สามรถอัพโหลดได้
  function ValidateTypeFile(oForm) {
    var arrInputs = oForm.getElementsByTagName("input");
    for (var i = 0; i < arrInputs.length; i++) {
        var oInput = arrInputs[i];
        if (oInput.type == "file") {
            var sFileName = oInput.value;
            if (sFileName.length > 0) {
                var blnValid = false;
                for (var j = 0; j < _validFileExtensions.length; j++) {
                    var sCurExtension = _validFileExtensions[j];
                    if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                        blnValid = true;
                        break;
                    } // if (sFileName.substr(sFileName.length....
                } // for (var j = 0; j < _validFileExtensions.length; j++) {
 
                //ถ้าเลือกไฟล์ไม่ถุูกต้องจะมี Alert แจ้งเตือน   
                if (!blnValid) {
                    // alert("คำเตือน , " + sFileName + "\n ระบบรองรับเฉพาะไฟล์นามสกุล   : " + _validFileExtensions.join(", "));
                    setTimeout(function() {
                        swal({
                            title: "อัพโหลดไฟล์ไม่ถูกต้อง ",  
                            text: "รองรับ .jpg, .jpeg, .png เท่านั้น !!",
                            type: "error"
                        }, function() {
                            //window.location.reload();
                            //window.location = "product.php?act=add"; //หน้าที่ต้องการให้กระโดดไป
                        });
                      }, 1000);
                    return false;
                } //if (!blnValid) {
            } //if (sFileName.length > 0) {
        } // if (oInput.type == "file") {
    } //for
  
    return true;
} //function ValidateTypeFile(oForm) {
 </script>
  </head>

  <body>
    <!-- start menu -->
    <nav class="navbar navbar-expand-lg" style="background-color: green">
      <div class="container">
        <a class="navbar-brand text-white" href="index.php">CRUD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active text-white" aria-current="page" href="#">หน้าหลัก</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="#">Link</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Menu
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="index.php">CRUD Member</a></li>
                <li><a class="dropdown-item" href="upload.php">CRUD Upload</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- end menu -->
    <!-- start member -->
    <div class="container mt-5">
      <div class="row">
        <div class="col-sm-2"></div>
        <div class="col-sm-7">
          <h3>ฟอร์มอัพโหลดภาพ</h3>

          <form action="" method="post" enctype="multipart/form-data" onsubmit="return ValidateTypeFile(this);">
            

          <div class="row mb-2">
              <label class="col-sm-2 col-form-label">ชื่อภาพ</label>
              <div class="col-sm-7">
                <input type="text" name="img_name" class="form-control" required placeholder="ชื่อภาพ">
              </div>
          </div>
          
          
        
          <div class="row mb-2">
              <label class="col-sm-2 col-form-label">ภาพ</label>
              <div class="col-sm-7">
                <input type="file" name="img_file_name" class="form-control" required  accept="image/*">
              </div>
            </div>
            
            <div class="row mb-2">
              <label class="col-sm-2"></label>
              <div class="col-sm-3">
                <button type="submit" name="action" value="upload" class="btn btn-primary"> เพิ่มข้อมูล </button>
              </div>
            </div>
          </form>

         
        </div>
      </div>
    </div>
    <!-- end member -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>


