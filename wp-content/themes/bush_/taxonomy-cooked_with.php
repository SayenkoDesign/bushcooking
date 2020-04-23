<?php

//Redirect to slected URL if one is selected
$queried_object = get_queried_object();

if( get_field('redirect', $queried_object) ):

  $url = get_field('redirect', $queried_object);
  header("Location: $url?". $_SERVER['QUERY_STRING'], true, 301);
  echo $url;
  exit;

endif;

get_header();
global $app;

$content = [];
while ( have_posts() ) {
    the_post();
    $comments = get_comments([
        'post_id' => get_the_ID(),
    ]);
    $ratings_total = 0;
    $ratings_count = 0;
    foreach($comments as $comment) {
        $ratings_total += get_comment_meta($comment->comment_ID, 'rating', true);
        $ratings_count++;
    }
    $rating = (!$ratings_total || !$ratings_count) ? 0 : $ratings_total / $ratings_count;

    $prep_hours = ( get_field('prep_time_hours') ) ? get_field('prep_time_hours') : $prep_hours = intval(0);
    $prep_minutes = ( get_field('prep_time_minutes') ) ? get_field('prep_time_minutes') : $prep_hours = intval(0);
    $prep_total_minutes = $prep_hours * 60 + $prep_minutes;
    $cook_hours = ( get_field('cook_time_hours') ) ? get_field('cook_time_hours') : $prep_hours = intval(0);
    $cook_minutes = ( get_field('cook_time_minutes') ) ? get_field('cook_time_minutes') : $prep_hours = intval(0);
    $cook_total_minutes = $cook_hours * 60 + $cook_minutes;
    $total = $prep_total_minutes + $cook_total_minutes;
    $total_hours = floor($total / 60);
    $total_minutes = ($total % 60);
    $total_total = $total_hours * 60 + $total_minutes;

    $content[] = $app->render('partials/recipe-teaser.html.twig', [
        'rating' => $rating,
        'rating_count' => $ratings_count,
        'prep_hours' => $prep_hours,
        'prep_minutes' => $prep_minutes,
        'prep_total_minutes' => $prep_total_minutes,
        'cook_hours' => $cook_hours,
        'cook_minutes' => $cook_minutes,
        'cook_total_minutes' => $cook_total_minutes,
        'total_hours' => $total_hours,
        'total_minutes' => $total_minutes,
        'total_total_minutes' => $total_minutes,
    ]);
}

wp_reset_postdata();
$term = get_queried_object();

$tax_content = array(
  'title' => $term->name,
  'description' => $term->description,
  'bg_color' => get_field('background_color', $term),
  'font_color' => get_field('font_color', $term),
  'header_font_family' => get_field('header_font_family', $term),
  'font_family' => get_field('font_family', $term),
  'font_size' => get_field('font_size', $term),
  'logo' => get_field('logo_image', $term),
  'left' => get_field('left_image', $term),
  'center' => get_field('center_image', $term),
  'right' => get_field('right_image', $term),
);


setup_postdata($post);
echo $app->render('pages/branded-archives.html.twig', [
    'tax_content' => $tax_content,
    'content' => $content,
]);
get_footer();
