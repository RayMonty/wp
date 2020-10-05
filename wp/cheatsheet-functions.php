<?php

function load_stylesheets(){
    wp_register_style('icon', get_template_directory_uri() . '/images/icon.png', array(), 1, 'all');
    wp_enqueue_style('icon');
    wp_register_style('myplugin', get_template_directory_uri() . '/css/plugins.css', array(), 1, 'all');
    wp_enqueue_style('myplugin');
    wp_register_style('fontAwesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), 1, 'all');
    wp_enqueue_style('fontAwesome');
    wp_register_style('iransans', get_template_directory_uri() . '/css/iransans.css', array(), 1, 'all');
    wp_enqueue_style('iransans');
    wp_register_style('mystyle', get_template_directory_uri() . '/css/styles-rtl.css', array(), 1, 'all');
    wp_enqueue_style('mystyle');
    wp_register_style('thecolor', get_template_directory_uri() . '/css/color/style6.css', array(), 1, 'all');
    wp_enqueue_style('thecolor');
}
add_action( "wp_enqueue_scripts", "load_stylesheets" );

function addjs(){
    // wp_deregister_script( "jquery" ); // in case jquery causes a problem
    wp_register_script('myplugin', get_template_directory_uri() . '/js/plugins.js', array(), 1, 1,1);
    wp_enqueue_script('myplugin');
    wp_register_script('easepack', get_template_directory_uri() . '/js/animated/EasePack.min.js', array(), 1, 1,1);
    wp_enqueue_script('easepack');
    wp_register_script('tweenlite', get_template_directory_uri() . '/js/animated/TweenLite.min.js', array(), 1, 1,1);
    wp_enqueue_script('tweenlite');
    wp_register_script('animatedone', get_template_directory_uri() . '/js/animated/animated1.js', array(), 1, 1,1);
    wp_enqueue_script('animatedone');
    wp_register_script('contactForm', get_template_directory_uri() . '/js/min/contact-form-min.js', array(), 1, 1,1);
    wp_enqueue_script('contactForm');
    wp_register_script('mymain', get_template_directory_uri() . '/js/min/main-rtl.js', array(), 1, 1,1);
    wp_enqueue_script('mymain');
}
    add_action( "wp_enqueue_scripts", "addjs" );

 function university_features() {
    add_theme_support('title-tag'); // title of the page
    add_theme_support('post-thumbnails'); // for featured images
    // add_theme_support('menus');
    // add_theme_support('widgets');
 }
      
add_action('after_setup_theme', 'university_features');



// Custom Image Sizes
add_image_size('blog-large', 800, 600, false);
add_image_size('blog-small', 300, 200, true);
// in your template do echo $image['sub category if needed']['sizes']['the names above']
// do it in php area inside src=""

// Menus
// register_nav_menus(

//     array(

//         'top-menu' => 'Top Menu Location',
//         'mobile-menu' => 'Mobile Menu Location',
//         'footer-menu' => 'Footer Menu Location',

//     )

// );

// Register Sidebars
// function my_sidebars()
// {


// 			register_sidebar(

// 						array(

// 								'name' => 'Page Sidebar',
// 								'id' => 'page-sidebar',
// 								'before_title' => '<h3 class="widget-title">',
// 								'after_title' => '</h3>'

// 						)

// 			);


// 			register_sidebar(

// 						array(

// 								'name' => 'Blog Sidebar',
// 								'id' => 'blog-sidebar',
// 								'before_title' => '<h3 class="widget-title">',
// 								'after_title' => '</h3>'

// 						)

// 			);



// }
// add_action('widgets_init','my_sidebars');

?>



<?php

// to include files from inc folder to be more organized
require get_theme_file_path('/inc/search-route.php');


/// this is the function that adds a property called authorName to the wp rest api
// then in our search.js we access authorName from api
function university_custom_rest() {
  register_rest_field('post', 'authorName', array(
    'get_callback' => function() {return get_the_author();}
  ));
}
// we call it on rest_api_init
add_action('rest_api_init', 'university_custom_rest');

// reusable functon to use in our php files --> page.php, and singles.php
// the user can call the function like 
// pageBanner(array(
//   "title"=>"this is my title",
//   "subtitle" => "bla bla bla",
// ));
// if he doesnt pass any arguent it will use the default arguments defined in the function
function pageBanner($args = NULL) {

  if (!$args['title']) {
    // get the title from wp
    $args['title'] = get_the_title();
  }

  if (!$args['subtitle']) {
    // get the subtitle from advanced custom field
    $args['subtitle'] = get_field('page_banner_subtitle');
  }

  if (!$args['photo']) {
     // get the image from advanced custom field
    if (get_field('page_banner_background_image')) {
      $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
    } else {
      // or use a default image
      $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
    }
  }

  ?>
  <div class="page-banner">
      <!-- if yiu want to use sizes dont forget to change the image type to imageArray in custom field -->
    <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
      <div class="page-banner__intro">
        <p><?php echo $args['subtitle']; ?></p>
      </div>
    </div>  
  </div>
<?php }

function university_files() {
  wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
  wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
  wp_enqueue_style('university_main_styles', get_stylesheet_uri());
  // to set the uri dynamic for search bar
  wp_localize_script('main-university-js', 'universityData', array(
    'root_url' => get_site_url()
  ));
}

add_action('wp_enqueue_scripts', 'university_files');

/// features we want our theme to support
function university_features() {
  // this is for the title of the page in browser
  add_theme_support('title-tag');
  // to have featured image. 
  // if you want it to be able for custom post types you need to go to mu-plugin and do sth --> look at professor post type there
  add_theme_support('post-thumbnails');
  // wp creates some sized in upload folder by default- 5 copies of each image
  // for our custom size we can do as below. the first argument is a name we choose :
  add_image_size('professorLandscape',400,260, true);
  add_image_size('professorPortrait',480,650,true);
  // true says we have to crop the image 
  // to apply this to previous images we use a plugin 

  // for the banner. we have a custom field for that which applies to all post types
  add_image_size('pageBanner',1500,350,true);
}

add_action('after_setup_theme', 'university_features');


function university_adjust_queries($query) {

  /// in archive-program.php (when you have all programs listed in one page) sorts the events based on date
  if (!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', -1);
  }

  /// in archive-events.php (when you have all events listed in one page) sorts the events based on date
  if (!is_admin() AND is_post_type_archive('event') AND is_main_query()) {
    $today = date('Ymd');
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', array(
              array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
              )
            ));
  }
}

add_action('pre_get_posts', 'university_adjust_queries');



// Redirect subscriber accounts out of admin and onto homepage
// membership can be applied in settings/genral settings/ memebership in your admin pannel
function redirectSubsToFrontend() {
  $ourCurrentUser = wp_get_current_user();
  
  if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
    wp_redirect(site_url('/'));
    exit;
  }
}
add_action('admin_init', 'redirectSubsToFrontend');


function noSubsAdminBar() {
  $ourCurrentUser = wp_get_current_user();
  
  if (count($ourCurrentUser->roles) == 1 AND $ourCurrentUser->roles[0] == 'subscriber') {
    show_admin_bar(false);
  }
}
add_action('wp_loaded', 'noSubsAdminBar');


// Customize Login Screen
add_filter('login_headerurl', 'ourHeaderUrl');

function ourHeaderUrl() {
  return esc_url(site_url('/'));
}


function ourLoginCSS() {
  wp_enqueue_style('university_main_styles', get_stylesheet_uri());
  wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
}
add_action('login_enqueue_scripts', 'ourLoginCSS');

add_filter('login_headertitle', 'ourLoginTitle');

function ourLoginTitle() {
  return get_bloginfo('name');
}