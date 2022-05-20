<?php /* Template Name: Posts */
get_header();
?>
<section id="resources">

	<form id="filters">

		<?php

		$taxonomies = array( 'format', 'practice', 'location' );
		foreach( $taxonomies as $taxonomy ) {
			$taxonomy_obj = get_taxonomy( $taxonomy );
			$terms = get_terms( $taxonomy, array(
			    'hide_empty' => false,
			) ); ?>

			<fieldset id="<?= $taxonomy; ?>">
				<legend>
					<h3>
						<?= $taxonomy_obj->label; ?>
					</h3>
				</legend>

				<div class="options">
					<?php foreach( $terms as $term ) { ?>

						<div>
							<input
								id="checkbox-<?= $term->slug; ?>"
								type="checkbox"
								name="<?= $taxonomy_obj->name; ?>"
								value="<?= $term->slug; ?>" />
							<label for="checkbox-<?= $term->slug; ?>">
								<?= $term->name; ?>
							</label>
						</div>

					<?php } ?>
				</div>

			</fieldset>

		<?php } ?>

	</form>

	<div class="posts">

		<?php get_template_part( 'parts/feed' ); ?>

	</div>
</section>

<div id="end">
	<a href="#main" id="back-to-top" class="d-table mx-auto my-5">
		<div class="sr-only">Back to top</div>
		<div class="bg-svg bg-arrow-top-black"></div>
	</a>
</div>

<?php get_footer(); ?>