<?php
require_once 'vendor/autoload.php';

use Bush\App;
use Bush\WordPress\Menu;
use Bush\WordPress\StyleSheet;
use Bush\WordPress\Script;
use Bush\WordPress\PostType;
use Bush\WordPress\Taxonomy;
use Bush\WordPress\ImageSize;

add_theme_support( 'post-thumbnails' );

// stylesheets
$stylesheet_slick = new StyleSheet('slick', '//cdn.jsdelivr.net/g/jquery.slick@1.5.9(slick-theme.css+slick.css)');
$stylesheet_fontawesome = new StyleSheet('fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css');
$stylesheet_fancybox = new StyleSheet('fancybox', StyleSheet::getThemeURL() . '/bower_components/fancybox/dist/jquery.fancybox.css');
$stylesheet_app = new StyleSheet('bush_app_css', StyleSheet::getThemeURL() . '/stylesheets/app.css', ['fontawesome', 'slick', 'fancybox']);
$stylesheet_app = new StyleSheet('bush_edits_css', StyleSheet::getThemeURL() . '/stylesheets/edits.css');

// scripts
add_action('wp_enqueue_scripts', function () {
    wp_deregister_script('jquery');
});
$script_jquery = new Script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js');
$script_slickjs = new Script('slick', '//cdn.jsdelivr.net/jquery.slick/1.5.9/slick.min.js', ['jquery']);
$script_fancybox = new Script('fancybox', Script::getThemeURL() . '/bower_components/fancybox/dist/jquery.fancybox.js');
$script_stickykit = new Script('sticky-kit', Script::getThemeURL() . '/bower_components/sticky-kit/jquery.sticky-kit.min.js');
$script_foundation = new Script('foundation', Script::getThemeURL() . '/bower_components/foundation-sites/dist/foundation.min.js');
$script_app = new Script('bush_app_js', Script::getThemeURL() . '/js/app.js', [
    'foundation',
    'fancybox',
    'sticky-kit',
    'slick',
], time());

// menus
$menu_primary = new Menu('primary', 'Primary menu used in header');
$menu_recipes = new Menu('recipes', 'Recipes menu for header and footer');
$menu_categories = new Menu('categories', 'Categories menu used in footer');

// post type
$recipes = new PostType(
    'recipes',
    'Recipe',
    'Recipe',
    'Food Recipes',
    true,
    true,
    true,
    false,
    ['title', 'author', 'comments', 'thumbnail'],
    true
);
$recipes->setMenuIcon('dashicons-carrot');
$recipes->register();

// add taxonomies
$Difficulty = new Taxonomy('difficulty', 'recipes');
$Food = new Taxonomy('food_category', 'recipes');
$Food->setLabel("Food Category");
$Country = new Taxonomy('country', 'recipes');
$CookMethod = new Taxonomy('cooking_method', 'recipes');
$CookMethod->setLabel("Cooking Method");
$Ingredient = new Taxonomy('ingredient', 'recipes');
$Equipment = new Taxonomy('equipment', 'recipes');
$RecipeType = new Taxonomy('recipe_type', 'recipes');
$RecipeType->setLabel("Recipe Type");
$CookedWith = new Taxonomy('cooked_with', 'recipes');
$CookedWith->setLabel("Cooked With");

// move yoast down
add_filter( 'wpseo_metabox_prio', function() { return 'low';});
// gd is gdrts-metabox but I wont be able to move it without a bit of work so I am leaving it as is.

// add image sizes
$teaser = new ImageSize('teaser', 280, 280, true);
$slider = new ImageSize('slider', 380, 380, true);
$sponsor_sides = new ImageSize('sponsor-sides', 270, 270, true);
$sponsor_middle = new ImageSize('sponsor-middle', 555, 270, true);
$blog_slider = new ImageSize('blog-slider', 740, 370, true);
$blog_slider = new ImageSize('light-box-slider', 700, 700, true);

// acf theme options page
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' => 'Theme Options',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'bush-theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

add_shortcode( 'bush_tabbed_title', function ( $atts, $content = '' ) {
    static $tabbed_title_counter = 0;
    $tabbed_title_counter++;
    if($tabbed_title_counter == 1 ) {
        return <<<HTML
        <li class="tabs-title is-active"><a href="#panel-$tabbed_title_counter" aria-selected="true">$content</a></li>
HTML;
    } else {
        return <<<HTML
        <li class="tabs-title"><a href="#panel-$tabbed_title_counter">$content</a></li>
HTML;
    }
});

