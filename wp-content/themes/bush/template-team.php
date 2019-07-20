<?php
/*
Template Name: Team Page
*/

get_header();
global $app;

// Hero
$hero_bg = get_field( 'team_hero_background_image' );
$hero_heading = get_field( 'team_hero_headline_text' );
$hero_body = get_field( 'team_hero_body_text' );
ob_start();
the_content();
$content = ob_get_clean();
$id = get_the_ID();
$title = get_queried_object()->post_title;

// Intro text?

// Team memebrs section
$team_members = [];
foreach(get_field('team_members') as $member) {
    $author_id = $member['ID'];
    $acf_user = 'user_'.$author_id;
    $schema_info = get_field('schema_info', $acf_user);

    $team_members[] = $app->render('partials/team-member.html.twig',[
        'id' => $author_id,
        'website' => get_the_author_meta('url', $author_id),
        'google' => get_the_author_meta('googleplus', $author_id),
        'twitter' => get_the_author_meta('twitter', $author_id),
        'facebook' => get_the_author_meta('facebook', $author_id),
        'linkedin' => get_the_author_meta('linkedin', $author_id),
        'pinterest' => get_the_author_meta('pinterest', $author_id),
        'instagram' => get_the_author_meta('instagram', $author_id),
        'youtube' => get_the_author_meta('youtube', $author_id),
        'overview' => get_field('overview', $acf_user),
        'bio' => get_field('bio', $acf_user),
        'bio_teaser' => get_field('bio_teaser', $acf_user),
        'name' => get_the_author_meta('first_name', $author_id) . ' ' . get_the_author_meta('last_name', $author_id),
        'user_name' => str_replace(' ', '-', get_the_author_meta('display_name', $author_id)),
        'first_name' => get_the_author_meta('first_name', $author_id),
        'last_name' => get_the_author_meta('last_name', $author_id),
        'affiliation' => $schema_info['affiliation'],
        'awards' => $schema_info['awards'],
        'brand' => $schema_info['brand'],
        'email' => $schema_info['email'],
        'gender' => $schema_info['gender'],
        'hasOccupation' => $schema_info['hasOccupation'],
        'knowsAbout' => $schema_info['knowsabout'],
        'memberOf' => $schema_info['memberOf'],
        'sponsor' => $schema_info['sponsor'],
        'homeLocation' => $schema_info['homeLocation'],
        'author' => $schema_info['author'],
        'appearedIn' => $schema_info['appeared_in'],
        'bush_role' => $schema_info['bush_role']
    ]);
}
wp_reset_postdata();

// Render full page
echo $app->render('pages/team.html.twig', [
    'hero_bg' => $hero_bg,
    'hero_heading' => $hero_heading,
    'hero_body' => $hero_body,
    'content' => $content,
    'title' => $title,
    'team_members' => $team_members
]);
get_footer();
