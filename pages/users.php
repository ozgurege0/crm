<?php 
require_once("../requirements/function.php"); 
require_once("../requirements/config.php"); 
require_once("../requirements/session.php"); 

if(isset($_POST["add"])){

    $harf = 'IRT7ODCH5LFSGPM45BKEUV1NZAYJ';
    $harf_sayisi = mb_strlen($harf);
    for ($i = 0; $i < 10; $i++){
      $secilen_harf_konumu = mt_rand(0,$harf_sayisi - 1);
      @$kod .= mb_substr($harf, $secilen_harf_konumu, 1).rand(0,9);
    }
    $token = mb_substr($kod, 0, 64); 

    $tableName = "users";
    
    $data = [
        'name' => $_POST['name'],
        'surname' => $_POST['surname'],
        'email' => $_POST['email'],
        'password' => md5($_POST['password']),
        'group_id' => $_POST['group_id'],
        'token' => $token
    ];
    
    $success = insertIntoTable($tableName, $data, $db);
    
    if ($success) {
      Header("Location:users?job=success");
      exit;
    } 
}

if (isset($_POST['edit'])) {
  $id = $_POST["id"];
  $useredit=$db->prepare("SELECT * FROM users where id=:id");
  $useredit->execute(array(
    'id'=> $id
  ));
  $getuseredit=$useredit->fetch(PDO::FETCH_ASSOC);

  if($_POST['password']!=="null"){
    $pass = md5($_POST["password"]);
  }else{
    $pass = $getuseredit["password"];
  }

  $tableName = "users";

  $data = [
  'name' => $_POST['name'],
  'surname' => $_POST['surname'],
  'email' => $_POST['email'],
  'password' => $pass,
  'group_id' => $_POST['group_id']
  ];


 
  $condition = ['id' => $id];
  $success = updateTable($tableName, $data, $condition, $db);
  if ($success) {
      Header("Location:users?job=success");
      exit;
  } 
}

if (isset($_GET['id'])) {
      $id = $_GET['id'];

    if($id==1){
  Header("Location:users?job=failed");
        exit;
    }

    $tableName = "users";

    // Koşul (WHERE id = ...)
    $condition = ['id' => $id];

    $success = deleteFromTable($tableName, $condition, $db);

    if ($success) {
        Header("Location:users?job=success");
        exit;
    } else {
        Header("Location:users?job=fail");
        exit;
    }
}



if(!isset($_GET["search"])){
$users = $db->prepare("SELECT * FROM `users`");
$users->execute();
}else{
$search = $_GET["search"];
$users = $db->prepare("SELECT * FROM `users` WHERE id=:id");
$users->execute(array('id' => $search));

}

$groups_add = $db->prepare("SELECT * FROM `groups`");
$groups_add->execute();

require_once("../includes/header.php"); 
?>


