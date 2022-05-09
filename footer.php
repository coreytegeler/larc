		</main>

		<div id="end">

			<div id="symbol"></div>

			<a href="#main" id="back-to-top" class="d-table mx-auto my-5">
				<div class="sr-only">Back to top</div>
				<div class="bg-svg bg-arrow-top-black"></div>
			</a>

		</div>

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
						<p>Copyright © <?= date( 'Y' ); ?> <?= get_bloginfo( 'title' ); ?>. All rights reserved.</p>
						<p>Website by <a href="https://jadaakoto.com/" target="_blank">Jada Akoto</a> & <a href="https://coreytegeler.com" target="_blank">Corey Tegeler</a></p>
					</div>

				</div>
			</div>
		</footer>

		<?php wp_footer(); ?>
	</body>
</html>