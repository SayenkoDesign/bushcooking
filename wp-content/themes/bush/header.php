<?php
require_once 'bootstrap.php';
if ( is_user_logged_in() ) {
  $user_logged_in = true;
  $user = wp_get_current_user();
  $role = $user->roles;
  $current_user_role = $role[0];
  $user_name = $user->user_login;
} else {
  $user_logged_in = false;
  $current_user_role = false;
  $user_name = false;
}

$term = get_queried_object();
$font_family = get_field('font_family_link', $term);
$header_font_family = get_field('header_font_family_link', $term);

if(is_tax('cooked_with')){

  echo $app->render('template/header.html.twig', [
    'user_logged_in' => $user_logged_in,
    'current_user_role' => $current_user_role,
    'user_name' => $user_name,
    'header_font_family' => $header_font_family,
    'font_family' => $font_family,
  ]);

} else {

  echo $app->render('template/header.html.twig', [
    'user_logged_in' => $user_logged_in,
    'current_user_role' => $current_user_role,
    'user_name' => $user_name
  ]);

}
?>
