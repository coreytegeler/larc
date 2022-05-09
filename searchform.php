<form
	role="search"
	method="get"
	class="search-form"
	action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label
		for="header-search-input"
		class="sr-only">Search</label>
	<input
		name="s"
		type="search"
		id="header-search-input"
		class="search-field"
		value="<?php echo get_search_query(); ?>"
		placeholder="Search" />
	<input
		type="submit"
		class="search-submit"
		value="Search" />
</form>