add_shortcode( 'bush_tabbed_contents', function ( $atts, $content = '' ){
    $inner_content = do_shortcode($content);
    return <<<HTML
<div class="tabs-content" data-tabs-content="example-tabs">$inner_content</div>
HTML;
});

add_shortcode( 'bush_tabbed_content', function ( $atts, $content = '' ) {
    static $tabbed_content_counter = 0;
    $tabbed_content_counter++;
    if($tabbed_content_counter == 1) {
        return <<<HTML
    <div class="tabs-panel is-active" id="panel-$tabbed_content_counter">
        $content
    </div>
HTML;
    } else {
        return <<<HTML
    <div class="tabs-panel" id="panel-$tabbed_content_counter">
        $content
    </div>
HTML;
    }
});

// control field order and remove uri field
add_filter( 'comment_form_fields', function ( $fields ) {
    $commenter = wp_get_current_commenter();

	$comment_field = '<div class="row column"><textarea placeholder="Your Comment" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></div>';
    $fields['author'] = '<div class="row">'
        . '<div class="medium-6 columns">'
        . '<input placeholder="Name" name="author" type="text" aria-required="true" required="required" value="'.esc_attr( $commenter['comment_author'] ).'"/>'
        . '</div>';
    $fields['email'] = '<div class="medium-6 columns">'
        . '<input name="email" placeholder="Email" type="text" aria-required="true" required="required" value="'.esc_attr( $commenter['comment_author_email'] ).'"/>'
        . '</div>'
        . '</div>';

    unset($fields['url']);
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
});

// Add fields after default fields above the comment box, always visible
add_action( 'comment_form_logged_in_after', 'additional_fields' );
add_action( 'comment_form_after_fields', 'additional_fields' );
function additional_fields () {
?>
    <div class="row column">
        <label for="rating">Your Rating</label>
        <div class="hide">
            <input type="radio" name="rating" id="rating-1" value="1" />
            <input type="radio" name="rating" id="rating-2" value="2" />
            <input type="radio" name="rating" id="rating-3" value="3" />
            <input type="radio" name="rating" id="rating-4" value="4" />
            <input type="radio" name="rating" id="rating-5" value="5" checked="checked" />
        </div>
        <div class="star-container">
            <span class="stars">
                <label for="rating-1" class="star"><i class="fa fa-star"></i></label>
                <label for="rating-2" class="star"><i class="fa fa-star"></i></label>
                <label for="rating-3" class="star"><i class="fa fa-star"></i></label>
                <label for="rating-4" class="star"><i class="fa fa-star"></i></label>
                <label for="rating-5" class="star"><i class="fa fa-star"></i></label>
            </span>
        </div>
    </div>
<?php
}

// Save the comment meta data along with comment
add_action( 'comment_post', 'save_comment_meta_data' );
function save_comment_meta_data( $comment_id ) {
    if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != '') )
        $rating = wp_filter_nohtml_kses($_POST['rating']);
    add_comment_meta( $comment_id, 'rating', $rating );
}

// Add the filter to check whether the comment meta data has been filled
add_filter( 'preprocess_comment', 'verify_comment_meta_data' );
function verify_comment_meta_data( $commentdata ) {
    if ( ! isset( $_POST['rating'] ) )
        wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.' ) );
    return $commentdata;
}

// Add the comment meta (saved earlier) to the comment text
// You can also output the comment meta values directly to the comments template
add_filter( 'comment_text', 'modify_comment');
function modify_comment( $text ){

    $plugin_url_path = WP_PLUGIN_URL;

    if( $commentrating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
        $commentrating = '<p class="comment-rating">  Rating: <strong>'. $commentrating .' / 5</strong></p>';
        $text = $text . $commentrating;
        return $text;
    } else {
        return $text;
    }
}

// Add an edit option to comment editing screen
add_action( 'add_meta_boxes_comment', 'extend_comment_add_meta_box' );
function extend_comment_add_meta_box() {
    add_meta_box( 'title', __( 'Rating' ), 'extend_comment_meta_box', 'comment', 'normal', 'high' );
}

function extend_comment_meta_box ( $comment ) {
    $rating = get_comment_meta( $comment->comment_ID, 'rating', true );
    wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
    ?>
    <p>
        <label for="rating"><?php _e( 'Rating: ' ); ?></label>
      <span class="commentratingbox">
      <?php for( $i=1; $i <= 5; $i++ ) {
          echo '<span class="commentrating"><input type="radio" name="rating" id="rating" value="'. $i .'"';
          if ( $rating == $i ) echo ' checked="checked"';
          echo ' />'. $i .' </span>';
      }
      ?>
      </span>
    </p>
    <?php
}

