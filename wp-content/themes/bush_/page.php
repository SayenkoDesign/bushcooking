<?php
// if( is_tribe_calendar() && !is_user_logged_in() ):
//     $url = '/user-registration';
//     header("Location: $url", true, 301);
//     echo $url;
//     exit;
// endif;
if (is_page( 'user' ) && isset($_GET['user_name'])):
    $user_name = $_GET['user_name'];
    $user_object = get_user_by('login', $user_name);
    $user_roles = $user_object->roles;
    if (in_array('author', $user_roles)) {
        $url = '/author' . '/' . $user_name;
        header("Location: $url", true, 301);
        echo $url;
        exit;
    }
    if (is_user_logged_in()){
      $user = wp_get_current_user();
      $role = $user->roles;
      if (in_array('home_user', $role) && $user_name == $user->user_login) {
        $current_users_page = true;
      } else {
        $current_users_page = false;
      }
    } else {
      $current_users_page = false;
    }
endif;

get_header();
global $app;

while (have_posts()) {
    the_post();
    ob_start();
    the_content();

    // if(is_tribe_calendar()){
    //       $content = ob_get_clean();
    //       echo $app->render('pages/events.html.twig', [
    //           'content' => $content,
    //       ]);
    // }

    if (is_page( 'user' )){
        if(isset($_GET['user_name']) && username_exists( $_GET['user_name'] )) {
              $user_name = $_GET['user_name'];
              $content = ob_get_clean();
              $user_object = get_user_by('login', $user_name);
              $user_id = $user_object->ID;
              $acf_user = 'user_'.$user_id;
              $user_meta = [
                  'id' => $user_id,
                  'website' => get_the_author_meta('url', $user_id),
                  'google' => get_the_author_meta('googleplus', $user_id),
                  'twitter' => get_the_author_meta('twitter', $user_id),
                  'facebook' => get_the_author_meta('facebook', $user_id),
                  'linkedin' => get_the_author_meta('linkedin', $user_id),
                  'pinterest' => get_the_author_meta('pinterest', $user_id),
                  'instagram' => get_the_author_meta('instagram', $user_id),
                  'youtube' => get_the_author_meta('youtube', $user_id),
                  'overview' => get_field('overview', $acf_user),
                  'bio' => get_field('bio', $acf_user),
                  'bio_teaser' => get_field('bio_teaser', $acf_user),
                  'name' => get_the_author_meta('first_name', $user_id) . ' ' . get_the_author_meta('last_name', $user_id),
                  'first_name' => get_the_author_meta('first_name', $user_id),
                  'last_name' => get_the_author_meta('last_name', $user_id),
              ];

              echo $app->render('pages/user.html.twig', [
                  'user_meta' => $user_meta,
                  'current_users_page' => $current_users_page,
                  'content' => $content,
              ]);
        } else {
              $content = ob_get_clean();
              echo $app->render('pages/user.html.twig', [
                  'user_meta' => false,
              ]);
        }
    } else {
        $content = ob_get_clean();
        echo $app->render('pages/page.html.twig', [
            'content' => $content,
        ]);
    }
}
get_footer();
