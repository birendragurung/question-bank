
			<!-- Footer -->
				<div id="footer-wrapper">
					<footer id="footer" class="container">
						<div class="row">
							<div class="12u 12u(medium)">
								<div id="copyright" class="5u 12u(medium)">
									<ul class="menu">
										<li>&copy; TheQuestionBank. All rights reserved</li>
									</ul>
								</div>
								<div class="6u 12u(medium)">
									<ul>
										<li>
											<a style="-moz-transition: background-color .25s ease-in-out; -webkit-transition: background-color .25s ease-in-out; -ms-transition: background-color .25s ease-in-out; transition: background-color .25s ease-in-out; -webkit-appearance: none; position: relative; display: inline-block; background: lightgrey; color: #fff; text-decoration: none; border-radius: 6px; font-weight: 800; outline: 0; border: 0; cursor: pointer; font-size: 1.35em; padding:11px;" href="<?php echo base_url(); ?>public">View as public</a>
										</li>
										<li>
											<form action="logout.php" method="post">
												<input style="background-color:lightgrey;padding:5px 25px;" type="submit" value="Logout" name="submit"><span style="padding:10px;font-weight:bold;"><?php echo strtoupper($_SESSION['user']); ?></span>
											</form>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</footer>
				</div>
			<!-- end of footer section -->
		</div>	
		<!-- end of div from id= page-wrapper -->

		<!-- Scripts -->

			<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
			<script src="<?php echo base_url(); ?>assets/js/jquery.dropotron.min.js"></script>
			<script src="<?php echo base_url(); ?>assets/js/skel.min.js"></script>
			<script src="<?php echo base_url(); ?>assets/js/util.js"></script>
			<!--[if lte IE 8]><script src="<?php echo base_url(); ?>assets/js/ie/respond.min.js"></script><![endif]-->
			<script src="<?php echo base_url(); ?>assets/js/main.js"></script>
	</body>
</html>