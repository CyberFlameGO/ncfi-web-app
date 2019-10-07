<?php



//Page Slug Body Class
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

//allow Featured Images in Posts/Pages
add_theme_support( 'post-thumbnails' );

//Disable Emoji from WP Core
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

//disable empty <p> tags
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop', 99 );
add_filter( 'the_content', 'shortcode_unautop', 100 );



// default Media Dei scripts
function scripts_styles() {

    //Register Scripts/Styles
    wp_register_style( 'global-style', get_template_directory_uri() . '/css/global.css');
    wp_enqueue_style('global-style');
    
    //wp_register_style('font-awesome-style', get_template_directory_uri() . '/css/font-awesome.min.css');
    //wp_enqueue_style('font-awesome-style');

    //Enqueue Scripts/Styles
    wp_enqueue_script('jquery'); // default jQuery

}
add_action( 'wp_enqueue_scripts', 'scripts_styles');

add_action('init', 'cz_register_post_type');

function cz_register_post_type() {
    register_post_type('projects', array(
        'labels' => array(
            'name' => 'Projects',
            'singular_name' => 'Project',
            'add_new' => 'Add new project',
            'edit_item' => 'Edit project',
            'new_item' => 'New project',
            'view_item' => 'View project',
            'search_items' => 'Search projects',
            'not_found' => 'No projects found',
            'not_found_in_trash' => 'No projects found in Trash'
        ),
        'public' => true,
        'supports' => array(
            'title',
            'excerpt',
            'thumbnail'
        ),
        'taxonomies' => array('category', 'post_tag')
    ));
}


//shortcodes
function ncfi_product_docs_shortcode( $atts , $content = null ) {
    return ' <div class="product-docs"><h1>tech specs</h1>'.do_shortcode($content).'</div>';
}
add_shortcode( 'ncfi_product_docs', 'ncfi_product_docs_shortcode' );

function ncfi_calculations_shortcode( $atts , $content = null ) {
    return '
        <div class="product-docs">
        
        </div>'
    ;
}
add_shortcode( 'ncfi_calculations', 'ncfi_calculations_shortcode' );

function mytheme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

add_action('woocommerce_checkout_create_order_line_item', 'change_order_line_item_quantity', 10, 4 );
function change_order_line_item_quantity( $item, $cart_item_key, $cart_item, $order ) {
    // Your code goes below

    // Get order item quantity
    $quantity = $item->get_quantity();

    $new_qty = $quantity + 2;

    // Update order item quantity
    $item->set_quantity( $new_qty );
}

//force disable woocommerce product reviews (even if enabled in wp-admin)
add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
    function wcs_woo_remove_reviews_tab($tabs) {
    unset($tabs['reviews']);
    return $tabs;
}

//woocommerce order calculation product tab
add_filter( 'woocommerce_product_tabs', 'ncfi_product_order_calculation_tab' );
function ncfi_product_order_calculation_tab( $tabs ) {
    // Add the new tab
    $tabs['calculate_tab'] = array(
        'title'       => __( 'Order Calculator', 'text-domain' ),
        'priority'    => 50,
        'callback'    => 'ncfi_product_order_calculation_tab_content'
    );
    return $tabs;
}

function ncfi_product_order_calculation_tab_content() {

    ?>
        <div class="calculator-wrap">
            <form id="calculator">
                <label for="length">Length</label>
                <input type="text" id="length" step="1" min="1" max="" value="0" pattern="[0-9]*" inputmode="numeric">

                <label for="width">Width</label>
                <input type="text" id="width" step="1" min="1" max="" value="0" pattern="[0-9]*" inputmode="numeric">

                <input type="button" onClick="calculateSQFootage()" Value="Calculate Square Footage" />

                <div>Square Footage: <span id="result"></span></div>
                <input type="text" id="sq-footage" step="1" min="1" max="" value="0" pattern="[0-9]*" inputmode="numeric">

                <?php
                    $isInsulated = false;
                    $isRoof = false;
                    $orderQuantity = 1;
    
                    if( has_term( array( 'Insulation Foam'), 'product_cat', get_the_ID() ) ) {
                        $isInsulated = true;
                        echo '<p>Insulated foam: true</p>';
                    } else{
                        echo '<p>Insulated foam: false</p>';
                    }

                    if( has_term( array( 'Roof Foam'), 'product_cat', get_the_ID() ) ) {
                        $isRoof = true;
                        echo '<p>Roof foam: true</p>';
                    } else{
                        echo '<p>Roof foam: false</p>';
                    }
                ?>
                <a href="<?php echo get_site_url(); ?>/?add-to-cart=<?php echo get_the_ID(); ?>&quantity=<?php echo $orderQuantity; ?>">Add to Cart</a>
                
            </form>
        </div>
        <script type="text/javascript">
            function calculateSQFootage(){
                num1 = document.getElementById("length").value;
                num2 = document.getElementById("width").value;
                document.getElementById("result").innerHTML = num1 * num2;
                document.getElementById("sq-footage").value = num1 * num2;
            }
        </script>
    <?php       
}


//rename woocommerce default tabs
add_filter( 'woocommerce_product_tabs', 'ncfi_rename_wc_tabs', 98 );
function ncfi_rename_wc_tabs( $tabs ) {
    $tabs['description']['title']               = __( 'Product Information', 'text-domain' );       // Rename the description tab
    return $tabs;
}

add_filter( 'body_class', 'ncfi_wc_product_css_body_class' );
 
//add body class = wc_product_cat
function ncfi_wc_product_css_body_class( $classes ){
  if( is_singular( 'product' ) )
  {
    $custom_terms = get_the_terms(0, 'product_cat');
    if ($custom_terms) {
      foreach ($custom_terms as $custom_term) {
        $classes[] = 'product_cat_' . $custom_term->slug;
      }
    }
  }
  return $classes;
}

//remove description heading from single-product content
// Remove the product description Title
add_filter( 'woocommerce_product_description_heading', 'remove_product_description_heading' );
function remove_product_description_heading() {
 return '';
}
?>
