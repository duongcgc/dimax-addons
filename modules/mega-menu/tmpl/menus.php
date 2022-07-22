<# if ( data.depth == 0 ) { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Mega Menu Content', 'dimax' ) ?>"
   data-panel="mega"><?php esc_html_e( 'Mega Menu', 'dimax' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Mega Menu Background', 'dimax' ) ?>"
   data-panel="background"><?php esc_html_e( 'Background', 'dimax' ) ?></a>
<div class="separator"></div>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Badges', 'dimax' ) ?>"
   data-panel="badges"><?php esc_html_e( 'Badges', 'dimax' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'dimax' ) ?>"
   data-panel="icon"><?php esc_html_e( 'Icon', 'dimax' ) ?></a>
<# } else if ( data.depth == 1 ) { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Content', 'dimax' ) ?>"
   data-panel="content"><?php esc_html_e( 'Menu Content', 'dimax' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu General', 'dimax' ) ?>"
   data-panel="general"><?php esc_html_e( 'General', 'dimax' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Badges', 'dimax' ) ?>"
   data-panel="badges"><?php esc_html_e( 'Badges', 'dimax' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'dimax' ) ?>"
   data-panel="icon"><?php esc_html_e( 'Icon', 'dimax' ) ?></a>
<# } else { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu General', 'dimax' ) ?>"
   data-panel="general_2"><?php esc_html_e( 'General', 'dimax' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Badges', 'dimax' ) ?>"
   data-panel="badges"><?php esc_html_e( 'Badges', 'dimax' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'dimax' ) ?>"
   data-panel="icon"><?php esc_html_e( 'Icon', 'dimax' ) ?></a>
<# } #>
