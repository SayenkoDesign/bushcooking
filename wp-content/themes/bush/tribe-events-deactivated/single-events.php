<?php
/**
 * This file adds the custom portfolio post type single post template to the Hello Theme.
 *
 * @author brandiD
 * @package Hello
 * @subpackage Customizations
 */

//* Force full width content layout
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

add_action( 'genesis_entry_content', 'single_event_fields' );
function single_event_fields() {

  //Post ID and featured image
  $post_id = get_the_ID();
  $feat_image = get_the_post_thumbnail( $post_id, 'full' );

  //Title and dates
  if (get_field('date_range')){
    $title_text = "<h1>" . get_the_title() . "</h1><span class='chimney-break'>|</span><span>" . get_field('date_range') . "</span>";
  } else {
    $title_text = "<h1>" . get_the_title() . "</h1>";
  }

  //Location title and url
  if (get_field('event_location_title') && get_field('event_location_url')){
    $location_title = "<a href='" . get_field('event_location_url') . "'>" . get_field('event_location_title') . "</a>";
  } elseif (get_field('event_location_title')) {
    $location_title = "<span>" . get_field('event_location_title') . "</span>";
  } else {
    $location_title = "<span>Event Details Below.</span>";
  }

  //Address and Google map url
  if (get_field('event_address') && get_field('google_maps_url')){
    $location = "<div class='location-address'><a href='" . get_field('google_maps_url') . "'>" . get_field('event_address') . "</a></div>";
  } elseif (get_field('event_address')) {
    $location = "<div class='location-address'><span>" . get_field('event_address') . "</span></div>";
  }

  //Gallery images
  $images = get_field('gallery_images');
  $size = 'full';

  ?>
  <div class="event-page-wrap">
    <div class="event-header">
      <div class="event-img">
        <?=$feat_image?>
      </div>
      <div class="event-info">
        <div class="title-date"><?=$title_text?></div>
        <div class="location-title"><?=$location_title?></div>
        <?php if($location){ echo $location; } ?>
      </div>
    </div>
    <div class="event-gallery">
      <?php  if( $images ): ?>
        <ul>
          <?php foreach( $images as $image ): ?>
            <li>
              <?php echo wp_get_attachment_image( $image['ID'], $size ); ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>
    <div class="content-columns">
      <div class="content-col-1">
        <?php the_field('column_one') ?>
      </div>
      <div class="content-col-2">
        <?php the_field('column_two') ?>
      </div>
    </div>
  </div>
<?php
}
genesis();