// Update comment meta data from comment editing screen
add_action( 'edit_comment', 'extend_comment_edit_metafields' );
function extend_comment_edit_metafields( $comment_id ) {
    if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) return;

    if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != '') ):
        $rating = wp_filter_nohtml_kses($_POST['rating']);
        update_comment_meta( $comment_id, 'rating', $rating );
    else :
        delete_comment_meta( $comment_id, 'rating');
    endif;

}

// author fields
add_filter('user_contactmethods', function ($profile_fields) {
    $profile_fields['linkedin'] = 'Linkedin';
    $profile_fields['pinterest'] = 'Pinterest';
    $profile_fields['instagram'] = 'Instagram';
    $profile_fields['twitter'] = 'Twitter';
    $profile_fields['facebook'] = 'Facebook';
    $profile_fields['youtube'] = 'Youtube';

    return $profile_fields;
});

add_action('pre_get_posts', function ($query){
    if ($query->is_author){
        $query->set('post_type', ['recipes']);
    }
});

// remove taxonomy boxes
add_action( 'admin_menu', function (){
    remove_meta_box('food_categorydiv', 'recipes', 'side');
    remove_meta_box('difficultydiv', 'recipes', 'side');
    remove_meta_box('countrydiv', 'recipes', 'side');
    remove_meta_box('cooking_methoddiv', 'recipes', 'side');
    remove_meta_box('ingredientdiv', 'recipes', 'side');
    remove_meta_box('equipmentdiv', 'recipes', 'side');
    remove_meta_box('recipe_typediv', 'recipes', 'side');
});


// login styles
add_action('login_enqueue_scripts', function(){
    echo <<<HTML
    <style type="text/css">
        body.wp-core-ui {
            color: #773D1A;
            background: #F8F3E7;
        }
        body.wp-core-ui .button-primary {
            display: inline-block;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.25s ease-out, color 0.25s ease-out;
            vertical-align: middle;
            border: 1px solid transparent;
            border-radius: 0;
            font-size: 0.9rem;
            background-color: #F15B24;
            color: #fff;
            text-shadow: none;
            box-shadow: none;
        }
        body.wp-core-ui .button-primary.focus,
        body.wp-core-ui .button-primary.hover,
        body.wp-core-ui .button-primary:focus,
        body.wp-core-ui .button-primary:hover {
            background-color: #F15B24;
            border: 1px solid transparent;
        }
        body.wp-core-ui input[type=text]:focus,
        body.wp-core-ui input[type=password]:focus {
            border-color: #F15B24;
            box-shadow: 0 0 2px rgba(241, 91, 36,.8);
        }
        body.wp-core-ui input[type=checkbox]:checked:before{
            color: #F15B24;
        }
        body.wp-core-ui input[type=checkbox]:focus {
            border-color: #F15B24;
        }
        body.login #backtoblog a, body.login #nav a {
            color: #773D1A;
        }
        body.login #backtoblog a:hover,
        body.login #nav a:hover,
        body.login h1 a:hover {
            color: #773D1A;
            text-decoration: underline;
        }
        body.login h1 a {
            background-size: 198px 200px;
            height: 200px;
        }
    </style>
HTML;
});

// return icon if no avatar
add_filter('wpua_get_avatar_filter', function($avatar, $id_or_email, $size, $default, $alt){
    return !preg_match('/(avatar-default)/', $avatar) ? $avatar : '<i class="fa fa-user"></i>';
}, 10, 5);

// redirect after login
add_filter('login_redirect', function ($redirect_to, $request, $user) {
    //is there a user to check?
    if ( isset( $user->roles ) && in_array( 'home_user', $user->roles ) ) {
        $username = str_replace(' ', '%20', $user->user_login);
        return site_url('/user/?user_name='.$username);
    } else {
        return $redirect_to;
    }
}, 10, 3 );

// Add a custom user role
$result = add_role( 'home_user', __(
'Home User' ),
  array(
    'read' => true
  )
);

