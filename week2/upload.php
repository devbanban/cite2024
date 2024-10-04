<?php
//ไฟล์เชื่อมต่อฐานข้อมูล
require_once 'config/condb.php';
//คิวรี่ข้อมูลมาแสดงในตาราง
$stmt = $condb->prepare("SELECT * FROM tbl_upload");
$stmt->execute();
$result = $stmt->fetchAll();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Basic CRUD by devbanban.com 2024</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
    <div class="container">
      <div class="row">
        <div class="col-sm-12"> <br>
          <h3>รายการอัพโหลดภาพ <a href="form_upload.php" class="btn btn-info">+เพิ่มข้อมูล</a> </h3>

          <table class="table table-striped  table-hover table-responsive table-bordered">
            <thead>
              <tr class="table-danger">
                <th width="5%">ลำดับ</th>
                <th width="10%">ภาพ</th>
                <th width="40%">ชื่อภาพ</th>
                <th width="35%">Path</th>
                <th width="5%">แก้ไข</th>
                <th width="5%">ลบ</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($result as $row) { ?>
              <tr>
                <td><?=$row['id'];?></td>
                <td><img src="upload/<?=$row['img_file_name'];?>" width="100px"></td>
                <td>xx</td>
                <td>xx</td>
                <td><a href="edit_upload.php?id=<?=$row['id'];?>&act=edit" class="btn btn-warning btn-sm">แก้ไข</a></td>
                <td>
                  <form action="delete_file.php" method="post">
                    <input type="hidden" name="id" value="<?=$row['id'];?>">
                    <input type="hidden" name="img_file_name" value="<?=$row['img_file_name'];?>">
                    <button type="submit" name="action" value="delete" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูล');"> ลบ </button>
                  </form>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- end member -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>