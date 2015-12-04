			<!-- Banner -->
				<div id="banner-wrapper">
					<div id="banner" class="box container">
						<div class="row">
							<div class="7u 12u(medium)">
								<h2>Welcome! <?php #echo($_SESSION['user']); ?></h2>
								<p>Manage papers here..</p>
							</div>
							<div class="5u 12u(medium)">
								<ul>
									<li><a href="<?php echo base_url() ?>admin/all_papers.php" class="button big icon fa-arrow-circle-right">View all papers</a></li>
									<li><a href="<?php echo base_url() ?>admin/new_paper.php" class="button alt big icon fa-arrow-circle-right">Add new paper</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>

			<!-- end of banner -->