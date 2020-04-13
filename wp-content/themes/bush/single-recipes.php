<?php
get_header();
global $app;

$author_id = get_the_author_meta('ID');
$acf_user = 'user_'.$author;
$author = [
	'id' => $author_id,
	'website' => get_the_author_meta('url'),
	'google' => get_the_author_meta('google'),
	'twitter' => get_the_author_meta('twitter'),
	'facebook' => get_the_author_meta('facebook'),
	'linkedin' => get_the_author_meta('linkedin'),
	'pinterest' => get_the_author_meta('pinterest'),
	'instagram' => get_the_author_meta('instagram'),
	'overview' => get_field('overview', $acf_user),
	'bio' => get_field('bio', $acf_user),
	'bio_teaser' => get_field('bio_teaser', $acf_user),
	'name' => get_the_author_meta('first_name') . ' ' . get_the_author_meta('last_name'),
	'first_name' => get_the_author_meta('first_name'),
	'last_name' => get_the_author_meta('last_name'),
];

$nutrition = [
	'cals' => get_field('calories'),
	'fat' => get_field('fat'),
	'carbs' => get_field('carbohydrate'),
	'protein' => get_field('protein'),
	'cholesterol' => get_field('cholesterol'),
	'sodium' => get_field('sodium'),
];

$recipe_pdf;
if(get_field('recipe_pdf')) {
	$recipe_pdf = get_field('recipe_pdf');
	// print_r($recipe_pdf);
}

$slides = [];
if(get_field('slider')) {
	foreach( get_field('slider') as $slide ) {
		$slides[] = $slide;
	}
}

$video_lightbox;
global $wp;
if(get_field('video_type')) {
	if(get_field('video_type') === 'Vimeo') {
		if(get_field('video_id')) {
			$video_lightbox = do_shortcode( '[video_lightbox_vimeo5 video_id="' . get_field("video_id") . '" width="640" height="480" anchor="Play Video"]');
		}
	}

	if(get_field('video_type') === 'YouTube') {
		if(get_field('video_id')) {
			$video_lightbox = do_shortcode( '[video_lightbox_youtube video_id="' . get_field("video_id") . '" width="640" height="480" anchor="Play Video"]');
		}
	}
}

$ingredients = [];
if( have_rows('ingredients') ) {
	while (have_rows('ingredients')) {
		the_row();
		switch($type = get_sub_field('row_type')) {
			case 'ingredient': $value = get_sub_field('ingredient'); break;
			case 'heading': $value = get_sub_field('heading'); break;
			default: $value = ''; break;
		}
		$ingredients[] = [
			'type' => $type,
			'value' => $value,
		];
	}
}

$equipments = [];
if( have_rows('equipment_list') ) {
	while (have_rows('equipment_list')) {
		the_row();
		switch($type = get_sub_field('row_type')) {
			case 'equipment': $value = get_sub_field('equipment'); break;
			case 'heading': $value = get_sub_field('heading'); break;
			default: $value = ''; break;
		}
		$equipments[] = [
			'type' => $type,
			'value' => $value,
		];
	}
}

$directions = [];
if( have_rows('directions') ) {
	while (have_rows('directions')) {
		the_row();
		switch($type = get_sub_field('row_type')) {
			case 'direction': $value = get_sub_field('direction'); break;
			case 'heading': $value = get_sub_field('heading'); break;
			default: $value = ''; break;
		}
		$directions[] = [
			'type' => $type,
			'value' => $value,
		];
	}
}

$difficulties = [];
$difficulties_terms = wp_get_post_terms(get_the_ID(), 'difficulty', array("fields" => "all"));
if($difficulties_terms) {
	foreach($difficulties_terms as $term) {
		$difficulties[] = [
			'term' => $term->name,
			'link' => get_term_link($term->term_id, 'difficulty')
		];
	}
}

$countries = [];
$countries_terms = wp_get_post_terms(get_the_ID(), 'country', array("fields" => "all"));
if($countries_terms) {
	foreach($countries_terms as $term) {
		$countries[] = [
			'term' => $term->name,
			'link' => get_term_link($term->term_id, 'country')
		];
	}
}

$methods = [];
$methods_terms = wp_get_post_terms(get_the_ID(), 'cooking_method', array("fields" => "all"));
if($methods_terms) {
	foreach($methods_terms as $term) {
		$methods[] = [
			'term' => $term->name,
			'link' => get_term_link($term->term_id, 'cooking_method')
		];
	}
}

$ingredient_cats = [];
$ingredient_cats_terms = wp_get_post_terms(get_the_ID(), 'ingredient', array("fields" => "all"));
if($ingredient_cats_terms) {
	foreach($ingredient_cats_terms as $term) {
		$ingredient_cats[] = [
			'term' => $term->name,
			'link' => get_term_link($term->term_id, 'ingredient')
		];
	}
}

$equipment = [];
$equipment_terms = wp_get_post_terms(get_the_ID(), 'equipment', array("fields" => "all"));
if($equipment_terms) {
	foreach($equipment_terms as $term) {
		$equipment[] = [
			'term' => $term->name,
			'link' => get_term_link($term->term_id, 'equipment')
		];
	}
}

$recipe_types = [];
$recipe_types__terms = wp_get_post_terms(get_the_ID(), 'recipe_type', array("fields" => "all"));
if($recipe_types__terms) {
	foreach($recipe_types__terms as $term) {
		$recipe_types[] = [
			'term' => $term->name,
			'link' => get_term_link($term->term_id, 'recipe_type')
		];
	}
}

$cooked_with = [];
$cooked_with__terms = wp_get_post_terms(get_the_ID(), 'cooked_with', array("fields" => "all"));
if($cooked_with__terms) {
	foreach($cooked_with__terms as $term) {
		$cooked_with[] = [
			'term' => $term->name,
			'link' => get_term_link($term->term_id, 'cooked_with')
		];
	}
}

$categories = [];
$categories_terms = wp_get_post_terms(get_the_ID(), 'food_category', array("fields" => "all"));
if($categories_terms) {
	foreach($categories_terms as $term) {
		$categories[] = [
				'term' => $term->name,
				'link' => get_term_link($term->term_id, 'food_category')
		];
	}
}

$related = [];
$related_posts = get_field('related');
if($related_posts) {
	foreach($related_posts as $post) {
		setup_postdata($post);
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

		$related[] = $app->render('partials/recipe-teaser.html.twig', [
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
}

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

while (have_posts()) {
	the_post();

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
    $pinterest_images = get_field( 'pinterest_images' );

	echo $app->render('pages/single-recipes.html.twig', [
		'author' => $author,
		'nutrition' => $nutrition,
		'slides' => $slides,
		'recipe_pdf' => $recipe_pdf,
		'video_lightbox' => $video_lightbox,
		'ingredients' => $ingredients,
		'equipments' => $equipments,
		'directions' => $directions,
		'difficulties' => $difficulties,
		'countries' => $countries,
		'cooking_methods' => $methods,
		'equipment' => $equipment,
		'recipe_types' => $recipe_types,
		'cooked_with' => $cooked_with,
		'ingredient_cats' => $ingredient_cats,
		'categories' => $categories,
		'related' => $related,
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
		'total_total_minutes' => $total_total,
        'pinterest_images' => $pinterest_images
	]);
}
get_footer();