add_filter('get_avatar', 'tsm_acf_profile_avatar', 10, 5);
function tsm_acf_profile_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = '';

    // Get user by id or email
    if ( is_numeric( $id_or_email ) ) {
        $id   = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );
    } elseif ( is_object( $id_or_email ) ) {
        if ( ! empty( $id_or_email->user_id ) ) {
            $id   = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }
    } else {
        $user = get_user_by( 'email', $id_or_email );
    }
    if ( ! $user ) {
        return $avatar;
    }
    // Get the user id
    $user_id = $user->ID;
    // Get the file id
    $image_id = get_user_meta($user_id, 'avatar_test', true);
    // Bail if we don't have a local avatar
    if ( ! $image_id ) {
        return $avatar;
    }
    // Get the file size
    $image_url  = wp_get_attachment_image_src( $image_id, 'thumbnail' );
    // Get the file url
    $avatar_url = $image_url[0];
    // Get the img markup
    $avatar = '<img alt="' . $alt . '" src="' . $avatar_url . '" class="avatar avatar-' . $size . '" height="' . $size . '" width="' . $size . '"/>';
    // Return our new avatar
    return $avatar;
}

add_action('gform_post_submission_4', 'sd_new_user_avatar', 10, 2);

function sd_new_user_avatar($entry, $form) {
  // Modify these variables as needed to get the image field and email field
  $gf_upload_id = 11;
  $gf_email_id = 3;
  //Get the email
  $new_user_email = $entry[$gf_email_id];
  //Get image URL
  $filename = $entry[$gf_upload_id];
  //Get image ID
  $image_id = attachment_url_to_postid($filename);
  //Find new user by email
  $new_user = get_user_by('email', $new_user_email);
  //Update the field with the image id
  update_user_meta($new_user->ID, 'avatar_test', $image_id );
}

add_action('gform_post_submission_5', 'sd_update_user_avatar', 10, 2);

function sd_update_user_avatar($entry, $form) {
  if (is_user_logged_in()){
    $user = wp_get_current_user();
    $gf_upload_id = 20;
    //Get image URL
    $filename = $entry[$gf_upload_id];
    if ($filename){
      //Get image ID
      $image_id = attachment_url_to_postid($filename);
      //Update the field with the image id
      update_user_meta($user->ID, 'avatar_test', $image_id );
    }
  }
}

// Social Media Shortcode

add_shortcode( 'social_follow', 'social_media_shortcode' );

function social_media_shortcode() {
	ob_start();
  ?>

  <div class="top-bar-right">
  <ul class="menu social-links">
  <li><a href="http://allrecipes.com/cook/7709795/" target="_blank"><i class="fa all-recipes"></i></a></li>
  <li><a href="https://twitter.com/BushCooking" target="_blank"><i class="fa fa-twitter"></i></a></li>
  <li><a href="https://www.instagram.com/_bushcooking_/" target="_blank"><i class="fa fa-instagram"></i></a></li>
  <li><a href="https://www.pinterest.com/Bush_Cooking/" target="_blank"><i class="fa fa-pinterest"></i></a></li>
  <li><a href="https://www.facebook.com/BushCooking" target="_blank"><i class="fa fa-facebook"></i></a></li>
  <li><a href="https://twitter.com/BushCooking" target="_blank"><i class="fa fa-twitter"></i></a></li>
  </ul>
  </div>

  <?php
  $display_posts = ob_get_clean();
  return $display_posts;
}

/*
Events Calendar
Uncomment when plugin is reactivated

//Check for events page
function is_tribe_calendar() { detect if we're on an Events Calendar page
if (tribe_is_event() || tribe_is_event_category() || tribe_is_in_main_loop() || tribe_is_view() || 'tribe_events' == get_post_type() || is_singular( 'tribe_events' ))
return true;
else return false;
}

After single event
remove_action( 'tribe_events_single_event_after_the_content', array( tribe( 'tec.iCal' ), 'single_event_links' ) );
add_action( 'tribe_events_single_event_after_the_content', 'customized_tribe_single_event_links' );
function customized_tribe_single_event_links()	{
if ( is_single() && post_password_required() ) {
return;
}
echo '<div id="share">';
echo '<span class="share-title">Share this event </span>';
echo '<div>';
echo '<span class="st_pinterest_large" displayText="Pinterest"></span>';
echo '<span class="st_facebook_large" displayText="Facebook"></span>';
echo '<span class="st_twitter_large" displayText="Tweet"></span>';
echo '<span class="st_googleplus_large" displayText="Google +"></span>';
echo '</div>';
echo '<script type="text/javascript">var switchTo5x=true;</script>';
echo '<script type="text/javascript" src="https://ws.sharethis.com/button/buttons.js"></script>';
echo '<script type="text/javascript">';
echo 'stLight.options({';
echo 'publisher: "' . the_field("sharethis_api_key", "option") . ',';
echo 'doNotHash: true,';
echo 'doNotCopy: true,';
echo 'hashAddressBar: true';
echo '});';
echo '</script>';
echo '</div>';
echo '<div class="tribe-events-cal-links">';
echo '<a class="tribe-events-gcal tribe-events-button" href="' . tribe_get_gcal_link() . '" title="' . __( 'Add to Google Calendar', 'tribe-events-calendar-pro' ) . '">+ Export the Map </a>';
echo '<a class="tribe-events-ical tribe-events-button" href="' . tribe_get_single_ical_link() . '">+ Export to Calendar </a>';
echo '</div>';
}
*/


