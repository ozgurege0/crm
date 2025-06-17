<?php 
require_once("../requirements/function.php"); 
require_once("../requirements/config.php"); 
require_once("../requirements/session.php"); 

if(isset($_POST["add"])){

    if($_POST["support"]=="aktif"){
      $support = rastgeleKod();
    }

    if($_POST["support"]=="pasif"){
      $support = "bos";
    }

    $tableName = "customers";
    
    $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'phone' => $_POST['phone'],
        'note' => $_POST['note'],
        'support' => $support,
        'user_id' => $_POST['user_id']
    ];
    
    $success = insertIntoTable($tableName, $data, $db);
    
    if ($success) {
      Header("Location:customers?job=success");
      exit;
    } 
}

if (isset($_POST['edit'])) {
  $id = $_POST["id"];

$customers_control=$db->prepare("SELECT * FROM customers where id=:id");
$customers_control->execute(array(
  'id'=> $id
));
$get_customers_control=$customers_control->fetch(PDO::FETCH_ASSOC);

if($get_customers_control["customer"]=="bos" and $_POST["support"]=="aktif"){
      $support = rastgeleKod();
}else{
        $support = "bos";

}

  $tableName = "customers";

  $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'phone' => $_POST['phone'],
        'note' => $_POST['note'],
        'support' => $support,
        'user_id' => $_POST['user_id']
  ];


 
  $condition = ['id' => $id];
  $success = updateTable($tableName, $data, $condition, $db);
  if ($success) {
      Header("Location:customers?job=success");
      exit;
  } 
}

if (isset($_GET['id'])) {

    $tableName = "customers";
    $id = $_GET['id'];

    // Koşul (WHERE id = ...)
    $condition = ['id' => $id];

    $success = deleteFromTable($tableName, $condition, $db);

    if ($success) {
        Header("Location:customers?job=success");
        exit;
    } else {
        Header("Location:customers?job=fail");
        exit;
    }
}


