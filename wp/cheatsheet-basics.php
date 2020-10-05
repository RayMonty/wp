

<!-- ===========================================================FAMOUS LOOP for single.php / single-postTypeName.php =================================================== -->
<?php
while(have_posts()){
  the_post();?>

    <?php the_title(); ?>
    <?php the_content(); ?>

<?php
}
?>


<!-- ===========================================================FAMOUS LOOP for index.php / postTypeName.php =================================================== -->
<?php
  while(have_posts()) {
    the_post(); ?>

    <!-- //takes us to the single post -->
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        Posted by <?php the_author_posts_link(); ?> on <?php the_time('n.j.y'); ?> in <?php echo get_the_category_list(', '); ?>
        <?php the_excerpt(); ?>
        <a class="btn btn--blue" href="<?php the_permalink(); ?>">Continue reading</a>

  <?php }
  echo paginate_links();
?>


<!-- =========================================================== use ACF fields  ================================================================ -->
<?php 
// on top of your page
$myField = get_field('field_name');

// where you want to show output
echo $myField['sub_fields'];
?>


/// <!-- ====================================================  useful codes that can be used in all pages =================================================== -->
<!-- dynamic backgrounf image -->
<div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/library-hero.jpg') ?>);"></div>
<!-- add this to the body -->
<body <?php body_class(); ?>>

<?php
the_permalink(); //  in loop takes us to the single.php that powers that single post (each single post).  works for generic and custom post types
the_title();     //  // //  ....  works for generic and custom post types
the_author_posts_link();  // displays the name of the auther of the post.  works only for generic post types
the_time('n.j.y');   // show the time of the creation of post . works for generic and custom post types
get_the_archive_title() ;// shows the title of the archive wheather it's by author, date, or category. works only for generic post types
get_the_archive_description(); // shows the info you have in category description of the archive . works only for generic post types
the_excerpt(); //works for generic post types
echo paginate_links(); //works for all post types. sometimes for custom post types you need to go extra mile if you have custom query- see page-past-events.php
get_template_part('template-parts/content', 'event'); //how to get template files. the name of the file will be content-event. used in while loops
<a href="<?php echo site_url('/past-events') ?>"> // how to get to specific url
<a href="<?php echo get_post_type_archive_link('program'); ?>"> // dynamically get a link of an archive of a custom post type . good for front page navbar
<a href="<?php echo get_the_permalink($program); ?>">
wp_reset_postdata(); // usually after while loop. to reset id. if we have more than one while loop in one file
?> <li <?php if (get_post_type() == 'post') echo 'class="current-menu-item"' ?>><a href="<?php echo site_url('/blog'); ?>">Blog</a></li> <?php // check the posttype you are dealing with
the_post_thumbnail("professorPortrait"); //  to show the thumbnail. itis defined in functions.php for our custom post tye. what you pass as argument is the size

?>


<!-- ==================================================// login ang logout and checking authentication functions======================================= -->

<div class="site-header__util">
<?php if(is_user_logged_in()) { ?>
  <a href="<?php echo wp_logout_url();  ?>" class="btn btn--small  btn--dark-orange float-left btn--with-photo">
  <span class="site-header__avatar"><?php echo get_avatar(get_current_user_id(), 60); ?></span>
  <span class="btn__text">Log Out</span>
  </a>
  <?php } else { ?>
    <a href="<?php echo wp_login_url(); ?>" class="btn btn--small btn--orange float-left push-right">Login</a>
    <a href="<?php echo wp_registration_url(); ?>" class="btn btn--small  btn--dark-orange float-left">Sign Up</a>
   <?php } ?>

<a href="<?php echo esc_url(site_url('/search')); ?>" class="search-trigger js-search-trigger"><i class="fa fa-search" aria-hidden="true"></i></a>
</div>

<!-- =========================================================== used in front-page in navbar =================================================== -->
<!-- dynamic a tags  -->
<a href="<?php echo site_url() ?>">click me</a>
<a href="<?php echo site_url('/about-us') ?>">About Us</a>
<!-- dynamic menue? vid 5.6 -->
1. insert menue in functions.php
2. define menue in admin panel
3. insert one line of code when you want your menue to appear


<!-- =========================================================== custom query for generic posts (posttypes: posts)=================================================== -->
<?php
          $homepagePosts = new WP_Query(array(
            'posts_per_page' => 2
          ));
          
          while ($homepagePosts->have_posts()) {
            $homepagePosts->the_post(); ?>
              <a href="<?php the_permalink();?>">
                <span class="event-summary__month"><?php the_time('M'); ?></span>
                <span class="event-summary__day"><?php the_time('d'); ?></span>  
              </a>
                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <p><?php echo wp_trim_words(get_the_content(), 18); ?> <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a></p>
          <?php } wp_reset_postdata();
        ?> 


<!-- =========================================================== custom query for custom post types  ================================================================ -->
<?php 

          $homepageEvents = new WP_Query(array(
            'posts_per_page' => -1, // to show all posts
            // chang ethis number to show only a limited number of them
            'post_type' => 'event',
            'orderby' => 'posts',
            'order' => 'ASC',
          ));

          while($homepageEvents->have_posts()) {
            $homepageEvents->the_post(); ?>
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            /// use excerpt if exist otherwise uses a short amount of text
                <p><?php if (has_excerpt()) {
                    echo get_the_excerpt();
                  } else {
                    echo wp_trim_words(get_the_content(), 18);
                    } ?> <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a></p>
          <?php }
        ?>

<!-- =========================================================== parent child relationship=================== =================================================== -->
1. make a page
2. on the right panel --> page attribute --> page parent :set the paretn page
3. in page.php where you want to have something between parents and children e.e menu:
      look at page.php and write them down. they all exist in page.php

conditionally showing things in a page if the page is a child password_get_info  
<?php
      $theParent = wp_get_post_parent_id(get_the_ID());
      if ($theParent) { ?>
        <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($theParent); ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
    </div>
      <?php }
    ?>
