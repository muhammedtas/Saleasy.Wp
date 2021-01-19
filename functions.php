<?php

function saleasy_setup()
{
    add_theme_support('woocommerce');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');

    register_nav_menu('primary', __('Ana Menü', 'saleasy'));
    register_nav_menu('ustmenu', __('Üst Menü', 'saleasy'));
    register_nav_menu('footermenu1', __('Footer Menü 1', 'saleasy'));
    register_nav_menu('footermenu2', __('Footer Menü 2', 'saleasy'));
    register_nav_menu('footermenu3', __('Footer Menü 3', 'saleasy'));


    add_theme_support('post_thumbnails');
    set_post_thumbnail_size(600, 270, true);
    add_filter('use_default_gallery_style', '__return_false');
}

add_action('after_setup_theme', 'saleasy_setup');

function saleasy_cagirilacak_dosyalar()
{

    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/inc/bootstrap/css/bootstrap.min.css', array());
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/inc/fontawesome/css/all.css', array());
    wp_enqueue_style('slider', get_template_directory_uri() . '/inc/slider/css/swiper.min.css', array());
    wp_enqueue_style('drawer', get_template_directory_uri() . '/inc/drawer-master/dist/css/drawer.css', array());
    wp_enqueue_style('saleasy_style', get_stylesheet_uri(), array());
    wp_enqueue_style('responsive', get_template_directory_uri() . '/css/responsive.css', array());

    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/inc/bootstrap/js/bootstrap.bundle.min.js', array('jquery'), '', true);
    wp_enqueue_script('slider-js', get_template_directory_uri() . '/inc/slider/js/swiper.min.js', array('jquery'), '', true);
    wp_enqueue_script('drawer-js', get_template_directory_uri() . '/inc/drawer-master/src/js/drawer.js', array('jquery'), '', true);
    wp_enqueue_script('iscrool-js', get_template_directory_uri() . '/inc/iscroll/iscroll.min.js', array('jquery'), '', true);
    wp_enqueue_script('saleasy-js', get_template_directory_uri() . '/inc/scripts.js', array('jquery'), '', true);

    add_editor_style(array('css/editor-style.css', 'genericons/genericons.css'));
}

add_action('wp_enqueue_scripts', 'saleasy_cagirilacak_dosyalar');


/*ACF*/
add_filter('acf/settings/path', 'my_acf_settings_path');
function my_acf_settings_path($path)
{
    $path = get_stylesheet_directory() . '/inc/acf/';
    return $path;
}

add_filter('acf/settings/dir', 'my_acf_settings_dir');
function my_acf_settings_dir($dir)
{
    $dir = get_stylesheet_directory_uri() . '/inc/acf/';
    return $dir;
}

//add_filter('acf/settings/show_admin', '__return_false');

include_once(get_stylesheet_directory() . '/inc/acf/acf.php');

add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point($path)
{
    $path = get_stylesheet_directory() . '/inc/acfsettings/';
    return $path;
}

if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title'     => 'Site Ayarları',
        'menu_title'    => 'Site Ayarları',
        'menu_slug'     => 'site-ayarlari',
        'capability'    => 'manage_options',
        'redirect'        => false
    ));

    acf_add_options_page(array(
        'page_title'     => 'Ana Sayfa Ayarları',
        'menu_title'    => 'Ana Sayfa Ayarları',
        'menu_slug'     => 'anasayfa-ayarlari',
        'parent_slug'    => 'site-ayarlari',
        'capability'    => 'manage_options',
        'redirect'        => false
    ));
}

/* Arama Sonuçlarını direkt olark ürüne yönlendirir*/

add_filter('woocommerce_redirect_single_search_result', '__return_false');

/* Sepet Güncellemesi */

function saleasy_sepet($urunler)
{
    ob_start();
?>
    <span class="sepet-guncel">
        <span class="sepet-urun"><span class="sepet-urun-sayi"><?php echo WC()->cart->cart_contents_count; ?></span> Ürün Var</span>
        <span class="sepet-fiyat"><?php echo WC()->cart->get_cart_total(); ?></span>
    </span>
<?php

    $urunler['.sepet-guncel'] = ob_get_clean();

    return $urunler;
}


add_filter('woocommerce_add_to_cart_fragments', 'saleasy_sepet');

/* Admin Bar kaldırma */

function admin_bar_kaldirma()
{
    show_admin_bar(false);
}

