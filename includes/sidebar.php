<!-- SideBar -->
<div class="col-md-12 col-lg-4">
		<div class="sidebar">
			<div class="widget links-svg text-center">
				<!-- heading -->
				<div class="widget_header">
					<h5>BEST CAM SITES</h5>
					</div>

					<?php 
                        
                                    $query = "SELECT * FROM cam_logo";
                                    $select_logo= mysqli_query($connection, $query);


                                    while ($row = mysqli_fetch_assoc($select_logo)) {
                                    $cam_id        = $row['cam_id'];
                                    $cam_logo      = $row['cam_logo'];
									$alt_text      = $row['alt_text'];
									$link          = $row['link'];

									echo "<a href='$link' rel='nofollow'><img src='admin/images/$cam_logo' width='200' height='50' alt='$alt_text'>
									</a>";

                                    }


                                    ?>
					</div>

					</div>
					<!-- Store Widget -->
					<div class="widget related-store">
						<!-- Widget Header -->
						<h5 class="widget-header">Live Cam Girls</h5>
						<ul class="store-list list-inline">
						<?php 
                        
						$query = "SELECT * FROM live_cams";
						$select_cam = mysqli_query($connection, $query);


						while ($row = mysqli_fetch_assoc($select_cam)) {
						$link          = $row['link'];
						$link_2        = $row['link_2'];
						$link_3        = $row['link_3'];
						$link_4        = $row['link_4'];


						echo "<li class='list-inline-item'>
						<div id='object_container' style='width:100%;height:100%'></div><script src='$link'></script>
					</li>
					<li class='list-inline-item'>
						<div id='object_container' style='width:100%;height:100%'></div><script src='$link_2'></script>
					</li>
					<li class='list-inline-item'>
						<div id='object_container' style='width:100%;height:100%'></div><script src='$link_3'></script>
					</li>
					<li class='list-inline-item'>
						<div id='object_container' style='width:100%;height:100%'></div><script src='$link_4'></script>
					</li>";

						}


						?>
							<!-- <li class="list-inline-item">
								<div id="object_container" style="width:100%;height:100%"></div><script src="//awmbed.com/embed/fk?c=object_container&site=jasmin&cobrandId=&psid=ttmedia&pstool=319_1&psprogram=revs&campaign_id=&category=girl&vp[showChat]=false&vp[chatAutoHide]=false&vp[showCallToAction]=false&vp[showPerformerName]=true&vp[showPerformerStatus]=true&ms_notrack=1&subAffId={SUBAFFID}"></script>
							</li>
							<li class="list-inline-item">
								<div id="object_container" style="width:100%;height:100%"></div><script src="//awmbed.com/embed/fk?c=object_container&site=jasmin&cobrandId=&psid=ttmedia&pstool=319_1&psprogram=revs&campaign_id=&category=girl&vp[showChat]=false&vp[chatAutoHide]=false&vp[showCallToAction]=false&vp[showPerformerName]=true&vp[showPerformerStatus]=true&ms_notrack=1&subAffId={SUBAFFID}"></script>
							</li>
							<li class="list-inline-item">
								<div id="object_container" style="width:100%;height:100%"></div><script src="//awmbed.com/embed/fk?c=object_container&site=jasmin&cobrandId=&psid=ttmedia&pstool=319_1&psprogram=revs&campaign_id=&category=girl&vp[showChat]=false&vp[chatAutoHide]=false&vp[showCallToAction]=false&vp[showPerformerName]=true&vp[showPerformerStatus]=true&ms_notrack=1&subAffId={SUBAFFID}"></script>
							</li>
							<li class="list-inline-item">
								<div id="object_container" style="width:100%;height:100%"></div><script src="//awmbed.com/embed/fk?c=object_container&site=jasmin&cobrandId=&psid=ttmedia&pstool=319_1&psprogram=revs&campaign_id=&category=girl&vp[showChat]=false&vp[chatAutoHide]=false&vp[showCallToAction]=false&vp[showPerformerName]=true&vp[showPerformerStatus]=true&ms_notrack=1&subAffId={SUBAFFID}"></script>
							</li> -->
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>