if(!isset($_GET["search"])){
  $customers = $db->prepare("SELECT * FROM `customers`");
$customers->execute();
}else{
  $search = $_GET["search"];
$customers = $db->prepare("SELECT * FROM customers WHERE id=:id");
$customers->execute(array('id' => $search));
}

   $users2 = $db->prepare("SELECT * FROM `users`");
    $users2->execute();

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
								<h1 class="pg-title">Müşteri Yönetimi</h1>
								<p>Müşteri Yönetimini buradan yönetebilirsiniz.</p>
							</div>
							<div class="pg-header-action-wrap">
								<button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add_group">Müşteri Ekle</button>
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
      <th scope="col">Adı Soyadı</th>
      <th scope="col">E-Mail Adresi</th>
      <th scope="col">Destek Linki</th>
      <th scope="col">Düzenle</th>
      <th scope="col">Sil</th>
    </tr>
  </thead>
  <tbody>

  <?php foreach ($customers as $get_customer) {  
    $users = $db->prepare("SELECT * FROM `users`");
    $users->execute();
    ?>
    <tr>
      <th scope="row"><?php echo $get_customer["id"] ?></th>
      <td><?php echo $get_customer["name"] ?></td>
      <td><?php echo $get_customer["email"] ?></td>
      <td><?php if($get_customer["support"]=="bos"){ echo "Destek Kapalı"; }else{ ?><?php echo $url; ?>/tickets?kod=<?php echo $get_customer["support"] ?><?php } ?></td>
      <td><button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#groups_edit<?php echo $get_customer["id"] ?>">Düzenle</button></td>
      <td><a href="<?php echo $url; ?>/customers?id=<?php echo $get_customer["id"] ?>"><button class="btn btn-danger" type="button">Sil</button></a></td>
    </tr>

                <!-- Modal -->
<div class="modal fade" id="groups_edit<?php echo $get_customer["id"] ?>" tabindex="-1" aria-labelledby="groups_edit<?php echo $get_customer["id"] ?>" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Müşteri Düzenle</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="" method="post">
      
        <div class="modal-body">

         <div class="row">

             <div class="mb-3">
            <label class="form-label">Müşteri İsmi</label>
            <input type="text" name="name" class="form-control" value="<?php echo $get_customer["name"] ?>" required>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">Müşteri E-mail'i</label>
            <input type="text" name="email" class="form-control" value="<?php echo $get_customer["email"] ?>" required>
          </div>

              <div class="col-md-6 mb-3">
            <label class="form-label">Müşteri Şifresi (Müşterinizin destek sistemine erişmesini istiyorsanız bir şifre belirleyebilirsiniz.)</label>
            <input type="text" name="password" class="form-control" value="<?php echo $get_customer["password"] ?>">
          </div>

          <div class="col-md-12 mb-3">
            <label class="form-label">Müşteri Telefon Numarası</label>
            <input type="text" name="phone" class="form-control" value="<?php echo $get_customer["phone"] ?>" required>
          </div>

               <div class="mb-3">
            <label class="form-label">Müşteri Notu</label>
            <textarea type="text" name="note" class="form-control" style="height:100px;" required><?php echo $get_customer["note"] ?></textarea>
          </div>

            <div class="mb-3">
            <label for="pages" class="form-label">Dilerseniz müşterinize bir çalışan atayabilirsiniz.</label>
            <select name="user_id" class="form-select" required>
                <?php foreach ($users as $userget) { ?>
                <option value="<?php echo $userget["id"] ?>" <?php if($userget["id"]==$get_customer["user_id"]){ echo "selected"; } ?>><?php echo $userget["name"] ?> <?php echo $userget["surname"] ?></option>
                <?php } ?>
            </select>
          </div>

           <div class="mb-3">
            <label for="pages" class="form-label">Destek Sistemi Açık Mı?</label>
            <select name="support" class="form-select" required>
                <option value="aktif" <?php if($get_customer["support"]!="bos"){ echo "selected"; } ?>>Aktif</option>
                <option value="pasif" <?php if($get_customer["support"]=="bos"){ echo "selected"; } ?>>Pasif</option>
            </select>
          </div>


         </div>


        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="edit">Kaydet</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
        </div>
        <input type="hidden" name="id" value="<?php echo $get_customer["id"] ?>">
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
        <h1 class="modal-title fs-5">Müşteri Ekle</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      <form action="" method="post">
      
        <div class="modal-body">
          <div class="row">

             <div class="mb-3">
            <label class="form-label">Müşteri İsmi</label>
            <input type="text" name="name" class="form-control" value="" required>
          </div>

          <div class="col-md-6 mb-3">
            <label class="form-label">Müşteri E-mail'i</label>
            <input type="text" name="email" class="form-control" value="" required>
          </div>

              <div class="col-md-6 mb-3">
            <label class="form-label">Müşteri Şifresi (Müşterinizin destek sistemine erişmesini istiyorsanız bir şifre belirleyebilirsiniz.)</label>
            <input type="text" name="password" class="form-control" value="<?php echo $get_customer["password"] ?>">
          </div>

          <div class="col-md-12 mb-3">
            <label class="form-label">Müşteri Telefon Numarası</label>
            <input type="text" name="phone" class="form-control" value="" required>
          </div>

               <div class="mb-3">
            <label class="form-label">Müşteri Notu</label>
            <textarea type="text" name="note" class="form-control" style="height:100px;" required></textarea>
          </div>

            <div class="mb-3">
            <label for="pages" class="form-label">Dilerseniz müşterinize bir çalışan atayabilirsiniz.</label>
            <select name="user_id" class="form-select" required>
                <?php foreach ($users2 as $userget2) { ?>
                <option value="<?php echo $userget2["id"] ?>"><?php echo $userget2["name"] ?> <?php echo $userget2["surname"] ?></option>
                <?php } ?>
            </select>
          </div>

             <div class="mb-3">
            <label for="pages" class="form-label">Destek Sistemi Açık Mı?</label>
            <select name="support" class="form-select" required>
                <option value="aktif">Aktif</option>
                <option value="pasif">Pasif</option>
            </select>
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