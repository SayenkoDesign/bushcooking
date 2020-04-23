<?php
global $app;
$ambassador_title = get_field('brand_slider_title');
$ambassador_section = [];
if( have_rows('brands')) {
    while (have_rows('brands')) : the_row();
        $image_array = get_sub_field('brand_image');
        $image_array['brand_url'] = get_sub_field('brand_url');
        array_push($ambassador_section, $image_array);
    endwhile;
}
echo $app->render('template/footer.html.twig', [
    'ambassador_title' => $ambassador_title,
    'ambassador_section' => $ambassador_section
]);
?>
