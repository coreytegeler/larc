		</main>

		<footer id="site-footer" class="">
			<div class="container-xl">
				<div class="row">

					<div class="col-12 col-sm-6 col-md-4">
						<div id="footer-site-title">
							<a href="/"
								 tabindex="0">
								LARC
								<?#= get_bloginfo( 'title' ); ?>
							</a>
						</div>
					</div>

					<div class="col-12 col-sm-6 col-md-4">
					
					</div>

					<div class="col-12 col-sm-12 col-md-4">
						<div><?= get_bloginfo( 'title' ); ?></div>
						<div>Copyright © <?= date( 'Y' ); ?>. All rights reserved.</div>
						<!-- <p>Website by <a href="https://jadaakoto.com/" target="_blank">Jada Akoto</a> & <a href="https://coreytegeler.com" target="_blank">Corey Tegeler</a></p> -->
					</div>

				</div>
			</div>
		</footer>

		<?php wp_footer(); ?>
	</body>
</html>