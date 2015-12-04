						<!-- side bar starts here -->
							<div id="sidebar" style= "background-color:antiquewhite; padding: 20px;">
								<!-- Sidebar -->
									<section>
										<h3><?php echo 'Current user : '. $_SESSION['user']; ?></h3>
										<p>Manage your papers from this admin panel.</p>
									</section>

									<section>
										<h3>Actions</h3>
										<ul class="style2">
											<li><a href="update_paper.php"><b style="color:#0090c5;">Update papers</b></a></li>
											<li><a href="delete_paper.php"><b style="color:#0090c5;">Delete papers</b></a></li>
											<li><a href="new_paper.php"><b style="color:#0090c5;">Add new paper</b></a></li>
											<li><a href="new_subject.php"><b style="color:#0090c5;">Add new subject</b></a></li>
											<li><a href="all_papers.php"><b style="color:#0090c5;">View all papers</b></a></li>
											<li><a href="welcome.php"><b style="color:#0090c5;">Go to main page</b></a></li>
										</ul>
									</section>
							</div>
						<!-- end of sidebar -->