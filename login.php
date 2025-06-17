<?php
require_once("requirements/config.php");
@session_start();
@ob_start();

$user_id = @$_SESSION['user_id'];

if(isset($user_id)){
    header("location:$url/");
	exit;
}

    if(isset($_COOKIE['remember'])){

       $users=$db->prepare("SELECT * FROM users where token=:token");
       $users->execute(array(
       'token'=>$_COOKIE['remember']
       ));
       $remembercek=$users->fetch(PDO::FETCH_ASSOC);
       
          $id = @$remembercek['id'];
       
          $select = $db->prepare("SELECT * FROM `users` WHERE id = ?");
          $select->execute([$id]);
          $row = $select->fetch(PDO::FETCH_ASSOC);
       
          if($select->rowCount() > 0){
       
               $_SESSION['user_id'] = $row['id'];
               header("location:$url/");
                exit;
            }else{
                setcookie("remember", @$token, time()-60*60*24*365);
             }  
          }
        


if(isset($_POST['submit'])){

   $mail = $_POST['email'];
   $pass = md5($_POST['password']);

   $select = $db->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select->execute([$mail, $pass]);
   $row = $select->fetch(PDO::FETCH_ASSOC);

   if($select->rowCount() > 0){

    $harf = 'IRT7ODCH5LFSGPM45BKEUV1NZAYJ';
$harf_sayisi = mb_strlen($harf);
for ($i = 0; $i < 10; $i++){
  $secilen_harf_konumu = mt_rand(0,$harf_sayisi - 1);
  @$kod .= mb_substr($harf, $secilen_harf_konumu, 1).rand(0,9);
}

   $token = mb_substr($kod, 0, 64); 
   $browser = $_SERVER['HTTP_USER_AGENT'];


	$rememberid = $row['id'];
	$duzenle=$db->prepare("UPDATE users SET
		token=:token
	WHERE id=$rememberid");
	$update=$duzenle->execute(array(
		'token' => $token
	));

    setcookie("remember", $token, time()+60*60*24*365);


        $_SESSION['user_id'] = $row['id'];
		header("location:$url/");
        exit;

	}else{
      $error = "The email address or password is incorrect.";
	}
}
?>

<?php require_once("includes/header.php"); ?>

<?php if(isset($error)) { ?>
<script>	
document.addEventListener('DOMContentLoaded', function() {
Swal.fire({
		html:
		`<div class="avatar avatar-icon avatar-soft-danger mb-3"><span class="initial-wrap"><i class="ri-close-circle-fill"></i></span></div>
		<div>
			<h4 class="text-danger">Başarısız!</h4>
			<p class=" mt-2">E-mail veya şifreniz yanlış.</p>
		</div>`,
		customClass: {
			confirmButton: 'btn btn-primary',
		},
		buttonsStyling: false
		
	});
});
</script>
	<?php } ?>

<body>
   	<!-- Wrapper -->
	<div class="hk-wrapper hk-pg-auth" data-footer="simple">
		<!-- Main Content -->
		<div class="hk-pg-wrapper pt-0 pb-xl-0 pb-5">
			<div class="hk-pg-body pt-0 pb-xl-0">
				<!-- Container -->
				<div class="container-xxl">
					<!-- Row -->
					<div class="row">
						<div class="col-sm-10 position-relative mx-auto">
							<div class="auth-content py-8">
								<form class="w-100" action="" method="post">
									<div class="row">
										<div class="col-lg-5 col-md-7 col-sm-10 mx-auto">
											<div class="text-center mb-7">
												<a class="navbar-brand me-0" href="index.html">
													<img class="brand-img d-inline-block" src="images/doribilisim.png" >
												</a>
											</div>
											<div class="card card-lg card-border">
												<div class="card-body">
													<h4 class="mb-4 text-center">Hesabınıza Giriş Yapın</h4>
													<div class="row gx-3">
														<div class="form-group col-lg-12">
															<div class="form-label-group">
																<label>E-mail Adresi</label>
															</div>
															<input class="form-control" placeholder="E-mail adresiniz" type="text" name="email" required>
														</div>
														<div class="form-group col-lg-12">
															<div class="form-label-group">
																<label>Şifre</label>
																<a href="remember" class="fs-7 fw-medium">Şifrenizi mi unuttunuz?</a>
															</div>
															<div class="input-group password-check">
																<span class="input-affix-wrapper">
																	<input class="form-control" placeholder="Enter your password" name="password" type="password" required>
																	<a href="#" class="input-suffix text-muted">
																		<span class="feather-icon"><i class="form-icon" data-feather="eye"></i></span>
																		<span class="feather-icon d-none"><i class="form-icon" data-feather="eye-off"></i></span>
																	</a>
																</span>
															</div>
														</div>
													</div>
													
													<button name="submit" type="submit" class="btn btn-primary btn-block"><b>Giriş Yap</b></button>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					<!-- /Row -->
				</div>
				<!-- /Container -->
			</div>
			<!-- /Page Body -->

            <?php require_once("includes/footer.php"); ?>