<?php 
require_once("../requirements/function.php"); 
require_once("../requirements/config.php"); 
require_once("../requirements/session.php"); 

if(isset($_POST["add"])){
$file = uploadImage('file');

if ($file) {
echo "Dosya başarıyla yüklendi: " . $file;
}

    $tableName = "tasks";
    
    $data = [
        'title' => $_POST['title'],
        'text' => $_POST['text'],
        'user_id' => $_POST['user_id'],
        'group_id' => $_POST['group_id'],
        'file' => $file
    ];
    
    $success = insertIntoTable($tableName, $data, $db);
    
    if ($success) {
      Header("Location:tasks?job=success");
      exit;
    } 
}

if (isset($_POST['edit'])) {
  $file = null;

    if (isset($_FILES['file']) && $_FILES['file']['size'] != 0) {
      $file = uploadImage('file');
  }

  $tableName = "tasks";

  $data = [
        'title' => $_POST['title'],
        'text' => $_POST['text'],
        'user_id' => $_POST['user_id'],
        'group_id' => $_POST['group_id']
  ];
  if ($file) {
      $data['file'] = $file;
  }

   $id = $_POST["id"];
  $condition = ['id' => $id];
  $success = updateTable($tableName, $data, $condition, $db);
  if ($success) {
      Header("Location:tasks?job=success");
      exit;
  } 
}
if (isset($_GET['id'])) {

    $tableName = "tasks";
    $id = $_GET['id'];

    // Koşul (WHERE id = ...)
    $condition = ['id' => $id];

    $success = deleteFromTable($tableName, $condition, $db);

    if ($success) {
        Header("Location:tasks?job=success");
        exit;
    } else {
        Header("Location:tasks?job=fail");
        exit;
    }
}

$tasks = $db->prepare("SELECT * FROM `tasks`");
$tasks->execute();

$users = $db->prepare("SELECT * FROM `users`");
$users->execute();

$groups = $db->prepare("SELECT * FROM `groups`");
$groups->execute();

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
								<h1 class="pg-title">Görev Yönetimi</h1>
								<p>Görev Yönetimini buradan yönetebilirsiniz.</p>
							</div>
							<div class="pg-header-action-wrap">
								<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add_group">Görev Ekle</button>
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
      <th scope="col">Görev İsmi</th>
      <th scope="col">Düzenle</th>
      <th scope="col">Sil</th>
    </tr>
  </thead>
  <tbody>

  <?php foreach ($tasks as $taskget) {  
    $users2 = $db->prepare("SELECT * FROM `users`");
$users2->execute();

$groups2 = $db->prepare("SELECT * FROM `groups`");
$groups2->execute();
    ?>
    <tr>
      <th scope="row">1</th>
      <td><?php echo $taskget["title"] ?></td>
      <td><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#groups_edit<?php echo $taskget["id"] ?>">Düzenle</button></td>
      <td><a href="tasks?id=<?php echo $taskget["id"] ?>"><button class="btn btn-danger" type="button">Sil</button></a></td>
    </tr>

                <!-- Modal -->
<div class="modal fade" id="groups_edit<?php echo $taskget["id"] ?>" tabindex="-1" aria-labelledby="groups_edit<?php echo $taskget["id"] ?>" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Görev Düzenle</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="" method="post" enctype="multipart/form-data">
      
        <div class="modal-body">

          <div class="mb-3">
            <label class="form-label">Görev İsmi</label>
            <input type="text" name="title" class="form-control" value="<?php echo $taskget["title"] ?>" required>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Görev İçeriği</label>
            <textarea type="text" name="text" class="form-control" style="height: 100px;" required><?php echo $taskget["text"] ?></textarea>
          </div>

            <div class="mb-3">
            <label class="form-label">Göreve Sahip Kullanıcı</label>
            <select class="form-select" name="user_id">
              <option value="0" <?php if(0==$taskget["user_id"]){ echo "selected"; } ?>>Kullanıcı Seçebilirsiniz</option>
            <?php foreach ($users2 as $user2get) { ?>
            <option value="<?php echo $user2get["id"] ?>" <?php if($user2get["id"]==$taskget["user_id"]){ echo "selected"; } ?>><?php echo $user2get["name"] ?> <?php echo $user2get["surname"] ?></option>
            <?php } ?>
      
          </select>
          </div>
          
            <div class="mb-3">
            <label class="form-label">Göreve Sahip Kullanıcı</label>
            <select class="form-select" name="group_id">
            <option value="0" <?php if(0==$taskget["group_id"]){ echo "selected"; } ?>>Grup Seçebilirsiniz</option>
            <?php foreach ($groups2 as $groups2get) { ?>
            <option value="<?php echo $groups2get["id"] ?>" <?php if($groups2get["id"]==$taskget["group_id"]){ echo "selected"; } ?>><?php echo $groups2get["title"] ?></option>
            <?php } ?>
      
          </select>
          </div>

              <div class="mb-3">
            <label class="form-label">Görev Dosyası (İsteğe Bağlı) Şuanki Dosyaı Görmek İçin <a href="<?php echo $taskget["file"] ?>" target="_blank">Tıklayınız</a></label>
          <input type="file" class="form-control" name="file">
          </div>


        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="edit">Kaydet</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
        </div>
        <input type="hidden" name="id" value="<?php echo $taskget["id"] ?>">
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
        <h1 class="modal-title fs-5">Görev Ekle</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="" method="post" enctype="multipart/form-data">
      
        <div class="modal-body">
              <div class="mb-3">
            <label class="form-label">Görev İsmi</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Görev İçeriği</label>
            <textarea type="text" name="text" class="form-control" style="height: 100px;"></textarea>
          </div>

            <div class="mb-3">
            <label class="form-label">Göreve Sahip Kullanıcı</label>
            <select class="form-select" name="user_id">
            <option value="0">Kullanıcı Seçebilirsiniz</option>
            <?php foreach ($users as $userget) { ?>
            <option value="<?php echo $userget["id"] ?>"><?php echo $userget["name"] ?> <?php echo $userget["surname"] ?></option>
            <?php } ?>
      
          </select>
          </div>
          
            <div class="mb-3">
            <label class="form-label">Göreve Sahip Kullanıcı</label>
            <select class="form-select" name="group_id">
                <option value="0">Grup Seçebilirsiniz</option>
            <?php foreach ($groups as $groupsget) { ?>
            <option value="<?php echo $groupsget["id"] ?>"><?php echo $groupsget["title"] ?></option>
            <?php } ?>
      
          </select>
          </div>

           <div class="mb-3">
            <label class="form-label">Görev Dosyası (İsteğe Bağlı)</label>
          <input type="file" class="form-control" name="file">
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