add_action('after_setup_theme', 'admin_bar_kaldirma');

/*Editörü eski haline getirir*/

add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_block_editor_for_post_type', '__return_false', 10);

/* Ürün detay dış containerı */

function urun_detay_container_1()
{ ?>
    <div class="container urun-detay-sayfasi">

        <div class="row">

        <?php
    }

    add_action('woocommerce_before_main_content', 'urun_detay_container_1');


    function urun_detay_container_2()
    { ?>
        </div>
    </div>
<?php
    }

    add_action('woocommerce_after_main_content', 'urun_detay_container_2');

    /* Ürün Detayından Sidebar'ı kaldırır  */

    function sidebar_kaldirma()
    {
        remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    }

    add_action('wp', 'sidebar_kaldirma');

    /* Ürün kargo stok detay*/

    function urun_stok_kargo_durumu()
    {

        global $product;

        $kargo = $product->get_shipping_class();
        $stok_miktari = $product->get_stock_quantity();
        $stok_durumu = $product->stock_status;
        // echo "<pre>"; print_r($product); echo "</pre>";
?>

    <?php  ?>

    <?php if ($kargo == "ucretsiz-kargolu-urun") :   ?>
        <span class="kargo-bedava-cerceve">
            <img src="<?php echo get_template_directory_uri(); ?>/img/kargo-bedava.png" width="104" height="29" alt="" />
        </span>
    <?php endif; ?>

    <?php if ($stok_miktari > 0 || $stok_durumu == "instock") : ?>
        <span class="stok-durumu-cerceve">
            <img src="<?php echo get_template_directory_uri(); ?>/img/stokta-var.png" width="104" height="29" alt="" />
        </span>
        <span class="clearfix"></span>
    <?php else : ?>
        <span class="stok-durumu-cerceve">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#stokFormu">Stoğa Gelince Haber Ver</button>
        </span>
        <span class="clearfix"></span>


        <!-- Modal -->
        <div class="modal fade" id="stokFormu" tabindex="-1" role="dialog" aria-labelledby="stokFormu" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="stokFormu">Ürün Haberdar Etme Formu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo do_shortcode('[contact-form-7 id="138" title="Haberdar etme formu"]'); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

<?php

    }

    add_action('woocommerce_single_product_summary', 'urun_stok_kargo_durumu', 10); // bu yandaki rakamlarla hook itemlerinin sırasını belirliyoruz

    /* Ürün detay tab isimlendirme */

    function tab_isimlendirme($tabs)
    {
        $tabs['description']['title'] = __('Genel Bakış');
        return $tabs;
    }

    add_filter('woocommerce_product_tabs', 'tab_isimlendirme', 98);


    /* Ürün Detay Tab Başlığı h2 kaldırma*/

    add_filter('woocommerce_product_description_heading', '__return_null');

    /* Ürün detay ürün özellik tablosu tabı */

    add_filter('woocommerce_product_tabs', 'tab_yeni_ozellik_tablosu');

    function tab_yeni_ozellik_tablosu($tabs)
    {
        if (have_rows('urun_ozellik_tablosu')) :
            $tabs['ozellik_tablosu'] = array(
                'title' => __('Ürün Özellikleri', 'saleasy'),
                'priority' => 50,
                'callback' => 'tab_yeni_ozellik_tablosu_icerik',

            );
            return $tabs;
        endif;
    }

    function tab_yeni_ozellik_tablosu_icerik()
    { ?>

    <table class="table table-sm table-bordered table-hover table-striped">
        <tbody>



            <?php if (have_rows('urun_ozellik_tablosu')) : while (have_rows('urun_ozellik_tablosu')) : the_row(); ?>

                    <tr>
                        <th scope="row"><?php the_sub_field('baslik'); ?></th>
                        <td><?php the_sub_field('icerik'); ?></td>
                    </tr>

            <?php endwhile;
            endif; ?>
        </tbody>
    </table>

<?php
    }

    /* Ürün detay ürün ödeme seçenekleri tabı */


    add_filter('woocommerce_product_tabs', 'tab_odeme_secenekleri');

    function tab_odeme_secenekleri($tabs)
    {
        if (get_field('odeme_secenekleri')) :
            $tabs['odeme_secenekleri'] = array(
                'title' => __('Ödeme Seçenekleri', 'saleasy'),
                'priority' => 50,
                'callback' => 'tab_yeni_odeme_secenekleri_icerik',
            );
        endif;
        return $tabs;
    }

    function tab_yeni_odeme_secenekleri_icerik()
    {
        the_field('odeme_secenekleri');
    }

    /* Ürün detay ürün tab sıralaması */

    function tab_yeniden_siralama($tabs)
    {

        $tabs['description']['priority'] = 5;
        $tabs['ozellik_tablosu']['priority'] = 10;
        $tabs['odeme_secenekleri']['priority'] = 15;
        $tabs['reviews']['priority'] = 20;

        return $tabs;
    }

    add_filter('woocommerce_product_tabs', 'tab_yeniden_siralama', 98);

    /* Ürün Detay Tab İptali */

    add_filter('woocommerce_product_tabs', 'tab_iptali', 98);

    function tab_iptali($tabs)
    {

        //unset($tabs['reviews']);

        return $tabs;
    }

    /* Ürün Detay Özel Not */

    add_action('woocommerce_after_add_to_cart_button', 'urune_ozel_not', 5);

    function urune_ozel_not()
    {

        echo "<div class='clearfix'></div>"; ?>

    <span class="ilave-not-cerceve"> <?php the_field('ilave_not'); ?></span>

<?php
    }
    /* İlgili ürünleri düzenler */

    add_filter('woocommerce_output_related_products_args', 'ilgili_urunleri_duzenle', 20);


    function ilgili_urunleri_duzenle($args)
    {
        $args['posts_per_page'] = 2;
        $args['columns'] = 4;
        return $args;
    }

    add_filter('gettext', 'baslik_degistir');
    add_filter('ngettext', 'baslik_degistir');

    function baslik_degistir($degisecek_kelime)
    {
        $degisecek_kelime = str_replace('Hoşunuza gidebilir', 'Yanında iyi gider...', $degisecek_kelime);
        $degisecek_kelime = str_replace('İlgili ürünler', 'Gözünüzden kaçmasın...', $degisecek_kelime);
        $degisecek_kelime = str_replace('İlginizi çekebilir', 'Unutmayın...', $degisecek_kelime);
        $degisecek_kelime = str_ireplace('Devamını Oku', 'Ürünü İncele', $degisecek_kelime);
        $degisecek_kelime = str_ireplace('Seçenekler', 'Seçenekleri Gör', $degisecek_kelime);

        return $degisecek_kelime;
    }

    /*  Arşiv sayfalarından breadcrumb'ı kaldırır  */

    // add_filter('woocommerce_before_main_content','woocommerce_breadcrumb_kaldir');

    // function woocommerce_breadcrumb_kaldir() {
    //     if (is_product()) { //eğer product detail sayfasıysa 
    //     }
    // }

    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

    add_filter('woocommerce_show_page_title', '__return_false');

    /* Arşi sayfalarına özel yapı ekler */

    remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);

    add_action('woocommerce_before_shop_loop', 'ozel_arsiv_kutusu');

    function ozel_arsiv_kutusu()
    { ?>

    <div class="container kategori-aciklama beyaz-kutu">
        <?php global $wp_query;
        $yuklenen_oge = $wp_query->get_queried_object();

        ?>
        <?php if (is_search()) : ?>
            <b> <?php printf(__('%s'), get_search_query()); ?> </b> kelimesi ile bulunan sonuçlar...
        <?php else : ?>
            <p><?php echo $yuklenen_oge->description;  ?></p>

            <p><b><?php echo $yuklenen_oge->name; ?> </b> kategorisinde <b> <?php echo $yuklenen_oge->count;  ?> </b> adet ürün bulundu.</p>
        <?php endif; ?>
    </div>

<?php
    }

    /*  Arşiv Kolon yapısı düzenlemesi */



    add_action('woocommerce_before_shop_loop', 'ozel_arsiv_kolon_yapisi');


    function ozel_arsiv_kolon_yapisi()
    { ?>

    <div class="col-md-3 kategori-sayfasi-sol">

        <?php if (is_active_sidebar('kategori-sidebari')) : ?>
            <?php dynamic_sidebar('kategori-sidebari');  ?>
        <?php endif;  ?>

    </div>

    <div class="col-md-9">

        <?php $markalar = get_terms(
            array(
                'taxonomy' => 'pa_markalar',
                'hide_empty' => true,
                'number' => 8,
                // 'include' => '31,32,34', //istediğin markanın id sine göre listelemeni sağlar
                // 'orderby' => 'include' // includda eklediğin marka id lerine göre sıralar
            )
        ); ?>

        <div class="kategori-ust-markalar">
            <ul>
                <?php foreach ($markalar as $marka) :  ?>
                    <?php $marka_logo = get_field('marka_logoso', 'pa_markalar' . '_' . $marka->term_id); ?>
                    <!-- <?php echo $marka_logo['url']; ?> -->
                    <li><a href="?filter_markalar=<?php echo $marka->slug; ?>"><img src="<?php echo $marka_logo['url']; ?>"> </a> </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="clearfix"></div>


        <?php global $wp_query;
        $kategori_yuklenen = get_queried_object();
        $yuklenen_kategori_id = $kategori_yuklenen->term_id; ?>
        <?php $kategori_banneri = get_field('kategori_banneri', 'product_cat' . '_' . $yuklenen_kategori_id);
        $kategori_linki = get_field('kategori_banner_linki', 'product_cat' . '_' . $yuklenen_kategori_id);
        ?>

        <div class="kategori-ust-reklam">
            <a href="<?php echo $kategori_linki; ?>"><img src="<?php echo $kategori_banneri['url']; ?>" alt="" /></a>
        </div>
        <div class="clearfix"></div>
        <?php
    }


    add_action('woocommerce_after_main_content', 'arsiv_kapama');

    function arsiv_kapama()
    {
        echo "</div>";
    }

    /* Yeni Side bar */

    function saleasy_sidebar()
    {
        register_sidebar(array(
            'name' => __('Kategori Sidebarı', 'saleasy'),
            'id' => 'kategori-sidebari',
            'description' => 'Kategorinin Sol Tarafında Görünen Sidebar',
            'before_widget' => '<div class="beyaz-kutu">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="tab-baslik renkli-baslik">',
            'after_title' => '</h3><div class="clearfix"></div>'
        ));
    }

    add_action('widgets_init', 'saleasy_sidebar');

    /* Özel ürün sıralaması*/

    add_filter('woocommerce_get_catalog_ordering_args', 'ozel_siralama_argumanlari');

    function ozel_siralama_argumanlari($args)
    {

        $siralama_verisi = isset($_GET['orderby']) ? wc_clean($_GET['orderby']) : apply_filters('woocommerce_default_catalog_orderby', get_option(
            'woocommerce_default_catalog_orderby'
        ));

        if ('stok_durumuna_gore' == $siralama_verisi) {
            $args['orderby'] = 'meta_value';
            $args['order'] = 'ASC';
            $args['meta_key'] = '_stock_status';
        }
        return $args;
    }

    add_filter('woocommerce_default_catalog_orderby_options', 'ozel_siralama_stok');

    add_filter('woocommerce_catalog_orderby', 'ozel_siralama_stok');

    function ozel_siralama_stok($sirala)
    {
        $sirala['stok_durumuna_gore'] = "Stok Durumuna Göre";
        return $sirala;
    }

    /* Sepet sayfasında otomatik fiyat güncellemesi */

    add_action('wp_footer', 'sepet_guncellemesi');

    function sepet_guncellemesi()
    {

        if (is_cart()) {

        ?>
            <script type="text/javascript">
                jQuery('div.woocommerce').on('click', 'input.qty', function() {
                    jQuery("[name='update_cart']").trigger("click");
                })
            </script>
    <?php
        }
    }

    /* Odeme Sayfası ALan kaldırma */

    add_filter('woocommerce_checkout_fields', 'odeme_alanlari_kaldirma');

    function odeme_alanlari_kaldirma($fields)
    {

        unset($fields['billing']['billing_postcode']);
        // unset($fields['billing']['billing_phone']);
        return $fields;
    }

    add_filter('woocommerce_enable_order_notes_field', '__return_false');

    /* Ödeme Sayfası alan ekleme */

    add_action('woocommerce_after_checkout_billing_form', 'tckimlikno');

    function tckimlikno($checkout)
    {

        woocommerce_form_field(
            'tc_kimlik_no',
            array(
                'type' => 'text',
                'class' => array('form-row-wide'),
                'label' => __('TC Kimlik Numaranız'),
                'placeholder' => __('TC Kimlik Numaranız'),
                'required' => "true",
            ),
            $checkout->get_value('tc_kimlik_no')
        );
    }

    add_action('woocommerce_checkout_process', 'ozel_alan_uyari');

    function ozel_alan_uyari()
    {
        if (!$_POST['tc_kimlik_no']) {
            wc_add_notice(__('Lütfen 11 haneli TC Kimlik numaranızı giriniz...'), 'error');
        }
    }

    add_action('woocommerce_checkout_update_order_meta', 'ozel_alan_sipariste_guncelleme');

    function ozel_alan_sipariste_guncelleme($order_id)
    {

        if ($_POST['tc_kimlik_no']) update_post_meta($order_id, '_tc_kimlik_no', sanitize_text_field($_POST['tc_kimlik_no']));
    }

    add_action('woocommerce_admin_order_data_after_billing_address', 'ozel_alan_sipariste_gosterme', 10, 1);

    function ozel_alan_sipariste_gosterme($order)
    {
        echo  '<p><strong> Müşteri Tc Kimlik Numarası </strong>' . get_post_meta($order->id, '_tc_kimlik_no', true) . '</p>';
    }

    /* Sipariş durumu düzenleme */

    add_filter('wc_order_statuses', 'siparis_durum_degistirme');

    function siparis_durum_degistirme($order_statuses)
    {
        foreach ($order_statuses as $key => $status) {
            if ('wc-completed' === $key) {
                $order_statuses['wc-processing'] = _x('Sipariş Hazırlanıyor', 'Order Status', 'woocommerce');
                $order_statuses['wc-on-hold'] = _x('Onay Bekleniyor', 'Order Status', 'woocommerce');
            }
        }
        return $order_statuses;
    }

    /* Yeni sipariş durumu */

    add_filter('woocommerce_register_shop_order_post_statuses', 'yeni_siparis_durumu');

    function yeni_siparis_durumu($order_statuses)
    {

        $order_statuses['wp-kargolandi'] = array(

            'label' => _x('Kargolandı', 'Order Status', 'woocommerce'),
            'public' => false,
            'exclude_from_search' => false,
            'show_in_admin_all_list' => true,
            'show_in_admin_status_list' => true,

        );

        return $order_statuses;
    }

    add_filter('wc_order_statuses', 'yeni_siparis_durumu_ekleme');

    function yeni_siparis_durumu_ekleme($order_statuses)
    {
        $order_statuses['wc-kargolandi'] = _x('Ürün Kargolandı', 'Order Status', 'woocommerce');
        return $order_statuses;
    }

    add_filter('bulk_actions-edit-shop_order', 'yeni_siparis_durum_ekleme_2');

    function yeni_siparis_durum_ekleme_2($bulk_actions)
    {

        $bulk_actions['mark_kargolandi'] = 'Mevcut Siparişi Kargolandı Olarak Değiştir';

        return $bulk_actions;
    }


    /* Admin Panel düzenleme    */


    /*admin ve login stiller*/
    add_action('admin_head', 'admin_style');
    function admin_style()
    {
        include("style-admin.php");
    }

    function login_style()
    {
        include("style-login.php");
    }
    add_action('login_enqueue_scripts', 'login_style');

    add_filter('admin_title', 'panel_basligi', 10, 2);
    function panel_basligi($admin_title, $title)
    {
        return get_bloginfo('name') . ' &bull; ' . $title;
    }

    function login_url()
    {
        return home_url();
    }
    add_filter('login_headerurl', 'login_url');


    function login_url_baslik()
    {
        return get_bloginfo('name') . ' Yönetim Paneli';
    }
    add_filter('login_headertitle', 'login_url_baslik');

    function favicon_ekler()
    {
        $favicon = get_field('favicon', 'option');
        echo '<link rel="shortcut icon" href="' . $favicon['url'] . ' " type="image/x-icon"/>';
    }
    add_action('login_head', 'favicon_ekler');
    add_action('admin_head', 'favicon_ekler');


    /* Kullanıcıdan alan gizleme  */

    add_action('admin_init', 'kullanicidan_alan_gizleme');

    function kullanicidan_alan_gizleme()
    {

        global $user_ID;

        $user_id = get_current_user_id();

        if ($user_id == 2) {
            remove_menu_page('tools.php');
            remove_menu_page('themes.php');
            remove_menu_page('users.php');
            remove_menu_page('plugins.php');

            add_action('admin_head', 'kullancidan_alan_gizleme_2');

            function kullancidan_alan_gizleme_2()
            {
                echo '<style>
            #toplevel_page_wpcf7 {display:none}
            
            </style>';
            }
        }
    }

