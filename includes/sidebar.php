<?php
$groupscontrol=$db->prepare("SELECT * FROM `groups` where id=:id");
$groupscontrol->execute(array(
  'id'=> $fetch_profile["id"]
));
$groupgetcontrol=$groupscontrol->fetch(PDO::FETCH_ASSOC);
?>
<div class="hk-menu">
			<!-- Brand -->
			<div class="menu-header">
				<span>
					<a class="navbar-brand" href="index.html">
						<h4>Dori Bilişim</h4>
</a>
					<button class="btn btn-icon btn-rounded btn-flush-dark flush-soft-hover navbar-toggle">
						<span class="icon">
							<span class="svg-icon fs-5">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-bar-to-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
									<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
									<line x1="10" y1="12" x2="20" y2="12"></line>
									<line x1="10" y1="12" x2="14" y2="16"></line>
									<line x1="10" y1="12" x2="14" y2="8"></line>
									<line x1="4" y1="4" x2="4" y2="20"></line>
								</svg>
							</span>
						</span>
					</button>
				</span>
			</div>
			<!-- /Brand -->

			<!-- Main Menu -->
			<div data-simplebar="" class="nicescroll-bar">
				<div class="menu-content-wrap">
					<div class="menu-group">
						<ul class="navbar-nav flex-column">
							<li class="nav-item active">
								<a class="nav-link" href="<?php echo $url; ?>/">
									<span class="nav-icon-wrap">
										<span class="svg-icon">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-template" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
												<rect x="4" y="4" width="16" height="4" rx="1"></rect>
												<rect x="4" y="12" width="6" height="8" rx="1"></rect>
												<line x1="14" y1="12" x2="20" y2="12"></line>
												<line x1="14" y1="16" x2="20" y2="16"></line>
												<line x1="14" y1="20" x2="20" y2="20"></line>
											</svg>
										</span>
									</span>
									<span class="nav-link-text">Ana Sayfa</span>
								</a>
							</li>
						</ul>	
					</div>
					<div class="menu-gap"></div>
					<div class="menu-group">
						<div class="nav-header">
							<span>Uygulamalar</span>
						</div>

						<ul class="navbar-nav flex-column">
					
							<?php if (auth_kontrol($groupgetcontrol["auth"], "1")) { ?>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo $url; ?>/customers">
									<span class="nav-icon-wrap">
										<span class="svg-icon">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-time" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
												<path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>
												<circle cx="18" cy="18" r="4"></circle>
												<path d="M15 3v4"></path>
												<path d="M7 3v4"></path>
												<path d="M3 11h16"></path>
												<path d="M18 16.496v1.504l1 1"></path>
											</svg>
										</span>
									</span>
									<span class="nav-link-text">Müşteri Yönetimi</span>
								</a>
							</li>	
							<?php } ?>
							
							<?php if (auth_kontrol($groupgetcontrol["auth"], "2")) { ?>
							<li class="nav-item">
								<a class="nav-link" href="<?php echo $url; ?>/stock">
									<span class="nav-icon-wrap">
										<span class="svg-icon">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-time" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
												<path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>
												<circle cx="18" cy="18" r="4"></circle>
												<path d="M15 3v4"></path>
												<path d="M7 3v4"></path>
												<path d="M3 11h16"></path>
												<path d="M18 16.496v1.504l1 1"></path>
											</svg>
										</span>
									</span>
									<span class="nav-link-text">Ürün Ve Stok Yönetimi</span>
								</a>
							</li>	
								<?php } ?>
							
							<?php if (auth_kontrol($groupgetcontrol["auth"], "3")) { ?>
							<li class="nav-item">
								<a class="nav-link" href="support">
									<span class="nav-icon-wrap">
										<span class="svg-icon">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-time" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
												<path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>
												<circle cx="18" cy="18" r="4"></circle>
												<path d="M15 3v4"></path>
												<path d="M7 3v4"></path>
												<path d="M3 11h16"></path>
												<path d="M18 16.496v1.504l1 1"></path>
											</svg>
										</span>
									</span>
									<span class="nav-link-text">Müşteri Destek Sistemi</span>
								</a>
							</li>	
	<?php } ?>
			

							
							<?php if (auth_kontrol($groupgetcontrol["auth"], "5")) { ?>
							<li class="nav-item">
								<a class="nav-link" href="tasks">
									<span class="nav-icon-wrap">
										<span class="svg-icon">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-time" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
												<path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>
												<circle cx="18" cy="18" r="4"></circle>
												<path d="M15 3v4"></path>
												<path d="M7 3v4"></path>
												<path d="M3 11h16"></path>
												<path d="M18 16.496v1.504l1 1"></path>
											</svg>
										</span>
									</span>
									<span class="nav-link-text">Görev Yönetimi</span>
								</a>
							</li>	
	<?php } ?>
								
<?php if (auth_kontrol($groupgetcontrol["auth"], "6")) { ?>
						<!--	<li class="nav-item">
								<a class="nav-link" href="calendar.html">
									<span class="nav-icon-wrap">
										<span class="svg-icon">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-time" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
												<path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>
												<circle cx="18" cy="18" r="4"></circle>
												<path d="M15 3v4"></path>
												<path d="M7 3v4"></path>
												<path d="M3 11h16"></path>
												<path d="M18 16.496v1.504l1 1"></path>
											</svg>
										</span>
									</span>
									<span class="nav-link-text">Çalışan Mesajları</span>
								</a>
							</li>	-->
	<?php } ?>
			

							<li class="nav-item">
								<a class="nav-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#dash_chat">
									<span class="nav-icon-wrap">
										<span class="svg-icon">
											<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message-dots" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
												<path stroke="none" d="M0 0h24v24H0z" fill="none"/>
												<path d="M4 21v-13a3 3 0 0 1 3 -3h10a3 3 0 0 1 3 3v6a3 3 0 0 1 -3 3h-9l-4 4" />
												<line x1="12" y1="11" x2="12" y2="11.01" />
												<line x1="8" y1="11" x2="8" y2="11.01" />
												<line x1="16" y1="11" x2="16" y2="11.01" />
											</svg>
										</span>
									</span>
									<span class="nav-link-text">Genel Ayarlar</span>
								</a>
								<ul id="dash_chat" class="nav flex-column collapse  nav-children">
									<li class="nav-item">
										<ul class="nav flex-column">
											<?php if (auth_kontrol($groupgetcontrol["auth"], "7")) { ?>
											<li class="nav-item">
												<a class="nav-link" href="<?php echo $url; ?>/groups"><span class="nav-link-text">Çalışan Rolleri</span></a>
											</li>
	<?php } ?>
											<?php if (auth_kontrol($groupgetcontrol["auth"], "8")) { ?>
											<li class="nav-item">
												<a class="nav-link" href="<?php echo $url; ?>/users"><span class="nav-link-text">Çalışanlar</span></a>
											</li>
											<?php } ?>
											
										</ul>	
									</li>	
								</ul>	
							</li>	


						</ul>
					</div>
				
			
				</div>
			</div>
			<!-- /Main Menu -->
		</div>