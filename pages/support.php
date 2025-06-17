<?php 
require_once("../requirements/function.php"); 
require_once("../requirements/config.php"); 
require_once("../requirements/session.php"); 

if (isset($_POST['edit'])) {

  $tableName = "tickets";

  $data = [
   'yanit' => $_POST['yanit'],
  ];


   $id = $_POST["id"];
  $condition = ['id' => $id];
  $success = updateTable($tableName, $data, $condition, $db);
  if ($success) {
      Header("Location:support?job=success");
      exit;
  } 
}

if (isset($_GET['id'])) {

    $tableName = "tickets";
    $id = $_GET['id'];

    // Koşul (WHERE id = ...)
    $condition = ['id' => $id];

    $success = deleteFromTable($tableName, $condition, $db);

    if ($success) {
        Header("Location:support?job=success");
        exit;
    } else {
        Header("Location:support?job=fail");
        exit;
    }
}



$tickets = $db->prepare("SELECT * FROM tickets");
$tickets->execute();

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
								<h1 class="pg-title">Destek Sistemi</h1>
								<p>Bu sayfadan destek taleplerinizi kontrol edebilirsiniz.</p>
							</div>
							<div class="pg-header-action-wrap">
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
      <th scope="col">Talep Başlığı</th>
      <th scope="col">Görüntüle</th>
      <th scope="col">Sil</th>
    </tr>
  </thead>
  <tbody>

  <?php foreach ($tickets as $get_tickets) {  
  
    ?>
    <tr>
      <th scope="row"><?php echo $get_tickets["id"] ?></th>
      <td><?php echo $get_tickets["title"] ?></td>
      <td><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#groups_edit<?php echo $get_tickets["id"] ?>">Görüntüle</button></td>
      <td><a href="<?php echo $url; ?>/tickets?id=<?php echo $get_tickets["id"] ?>"><button class="btn btn-danger" type="button">Sil</button></a></td>
    </tr>

                <!-- Modal -->
<div class="modal fade" id="groups_edit<?php echo $get_tickets["id"] ?>" tabindex="-1" aria-labelledby="groups_edit<?php echo $get_tickets["id"] ?>" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Destek Talebi Takibi</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="" method="post">
      
        <div class="modal-body">

         <div class="row">

            <div class="col-md-12 mb-3">
            <label class="form-label">Başlık</label>
            <input type="text" class="form-control" value="<?php echo $get_tickets["title"] ?>" readonly>
          </div>

        <div class="mb-3">
            <label class="form-label">Mesaj</label>
            <textarea type="text" class="form-control" style="height:100px;" readonly><?php echo $get_tickets["icerik"] ?></textarea>
          </div>

         </div>

          <div class="mb-3">
            <label class="form-label">Cevap</label>
            <textarea type="text" name="yanit" class="form-control" style="height:100px;"><?php echo $get_tickets["yanit"] ?></textarea>
          </div>


        </div>
        <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" name="edit">Kaydet</button>

          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
        </div>
        <input type="hidden" name="id" value="<?php echo $get_tickets["id"] ?>">
      </form>

      </div>
    </div>
  </div>
</div>

  <?php } ?>
   
  </tbody>
</table>	
			</div>


			    <script>
        $(document).ready(function () {
            $('#example').DataTable({
               
            });
        });
    </script>
			<?php require_once("../includes/footer.php"); ?>