<?php $sq = get_search_query() ? get_search_query() : 'Search'; ?>
<form method="get" class="footer-form" id="searchform" action="<?php bloginfo('url'); ?>" >
	<fieldset>
		<div class="input-holder">
			<input type="text" name="s" value="<?php echo $sq; ?>" />
			<input type="submit" value="Search" class="btn-search" />
		</div>
	</fieldset>
</form>