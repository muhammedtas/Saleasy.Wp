<?php $site_logo = get_field('site_logosu', 'option'); ?>
<style type="text/css">
#toplevel_page_cptui_main_menu, #dashboard-widgets-wrap, #welcome-panel, #wp-admin-bar-wp-logo, #footer-thankyou, #footer-upgrade, #wp-admin-bar-ilightbox_general, #wp-admin-bar-comments, #wp-admin-bar-new-content, #tagsdiv-sektor, #asp_metadata, #wp-admin-bar-wpseo-menu #se-top-global-notice, #wp-admin-bar-wpseo-menu, #contextual-help-link-wrap {
    display: none;
}
.wp-menu-separator, .update-nag {
    display: none;
}
body.wp-admin {
    background-attachment: fixed;
    background-image: url(<?php echo $site_logo['url'];?>) !important;
    background-position: right 20px bottom 20px;
    background-repeat: no-repeat;
    background-size: calc(116px) auto;
}
</style>