// Modify the "must_log_in" string of the comment form.
add_filter( 'comment_form_defaults', function( $fields ) {
    $fields['must_log_in'] = sprintf(
        __( '<p class="must-log-in">
                 You must <a href="%s">Register</a> or
                 <a href="%s">Login</a> to post a comment.</p>'
        ),
        wp_registration_url(),
        wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
    );
    return $fields;
});

// Override the default Gravity Forms confirmation behavior, displaying it in a popup.
add_filter( 'gform_confirmation', 'ag_custom_confirmation', 10, 4 );
function ag_custom_confirmation( $confirmation, $form, $entry, $ajax ) {
  if($form['id'] == 4){
  	add_filter( 'wp_footer', 'ag_overlay');
  	return '<div id="gform-notification">' . $confirmation . '<a class="button" href="/wp-login.php">OK</a></div>';
  }elseif($form['id'] == 5){
    add_filter( 'wp_footer', 'ag_overlay');
    $thisform = $form['id'];
    $user = wp_get_current_user();
    $username = str_replace(' ', '%20', $user->user_login);
  	return '[gravityform id=' . $thisform . ' title=false description=false] <div id="gform-notification" class="profile-update-notification">' . $confirmation . '<a class="button" href="/user?user_name=' .  $username. '">OK</a></div>';
  }
}

// Script to remove the overlay and confirmation message once the button in the popup is clicked.
function ag_overlay() {
	echo '<div id="overlay"></div>';
	echo '
		<script type="text/javascript">
			jQuery("body").addClass("message-sent");
			jQuery("#gform-notification a").click(function() {
				jQuery("#overlay,#gform-notification").fadeOut("normal", function() {
					$(this).remove();
				});
			});
		</script>
	';
}

// Single Post Slider
function post_slider_shortcode() {
  if( get_field('blog_image_gallery') ) :
    ob_start();
    ?>
       <div class="large-12 columns">
         <?php if( get_field('slider_title') ) : ?>
            <h2><?php echo get_field('slider_title') ?></h2>
          <?php endif; ?>
          <div class="slick-blog-slider">
            <?php foreach ( get_field('blog_image_gallery') as $slide ) : ?>
              <div class="img-wrapper">
                  <img src="<?php echo $slide['sizes']['blog-slider']; ?>" alt="<?php echo $slide['alt']; ?>" itemprop="image"/>
                  <div class="img-desc">
                      <h4><?php echo $slide['title']; ?></h4>
                      <p><?php echo $slide['description']; ?></p>
                  </div>
              </div>
            <?php endforeach; ?>
          </div>
      </div>
    <?php
    return ob_get_clean();
  endif;
}

add_shortcode( 'post_slider', 'post_slider_shortcode' );


// Exclude featured recipes from archive
function exclude_posts_from_category( $query ) {
    if ( is_admin() || ! $query->is_main_query() )
        return;

    if ( $query->is_archive() ) {
        $queried_object = get_queried_object();

        if( get_field('featured_recipes_for_category', $queried_object) ) {
            $post_id_args = array (
                'posts_per_page' => -1,
                'fields' => 'ids',
                'post_type' => 'recipes',
                'tax_query' => array(
                    array(
                        'taxonomy' => $queried_object->taxonomy,
                        'field' => 'term_id',
                        'terms' => $queried_object->term_id
                    )
                )
            );
            // Get posts to show first
            $move_to_front = get_field('featured_recipes_for_category', $queried_object);
            // Post IDs from args above
            $all_posts_ids = get_posts($post_id_args);
            // Merge ID arrays
            $post_ids_merged = array_merge( $move_to_front, $all_posts_ids );
            // Remove duplicate IDs
            $reordered_ids = array_unique( $post_ids_merged );
            // Set the array of IDs to get
            $query->set( 'post__in', $reordered_ids );
            // Order posts by new array
            $query->set( 'orderby', 'post__in' );
        }
    }
}
add_action( 'pre_get_posts', 'exclude_posts_from_category', 1 );
