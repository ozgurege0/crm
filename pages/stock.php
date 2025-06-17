<?php 
require_once("../requirements/function.php"); 
require_once("../requirements/config.php"); 
require_once("../requirements/session.php"); 

if(isset($_POST["add"])){

    $tableName = "stock";
    
    $data = [
        'title' => $_POST['title'],
        'stock' => $_POST['stock'],
        'adet' => $_POST['adet']
    ];
    
    $success = insertIntoTable($tableName, $data, $db);
    
    if ($success) {
      Header("Location:stock?job=success");
      exit;
    } 
}

if (isset($_POST['edit'])) {

  $tableName = "stock";

  $data = [
   'title' => $_POST['title'],
        'stock' => $_POST['stock'],
        'adet' => $_POST['adet']
  ];


   $id = $_POST["id"];
  $condition = ['id' => $id];
  $success = updateTable($tableName, $data, $condition, $db);
  if ($success) {
      Header("Location:stock?job=success");
      exit;
  } 
}

if (isset($_GET['id'])) {

    $tableName = "stock";
    $id = $_GET['id'];

    // Koşul (WHERE id = ...)
    $condition = ['id' => $id];

    $success = deleteFromTable($tableName, $condition, $db);

    if ($success) {
        Header("Location:stock?job=success");
        exit;
    } else {
        Header("Location:stock?job=fail");
        exit;
    }
}


$stock = $db->prepare("SELECT * FROM `stock`");
$stock->execute();

require_once("../includes/header.php"); 
?>
   <script src="js/jquery.min.js"></script>

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

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
								<h1 class="pg-title">Stok Yönetimi</h1>
								<p>Stok Yönetimini buradan yönetebilirsiniz.</p>
							</div>
							<div class="pg-header-action-wrap">
								<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add_group">Ürün Ve Stok Ekle</button>
							</div>
						</div>
					</div>
				
				</div>
				<!-- /Page Header -->

                
				<!-- Page Body -->
				<div class="hk-pg-body pe-5 ps-5"">

				<table id="example" class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Ürün Adı</th>
      <th scope="col">Düzenle</th>
      <th scope="col">Sil</th>
    </tr>
  </thead>
  <tbody>

  <?php foreach ($stock as $get_stock) {  
    $users = $db->prepare("SELECT * FROM `users`");
    $users->execute();
    ?>
    <tr>
      <th scope="row"><?php echo $get_stock["id"] ?></th>
      <td><?php echo $get_stock["title"] ?></td>
      <td><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#groups_edit<?php echo $get_stock["id"] ?>">Düzenle</button></td>
      <td><a href="<?php echo $url; ?>/stock?id=<?php echo $get_stock["id"] ?>"><button class="btn btn-danger" type="button">Sil</button></a></td>
    </tr>

                <!-- Modal -->
<div class="modal fade" id="groups_edit<?php echo $get_stock["id"] ?>" tabindex="-1" aria-labelledby="groups_edit<?php echo $get_stock["id"] ?>" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Stok Düzenle</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="" method="post">
      
        <div class="modal-body">

         <div class="row">

            <div class="col-md-6 mb-3">
            <label class="form-label">Ürün İsmi</label>
            <input type="text" name="title" class="form-control" value="<?php echo $get_stock["title"] ?>" required>
          </div>

           <div class="col-md-6 mb-3">
            <label class="form-label">Stok Adedi</label>
            <input type="text" name="adet" class="form-control" value="<?php echo $get_stock["adet"] ?>" required>
          </div>


        <div class="mb-3">
            <label class="form-label">Stok Verisi</label>
            <textarea type="text" name="stock" class="form-control" style="height:100px;" required><?php echo $get_stock["stock"] ?></textarea>
          </div>

         </div>


        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="edit">Kaydet</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
        </div>
        <input type="hidden" name="id" value="<?php echo $get_stock["id"] ?>">
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
        <h1 class="modal-title fs-5">Ürün Stoğu Ekle</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="" method="post">
      
        <div class="modal-body">
           <div class="row">

            <div class="col-md-6 mb-3">
            <label class="form-label">Ürün İsmi</label>
            <input type="text" name="title" class="form-control" required>
          </div>

           <div class="col-md-6 mb-3">
            <label class="form-label">Stok Adedi</label>
            <input type="text" name="adet" class="form-control" required>
          </div>


        <div class="mb-3">
            <label class="form-label">Stok Verisi</label>
            <textarea type="text" name="stock" class="form-control" style="height:100px;" required></textarea>
          </div>

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
			    <script>
        $(document).ready(function () {
            $('#example').DataTable({
               
            });
        });
    </script>
			<?php require_once("../includes/footer.php"); ?>