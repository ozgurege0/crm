<?php 
require_once("requirements/function.php"); 
require_once("requirements/config.php"); 
require_once("requirements/session.php"); 

require_once("includes/header.php"); 
?>

<body>
   	<!-- Wrapper -->
	<div class="hk-wrapper hk-pg-auth" data-layout="vertical" data-layout-style="default" data-menu="light" data-footer="simple">
	

 
        <div id="hk_menu_backdrop" class="hk-menu-backdrop"></div>
        <!-- /Vertical Nav -->

		<!-- Main Content -->
		<div class="hk-pg-wrapper">
			<div class="container-xxl">
				<!-- Page Body -->
				<div class="hk-pg-body">
					<div class="row">
						<div class="col-xl-7 col-lg-6 d-lg-block d-none">
							<div class="auth-content py-md-0 py-8">
								<div class="row">
									<div class="col-xl-12 text-center">
										<img src="https://jampack-classic.vercel.app/dist/img/macaroni-fatal-error.png"  class="img-fluid w-sm-80 w-50" alt="login"/>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-5 col-lg-6 col-md-7 col-sm-10">
							<div class="auth-content py-md-0 py-8">
								<div class="w-100">
									<div class="row">
										<div class="col-xxl-9 col-xl-8 col-lg-11">
											<h1 class="display-4 fw-bold mb-2">404</h1>
											<p class="p-lg">Çok Yakında Sizlerle.</p>
											<a href="<?php echo $url; ?>/" class="btn btn-primary mt-4">Ana Sayfaya Dön</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Page Body -->		
			</div>
			
				
			<?php require_once("includes/footer.php"); ?>