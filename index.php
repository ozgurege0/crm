<?php 
require_once("requirements/function.php"); 
require_once("requirements/config.php"); 
require_once("requirements/session.php"); 


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


$tasks = $db->prepare("SELECT * FROM `tasks`");
$tasks->execute();

$tickets = $db->prepare("SELECT * FROM `tickets`");
$tickets->execute();


require_once("includes/header.php"); 
?>

<body>
	<!-- Wrapper -->
	<div class="hk-wrapper" data-layout="vertical" data-layout-style="default" data-menu="light" data-footer="simple">
		<!-- Top Navbar -->
		<?php require_once("includes/navbar.php"); ?>
		<!-- /Top Navbar -->

        <!-- Vertical Nav -->
		<?php require_once("includes/sidebar.php"); ?>

        <div id="hk_menu_backdrop" class="hk-menu-backdrop"></div>
        <!-- /Vertical Nav -->

	
		<!-- Main Content -->
		<div class="hk-pg-wrapper pe-5 ps-5">
				<!-- Page Header -->
				<div class="hk-pg-header pg-header-wth-tab pt-7">
					<div class="d-flex">
						<div class="d-flex flex-wrap justify-content-between flex-1">
							<div class="mb-lg-0 mb-2 me-8">
								<h1 class="pg-title">Hoşgeldin, <?php echo $fetch_profile["name"] ?></h1>
								<p>Unutmayın, herhangi bir sayfayı bulamadığınızda yapay zekamız Dori'den destek alabilirsiniz!</p>
							</div>
							<div class="pg-header-action-wrap">
								
							</div>
							
						</div>
					</div>
				
				</div>
				<!-- /Page Header -->

				<!-- Page Body -->
				<div class="hk-pg-body">

				<div class="row">

				<div class="col-md-12 mt-3">
					<h3 class="text-center">Görevleriniz</h3>
							<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Görev İsmi</th>
      <th scope="col">Görüntüle</th>
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
      <td><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#groups_edit<?php echo $taskget["id"] ?>">Görevi Gör</button></td>
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
            <input type="text" name="title" class="form-control" value="<?php echo $taskget["title"] ?>" readonly>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Görev İçeriği</label>
            <textarea type="text" name="text" class="form-control" style="height: 100px;" readonly><?php echo $taskget["text"] ?></textarea>
          </div>

		  


              <div class="mb-3">
            <label class="form-label">Görev Dosyası (İsteğe Bağlı) Şuanki Dosyaı Görmek İçin <a href="<?php echo $taskget["file"] ?>" target="_blank">Tıklayınız</a></label>
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
        </div>
      </form>

      </div>
    </div>
  </div>
</div>

  <?php } ?>
   
  </tbody>
</table>	
				</div>	

		<!--	<div class="col-md-6 mt-3">
				<h3 class="text-center">Mesajlarınız & Destek Talepleriniz</h3>
							<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Talep Başlığı</th>
      <th scope="col">Görüntüle</th>
    </tr>
  </thead>
  <tbody>

  <?php foreach ($tickets as $ticketget) { 
    ?>
    <tr>
      <th scope="row"><?php echo $ticketget["id"] ?></th>
      <td><?php echo $ticketget["title"] ?></td>
      <td><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#groups_edit<?php echo $taskget["id"] ?>">Destek Talebini Gör</button></td>
    </tr>

          
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
            <input type="text" name="title" class="form-control" value="<?php echo $taskget["title"] ?>" readonly>
          </div>
          
          <div class="mb-3">
            <label class="form-label">Görev İçeriği</label>
            <textarea type="text" name="text" class="form-control" style="height: 100px;" readonly><?php echo $taskget["text"] ?></textarea>
          </div>

		  


              <div class="mb-3">
            <label class="form-label">Görev Dosyası (İsteğe Bağlı) Şuanki Dosyaı Görmek İçin <a href="<?php echo $taskget["file"] ?>" target="_blank">Tıklayınız</a></label>
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
        </div>
      </form>

      </div>
    </div>
  </div>
</div>

  <?php } ?>
   
  </tbody>
</table>	
  			</div> -->



				</div>
				<!-- /Page Body -->		
			</div>
		
			<?php require_once("includes/footer.php"); ?>