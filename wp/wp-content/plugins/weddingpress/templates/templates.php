<?php

defined( 'ABSPATH' ) || exit;

?>
<script type="text/template" id="tmpl-wdpTemplateLibrary__header-logo">
	<span class="wdpTemplateLibrary__logo-wrap">
		<img src="<?php echo WEDDINGPRESS_ELEMENTOR_URL ?>admin/assets/img/wdp.png" style="height: 30px;">
	</span>
    <span class="wdpTemplateLibrary__logo-title">{{{ title }}}</span>
</script>

<script type="text/template" id="tmpl-wdpTemplateLibrary__header-back">
	<i class="eicon-" aria-hidden="true"></i>
	<span><?php echo __( 'Back to Library', 'weddingpress' ); ?></span>
</script>

<script type="text/template" id="tmpl-wdpTemplateLibrary__header-menu">
	<# _.each( tabs, function( args, tab ) { var activeClass = args.active ? 'elementor-active' : ''; #>
		<div class="elementor-component-tab elementor-template-library-menu-item-wdp {{activeClass}}" data-tab="{{{ tab }}}">{{{ args.title }}}</div>
	<# } ); #>
</script>

<script type="text/template" id="tmpl-wdpTemplateLibrary__header-menu-responsive">
	<div class="elementor-component-tab wdpTemplateLibrary__responsive-menu-item elementor-active" data-tab="desktop">
		<i class="eicon-device-desktop" aria-hidden="true" title="<?php esc_attr_e( 'Desktop view', 'weddingpress' ); ?>"></i>
		<span class="elementor-screen-only"><?php esc_html_e( 'Desktop view', 'weddingpress' ); ?></span>
	</div>
	<div class="elementor-component-tab wdpTemplateLibrary__responsive-menu-item" data-tab="tab">
		<i class="eicon-device-tablet" aria-hidden="true" title="<?php esc_attr_e( 'Tab view', 'weddingpress' ); ?>"></i>
		<span class="elementor-screen-only"><?php esc_html_e( 'Tab view', 'weddingpress' ); ?></span>
	</div>
	<div class="elementor-component-tab wdpTemplateLibrary__responsive-menu-item" data-tab="mobile">
		<i class="eicon-device-mobile" aria-hidden="true" title="<?php esc_attr_e( 'Mobile view', 'weddingpress' ); ?>"></i>
		<span class="elementor-screen-only"><?php esc_html_e( 'Mobile view', 'weddingpress' ); ?></span>
	</div>
</script>

<script type="text/template" id="tmpl-wdpTemplateLibrary__header-actions">
	<div id="wdpTemplateLibrary__header-sync" class="elementor-templates-modal__header__item">
		<i class="eicon-sync" aria-hidden="true" title="<?php esc_attr_e( 'Sync Library', 'weddingpress' ); ?>"></i>
		<span class="elementor-screen-only"><?php esc_html_e( 'Sync Library', 'weddingpress' ); ?></span>
	</div>
</script>

<script type="text/template" id="tmpl-wdpTemplateLibrary__preview">
    <iframe></iframe>
</script>

<script type="text/template" id="tmpl-wdpTemplateLibrary__header-insert">
	<div id="elementor-template-library-header-preview-insert-wrapper" class="elementor-templates-modal__header__item">
		{{{ wdp.library.getModal().getTemplateActionButton( obj ) }}}
	</div>
</script>

<script type="text/template" id="tmpl-wdpTemplateLibrary__insert-button">
	<a class="elementor-template-library-template-action elementor-button wdpTemplateLibrary__insert-button">
		<i class="eicon-file-download" aria-hidden="true"></i>
		<span class="elementor-button-title"><?php esc_html_e( 'Insert', 'weddingpress' ); ?></span>
	</a>
</script>

<script type="text/template" id="tmpl-wdpTemplateLibrary__pro-button"></script>

<script type="text/template" id="tmpl-wdpTemplateLibrary__loading">
	<div class="elementor-loader-wrapper">
		<div class="elementor-loader">
			<div class="elementor-loader-boxes">
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
				<div class="elementor-loader-box"></div>
			</div>
		</div>
		<div class="elementor-loading-title"><?php esc_html_e( 'Loading', 'weddingpress' ); ?></div>
	</div>
</script>

<script type="text/template" id="tmpl-wdpTemplateLibrary__templates">
	<div id="wdpTemplateLibrary__toolbar">
		<div id="wdpTemplateLibrary__toolbar-filter" class="wdpTemplateLibrary__toolbar-filter">
			<# if (wdp.library.getTypeTags()) { var selectedTag = wdp.library.getFilter( 'tags' ); #>

				<ul id="wdpElementorLibrary-filter-tags" class="wdpElementorLibrary-filter-tags">
					<li data-tag="">All</li>
					<# _.each(wdp.library.getTypeTags(), function(slug) {
						var selected = selectedTag === slug ? 'active' : '';
						#>
						<li data-tag="{{ slug }}" class="{{ selected }}">{{{ wdp.library.getTags()[slug] }}}</li>
					<# } ); #>
				</ul>
			<# } #>
		</div>
		<!-- <div id="wdpTemplateLibrary__toolbar-counter"></div> -->
		<div id="wdpTemplateLibrary__toolbar-search">
			<label for="wdpTemplateLibrary__search" class="elementor-screen-only"><?php esc_html_e( 'Search Templates:', 'weddingpress' ); ?></label>
			<input id="wdpTemplateLibrary__search" placeholder="<?php esc_attr_e( 'Search', 'weddingpress' ); ?>">
			<i class="eicon-search"></i>
		</div>
	</div>

	<div class="wdpTemplateLibrary__templates-window">
		<div id="wdpTemplateLibrary__templates-list"></div>
	</div>
</script>

<script type="text/template" id="tmpl-wdpTemplateLibrary__template">
	<div class="wdpTemplateLibrary__template-body" id="wdpTemplate-{{ template_id }}">
		<div class="wdpTemplateLibrary__template-preview">
			<i class="eicon-zoom-in-bold" aria-hidden="true"></i>
		</div>
		<img class="wdpTemplateLibrary__template-thumbnail" src="{{ thumbnail }}">
		<div class="wdpElementorlibrary-template-name">{{{ title }}}</div>
	</div>
	<div class="wdpTemplateLibrary__template-footer">
		{{{ wdp.library.getModal().getTemplateActionButton( obj ) }}}
		<!-- <a href="#" class="elementor-button wdpTemplateLibrary__preview-button">
			<i class="eicon-device-desktop" aria-hidden="true"></i>
			<?php esc_html_e( 'Preview', 'weddingpress' ); ?>
		</a> -->
	</div>
</script>

<script type="text/template" id="tmpl-wdpTemplateLibrary__empty">
	<div class="elementor-template-library-blank-icon">
		<img src="<?php echo ELEMENTOR_ASSETS_URL . 'images/no-search-results.svg'; ?>" class="elementor-template-library-no-results" />
	</div>
	<div class="elementor-template-library-blank-title"></div>
	<div class="elementor-template-library-blank-message"></div>
	<div class="elementor-template-library-blank-footer">
		<?php esc_html_e( 'Want to learn more about the Library?', 'weddingpress' ); ?>
		
	</div>
</script>
