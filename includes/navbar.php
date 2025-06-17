<?php
$users_search = $db->prepare("SELECT * FROM users");
$users_search->execute();

$customers_search = $db->prepare("SELECT * FROM customers");
$customers_search->execute();
?>
<nav class="hk-navbar navbar navbar-expand-xl navbar-light fixed-top">
			<div class="container-fluid">
			<!-- Start Nav -->
			<div class="nav-start-wrap">
				<button class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover navbar-toggle d-xl-none"><span class="icon"><span class="feather-icon"><i data-feather="align-left"></i></span></span></button>
					
<!-- Search -->
<form class="dropdown navbar-search" onsubmit="return false;">
    <div class="dropdown-toggle no-caret" data-bs-toggle="dropdown" data-dropdown-animation="" data-bs-auto-close="outside">
        <a href="#" class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover d-xl-none">
            <span class="icon"><span class="feather-icon"><i data-feather="search"></i></span></span>
        </a>
        <div class="input-group d-xl-flex d-none">
            <span class="input-affix-wrapper input-search affix-border">
                <input type="text" class="form-control bg-transparent" id="navbarSearchInput" placeholder="Ara..." aria-label="Search">
                <span class="input-suffix">
                    <span class="btn-input-clear" onclick="clearSearch()"><i class="bi bi-x-circle-fill"></i></span>
                    <span class="spinner-border spinner-border-sm input-loader text-primary d-none" id="searchLoader" role="status">
                        <span class="sr-only">Loading...</span>
                    </span>
                </span>
            </span>
        </div>
    </div>

    <div class="dropdown-menu p-0" id="searchDropdown">
        <div class="dropdown-item d-xl-none bg-transparent">
            <input type="text" class="form-control" id="searchInputMobile" placeholder="Ara...">
        </div>

        <div class="dropdown-body p-2" data-simplebar>
            <h6 class="dropdown-header">Müşteriler</h6>
            <div id="musteriListesi">
                <?php foreach ($customers_search as $c) { ?>
                    <a href="customers?search=<?= $c["id"] ?>" class="dropdown-item musteri-item search-item"><?= htmlspecialchars($c["name"]) ?></a>
                <?php } ?>
            </div>

            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">Çalışanlar</h6>
            <div id="calisanListesi">
                <?php foreach ($users_search as $u) { ?>
                    <a href="users?search=<?= $u["id"] ?>" class="dropdown-item calisan-item search-item"><?= htmlspecialchars($u["name"]) ?></a>
                <?php } ?>
            </div>
        </div>
    </div>
</form>
<!-- /Search -->

<script>
function clearSearch() {
    document.getElementById('navbarSearchInput').value = '';
    document.getElementById('searchInputMobile').value = '';
    filterResults('');
}

function filterResults(value) {
    const filter = value.toLowerCase();
    document.querySelectorAll('.search-item').forEach(function (item) {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(filter) ? 'block' : 'none';
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const desktopInput = document.getElementById('navbarSearchInput');
    const mobileInput = document.getElementById('searchInputMobile');

    // Hem mobil hem desktop için dinleyici ekle
    desktopInput.addEventListener("input", function () {
        mobileInput.value = desktopInput.value;
        filterResults(desktopInput.value);
    });

    mobileInput.addEventListener("input", function () {
        desktopInput.value = mobileInput.value;
        filterResults(mobileInput.value);
    });
});
</script>

			</div>
			<!-- /Start Nav -->
			
			<!-- End Nav -->
			<div class="nav-end-wrap">
				<ul class="navbar-nav flex-row">
				
						<?php if(isset($fetch_profile["id"])){ ?> 
					<li class="nav-item">
						<div class="dropdown ps-2">
							<a class=" dropdown-toggle no-caret" href="#" role="button" data-bs-display="static" data-bs-toggle="dropdown" data-dropdown-animation="" data-bs-auto-close="outside" aria-expanded="false">
								<div class="avatar avatar-rounded avatar-xs">
									<img src="images/avatar12.jpg" alt="user" class="avatar-img">
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-end">
								<div class="p-2">
									<div class="media">
										<div class="media-head me-2">
											<div class="avatar avatar-primary avatar-sm avatar-rounded">
												<span class="initial-wrap">Hk</span>
											</div>
										</div>
										<div class="media-body">
											<div class="dropdown">
												<a href="#" class="d-block dropdown-toggle link-dark fw-medium" data-bs-toggle="dropdown" data-dropdown-animation="" data-bs-auto-close="inside"><?php echo $fetch_profile["name"] ?></a>
												<div class="dropdown-menu dropdown-menu-end">
													<div class="p-2">				
														<div class="media align-items-center mb-3">
															<div class="media-head me-2">
																<div class="avatar avatar-xs avatar-rounded">
																	<img src="images/avatar12.jpg" alt="user" class="avatar-img">
																</div>
															</div>
														</div>
														
													</div>
												</div>
											</div>
											<div class="fs-7"><?php echo $fetch_profile["email"] ?></div>
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</li>
					<?php } ?>
				</ul>
			</div>
			<!-- /End Nav -->
			</div>									
		</nav>