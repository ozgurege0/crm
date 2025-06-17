<?php 
require_once("../requirements/function.php"); 
require_once("../requirements/config.php"); 
require_once("../requirements/session.php"); 

if(isset($_POST["add_group"])){

  $auth = $_POST['auth']; 
  $auth_data = implode(',', $auth); 

    $tableName = "`groups`";
    
    $data = [
        'title' => $_POST['title'],
        'auth' => $auth_data
    ];
    
    $success = insertIntoTable($tableName, $data, $db);
    
    if ($success) {
      Header("Location:groups?job=success");
      exit;
    } 
}

if (isset($_POST['edit_group'])) {

  $auth = $_POST['auth']; 
  $auth_data = implode(',', $auth); 

  $tableName = "`groups`";

  $data = [
    'title' => $_POST['title'],
    'auth' => $auth_data
  ];

  $id = $_POST["id"];

  $condition = ['id' => $id];

  $success = updateTable($tableName, $data, $condition, $db);

  if ($success) {
      Header("Location:groups?job=success");
      exit;
  } 
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];

    if($id==1){
  Header("Location:groups?job=failed");
        exit;
    }
  $tableName = "`groups`";

    // Koşul (WHERE id = ...)
    $condition = ['id' => $id];

    $success = deleteFromTable($tableName, $condition, $db);

    if ($success) {
        Header("Location:groups?job=success");
        exit;
    } else {
        Header("Location:groups?job=fail");
        exit;
    }
}

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

               <?php if(@$_GET["job"]=="failed"){ ?> 
              <div class="alert alert-success">
                Bir AS admini silemezsiniz.
              </div>  
              <?php } ?>
								<h1 class="pg-title">Çalışan Rolleri</h1>
								<p>Çalışan rollerini buradan yönetebilirsiniz, rol atama işlemlerini <a href="<?php echo $url; ?>/users">çalışanlar</a> sayfasından düzenleyebilirsiniz.</p>
							</div>
							<div class="pg-header-action-wrap">
								<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add_group">Rol Ekle</button>
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
      <th scope="col">Rol Adı</th>
      <th scope="col">Düzenle</th>
      <th scope="col">Sil</th>
    </tr>
  </thead>
  <tbody>

  <?php foreach ($groups as $groupget) { 
    $selected_auth = explode(',', $groupget["auth"]); // ['1', '2', '3']
    ?>
    <tr>
      <th scope="row"><?php echo $groupget["id"] ?></th>
      <td><?php echo $groupget["title"] ?></td>
      <td><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#groups_edit<?php echo $groupget["id"] ?>">Düzenle</button></td>
      <td><a href="groups?id=<?php echo $groupget["id"] ?>"><button class="btn btn-danger" type="button">Sil</button></a></td>
    </tr>

                <!-- Modal -->
<div class="modal fade" id="groups_edit<?php echo $groupget["id"] ?>" tabindex="-1" aria-labelledby="groups_edit<?php echo $groupget["id"] ?>" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Çalışan Rolü Düzenle</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="" method="post">
      
        <div class="modal-body">
          <!-- Rol Adı Input -->
          <div class="mb-3">
            <label for="role_name" class="form-label">Rol Adı</label>
            <input type="text" name="title" id="role_name" class="form-control" value="<?php echo $groupget["title"] ?>" required>
          </div>

          <!-- Görüntüleyebileceği Sayfalar -->
          <div class="mb-3">
            <label for="pages" class="form-label">Görüntüleyebileceği Sayfalar</label>
            <select name="auth[]" id="pages<?php echo $groupget["id"] ?>" class="form-select select2" multiple="multiple" required>
              <?php
              $options = [
                  "1" => "Müşteri Yönetimi",
                  "2" => "Ürün Ve Stok Yönetimi",
                  "3" => "Müşteri Destek Sistemi",
                  "4" => "Fatura Ve Tahsilatlar",
                  "5" => "Görev Yönetimi",
                  "7" => "Çalışan Rolleri",
                  "8" => "Çalışanlar",
                  "9" => "Ayarlar"
              ];

              $selected_auth = explode(',', $groupget["auth"]);

              foreach ($options as $value => $label) {
                  $selected = in_array($value, $selected_auth) ? 'selected' : '';
                  echo "<option value=\"$value\" $selected>$label</option>";
              }
              ?>
          </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="edit_group">Kaydet</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
        </div>
        <input type="hidden" name="id" value="<?php echo $groupget["id"] ?>">
      </form>

      </div>
    </div>
  </div>
</div>

<script>
  // Modal açıldığında Select2'yi initialize et
  document.addEventListener('DOMContentLoaded', function () {
    $('#groups_edit<?php echo $groupget["id"] ?>').on('shown.bs.modal', function () {
      $('#pages<?php echo $groupget["id"] ?>').select2({
        width: '100%', // Select2 genişlik ayarı
        dropdownParent: $('#groups_edit<?php echo $groupget["id"] ?>') // Modal içinde düzgün çalışması için
      });
    });
  });
</script>

  <?php } ?>
   
  </tbody>
</table>	
			</div>

            <!-- Modal -->
<div class="modal fade" id="add_group" tabindex="-1" aria-labelledby="add_group" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Çalışan Rolü Ekle</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="" method="post">
      
        <div class="modal-body">
          <!-- Rol Adı Input -->
          <div class="mb-3">
            <label for="role_name" class="form-label">Rol Adı</label>
            <input type="text" name="title" id="role_name" class="form-control" required>
          </div>

          <!-- Görüntüleyebileceği Sayfalar -->
          <div class="mb-3">
            <label for="pages" class="form-label">Görüntüleyebileceği Sayfalar</label>
        <select name="auth[]" id="pages" class="form-select select2" multiple="multiple" required>
  <?php
  $options = [
      "1" => "Müşteri Yönetimi",
      "2" => "Ürün Ve Stok Yönetimi",
      "3" => "Müşteri Destek Sistemi",
      "4" => "Fatura Ve Tahsilatlar",
      "5" => "Görev Yönetimi",
      "7" => "Çalışan Rolleri",
      "8" => "Çalışanlar",
      "9" => "Ayarlar"
  ];

  foreach ($options as $value => $label) {
      echo "<option value=\"$value\">$label</option>";
  }
  ?>
</select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="add_group">Kaydet</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
        </div>
      </form>

      </div>
    </div>
  </div>
</div>
			
<script>
  // Modal açıldığında Select2'yi initialize et
  document.addEventListener('DOMContentLoaded', function () {
    $('#add_group').on('shown.bs.modal', function () {
      $('#pages').select2({
        width: '100%', // Select2 genişlik ayarı
        dropdownParent: $('#add_group') // Modal içinde düzgün çalışması için
      });
    });
  });
</script>
			<?php require_once("../includes/footer.php"); ?>