<body>
	<!-- Wrapper -->
	<div class="hk-wrapper" data-layout="vertical" data-layout-style="default" data-menu="light" data-footer="simple">
		<!-- Top Navbar -->
		<?php require_once("../includes/navbar.php"); ?>
		<!-- /Top Navbar -->

        <!-- Vertical Nav -->
		<?php require_once("../includes/sidebar.php"); ?>

        <div id="hk_menu_backdrop" class="hk-menu-backdrop"></div>
        <!-- /Vertical Nav -->

		<!-- Main Content -->
		<div class="hk-pg-wrapper pe-5 ps-5">
				<!-- Page Header -->
				<div class="hk-pg-header pg-header-wth-tab">
					<div class="d-flex">
						<div class="d-flex flex-wrap justify-content-between flex-1">
							<div class="mb-lg-0 mb-2 mt-8">
              <?php if(@$_GET["job"]=="success"){ ?> 
              <div class="alert alert-success">
                İşlem başarıyla gerçekleşti!
              </div>  
              <?php } ?>

                 <?php if(@$_GET["job"]=="failed"){ ?> 
              <div class="alert alert-danger">
                Bir AS admini silemezsiniz.
              </div>  
              <?php } ?>
								<h1 class="pg-title">Çalışanlar</h1>
								<p>Çalışanları buradan yönetebilirsiniz.</p>
							</div>
							<div class="pg-header-action-wrap">
								<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add_group">Çalışan Ekle</button>
							</div>
						</div>
					</div>
				
				</div>
				<!-- /Page Header -->

                
				<!-- Page Body -->
				<div class="hk-pg-body pe-5 ps-5"">

				<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Adı Soyadı</th>
      <th scope="col">E-Mail Adresi</th>
      <th scope="col">Çalışan Rolü</th>
      <th scope="col">Düzenle</th>
      <th scope="col">Sil</th>
    </tr>
  </thead>
  <tbody>

  <?php foreach ($users as $userget) { 
    $groups = $db->prepare("SELECT * FROM `groups`");
    $groups->execute();

    $group_detail = $db->prepare("SELECT * FROM `groups` WHERE id=:id");
    $group_detail->execute(array("id" => $userget["group_id"]));
    $get_group_detail=$group_detail->fetch(PDO::FETCH_ASSOC);

    ?>
    <tr>
      <th scope="row"><?php echo $userget["id"] ?></th>
      <td><?php echo $userget["name"] ?> <?php echo $userget["surname"] ?></td>
      <td><?php echo $userget["email"] ?></td>
      <td><?php echo $get_group_detail["title"] ?></td>
      <td><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#groups_edit<?php echo $userget["id"] ?>">Düzenle</button></td>
      <td><a href="users?id=<?php echo $userget["id"] ?>"><button class="btn btn-danger" type="button">Sil</button></a></td>
    </tr>

                <!-- Modal -->
<div class="modal fade" id="groups_edit<?php echo $userget["id"] ?>" tabindex="-1" aria-labelledby="groups_edit<?php echo $userget["id"] ?>" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Çalışan Düzenle</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="" method="post">
      
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Çalışan İsmi</label>
            <input type="text" name="name" class="form-control" value="<?php echo $userget["name"] ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Çalışan Soyismi</label>
            <input type="text" name="surname" class="form-control" value="<?php echo $userget["surname"] ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Çalışan E-mail'i</label>
            <input type="text" name="email" class="form-control" value="<?php echo $userget["email"] ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Çalışan Şifresi (Değiştirmek istemiyorsanız dokunmayınız.)</label>
            <input type="text" name="password" class="form-control" value="null" required>
          </div>


          <!-- Görüntüleyebileceği Sayfalar -->
          <div class="mb-3">
            <label for="pages" class="form-label">Çalışan Rolü</label>
            <select name="group_id" class="form-select" required>
                <?php foreach ($groups as $groupget) { ?>
                <option value="<?php echo $groupget["id"] ?>" <?php if($groupget["id"]==$userget["group_id"]){ echo "selected"; } ?>><?php echo $groupget["title"] ?></option>
                <?php } ?>
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="edit">Kaydet</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
        </div>
        <input type="hidden" name="id" value="<?php echo $userget["id"] ?>">
      </form>

      </div>
    </div>
  </div>
</div>

  <?php } ?>
   
  </tbody>
</table>	
			</div>

            <!-- Modal -->
<div class="modal fade" id="add_group" tabindex="-1" aria-labelledby="add_group" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Çalışan Ekle</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="" method="post">
      
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Çalışan İsmi</label>
            <input type="text" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Çalışan Soyismi</label>
            <input type="text" name="surname" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Çalışan E-mail'i</label>
            <input type="text" name="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Çalışan Şifresi</label>
            <input type="text" name="password" class="form-control" required>
          </div>


          <!-- Görüntüleyebileceği Sayfalar -->
          <div class="mb-3">
            <label for="pages" class="form-label">Çalışan Rolü</label>
            <select name="group_id" class="form-select" required>
                <?php foreach ($groups_add as $group_addget) { ?>
                <option value="<?php echo $group_addget["id"] ?>"><?php echo $group_addget["title"] ?></option>
                <?php } ?>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="add">Kaydet</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
        </div>
      </form>

      </div>
    </div>
  </div>
</div>
			
			<?php require_once("../includes/footer.php"); ?>