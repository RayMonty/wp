Wordpress
before doing anything 
•	go to your admin panel. go to pages and create two pages with the title home and blog and leave the contents empty
•	in your admin panel go to settings -->reading --> Your homepage displays
•	change it to static page. set home page to home and post page to blog
home will be powered by front-page.php and blog will be powered by index.php
create custom post types. create new posts inside them. 
•	now you have a list of all these posts you created in your archive-customTypeName.php.
•	and each single post you created in this custom post type is powered by single-customTypeName.php
•	and you can show all of them in your front end (landing page) by custom query for custom-post-types
•	if you categorized your posts and you want to show a list of posts based on one category, the page that shows this list is powered by archive.php
the same thing is true abour generic posts (posts you create in "posts" in your admin anel)
•	now you have a list of all these posts you created in your index.php
•	and each single post you created in this custom post type is powered by single.php
•	and you can show all of them in your front end (landing page) by custom query for generic posts
•	if you categorized your posts and you want to show a list of posts based on one category, the page that shows this list is powered by archive.php
front-end.php is responsible for landing page
•	page.php shows each single page you creare in page menu in admin panel
•	if you want a page to use another template, you have to create page-slug.php file in your theme folder for that page. slug is the slug of the page that is going to appear differently
to have category descriptions (to show in archieve page) you need to go to your admin panel and posts and in you post go to right pannel 
•	and give it a new category. author and dates are automatically powerd by wordpress
•	to have a bio about auther in category or whatever go to admin panel--> user
look at mu-plugin and also functions.php in this page and the notes there. you define custom post-types in mu-plugin
How to make a wp theme
All the programming functions and keywords must be in php area. You can always jump in/out of the php area
1.	You need php, apache, and mysql in your machine
a.	Install local by flywheel to have all these three things
2.	 create a theme folder. inside your theme folder:
3.	 create style.css
a.	write name, author and version of your theme in it.
b.	add your css data to this file
c.	if you have more css files, you should import them to style.css
4.	 create these files and copy the static html in them
a.	front-end.php (for homepage),  copy your landing page html template here 
b.	page.php (for single pages)  for all single pages you create in admin panel in pages 
c.	index.php (for all posts),   list of all single posts together 
d.	single.php (for single posts, where permalink sends us to)  powers signle posts you create
e.	archive.php for filtered pages by authors or dates or categories  if there are categories
f.	search.php  for search result page for wordpress
g.	404.php for notfound pages
h.	template-templateName   (to introduce a template for your other pages) youtube vide 1:24:16
i.	custom.css
j.	custom.js
k.	header.php
l.	footer.php
5.	cut stylesheets link tags from your index.html head tags and put them in functions.php for later use
6.	cut your script tag from your index.html and put them in functions.php for later use
7.	in your header.php put this:
<!DOCTYPE html>
<html lang="en">
<head>
 <?php wp_head(); ?>
</head>
<body>
down here goes the static HTML header tag :
8.	 in your footer put this:
//here goes the static HTML footer tag
<?php wp_footer();?>
</body>
</html>
9.	Copy the rest of the front page in front-page.php
10.	 add this functions to pages you need to have header and footer in php area: e.g in front-page.php
<?php get_header(); ?>                <?php get_footer();?>
11.	Go to wordpress admin pages  delete all the pages  create a page call it home
12.	Go to wordpress admin  setting  reading  change the display to static page and home page as frontpage
13.	Go to wordpress admin  settpering  permalink  change the permalink to nice one
14.	Copy all your css, js, images, etc folders into your theme folder
15.	create a function.php  look at reusables
a.	register CSS in your function: (all files with <link> tag) -> see functions.php
b.	register your js fies in function.php
	don’t name jQuery files as ‘JQuery’. It’s a reserved name
c.	make custom image sizes
d.	make wordpress support menues (they appear on Appearance  menues)
	add_theme_support(‘menus’);
	register your nav menues  youtube video at 1:15:14
	or register_nav_menu(‘HeaderMenuLocation’,’Header Menu Location’);  vid 5.6
e.	add featured image support. If you need repeated images use featured image
	add_theme_support(‘post-thambnails’);
f.	add title tag to automatically creates a title for the page based on our herder
	add_theme_support(‘title-tag’);
16.	don’t forget to put all add_theme_support above in this functionand call it:
function myThemeFeatures (){
       add_theme_support(‘menus’);
       add_theme_support(‘title-tag’);
       etc, etc…
}
Add_action(‘after_setup_theme’, ‘myThemeFeatures’ )
17.	convert image src file in wp understandable img files
a.	Images that are included in css are automatically included when you enqeue css files
b.	If you want dynamic background images you need to remove them from css and add inline styling
c.	Create an image folder in your theme folder and add all your images there
d.	Replace /images/ with <?php bloginfo(“template_directory”);?>/images/
Unti here you have a frntpage that works check it
18.	 start inserting the rest of your HTML in your wordpress php files
a.	header in header
b.	footer in footer
19.	If you need to render something dynamically use that tag between if and endif
a.	<?php if(a condition)?> some html tags <?php endif?>
20.	In your archive page you can display/hide some html tags based on archive type
a.	If (is_category()){ }  also single_cat_title()
b.	Is_author
c.	U can use the_archive_title() instead of all if statements here.
d.	The_archive_description()  define it in adminusers profile biografical info
21.	If you need to loop, use famous loop
22.	For your pages title and content you can use wordpress pages and posts and then using these in your html:
a.	the_title()
b.	the_content()
c.	the_excerpt()
d.	the_permalink() / get_permalink()  for dynamic menus
e.	the_author_posts_link()
f.	the_time()
23.	Go to your plugins and install advanced custom fields
a.	Add new custom field category, call it front page
b.	Create custom field groups and fields (e.g. group is hero and field is title)
c.	In your php file for each custom field group:
	To get the field  $hero = get_field(‘hero’);  (in a php area usually under the header)
	To use the filed: go where it needs to be dunamically inserted:
1.	<?php echo $hero[‘title’]?> t also works for links and hrefs
d.	If you have a sub group you can access them like this: <?php echo $hero[‘title’][‘second’]?>
24.	If you need forms, install gravity form plugin
25.	Need pagination?
a.	Echo paginate_links();
26.	If you need to show the pages and the posts links as a sidebar : video 5.4
Wp_list_pages (
“title_li”=>null,
“child_of” => 16
)
27.	Use the page or the post id 
a.	To show or hide a part of template if the page is a child or parent
	wp_get_post_parent_id(get_the_ID())
b.	To use permalink to redirect you to a specific page
	echo get_permalink(wp_get_post_parent_id(get_the_ID()))
c.	To use another page’s title somewhere in yor page
	echo get_the_title(wp_get_post_parent_id(get_the_ID()))
28.	if you want to have a gallery but don’t want to spend money, use custom query  vid 6.4
29.	if you need more categories than post and page, try using custom post types
php
<?php somecodes ?>
1.	If you want to define variables use $
	$myName = “Ray”;
2.	U can have functions just like js functions
3.	To show sth in browser use echo in php erea
4.	This is how we define arrays
a.	$myPals = array(‘Brad’,’Ted’,’Moe’)  to define array.
b.	$myPals[1]  to access Ted
5.	This is how we define objects (associated arrays)
$myPals = array(
‘dog’=> ‘barks’,
’cat’=>’mewos’
)
a.	$myPals[‘dog’]  returns ‘barks’
6.	Echo or not echo
a.	If a function starts with get, it simply return a value and you have to echo it yourself
i.	get_the_title()
ii.	get_the_id()
b.	If a function starts with the, it echos the value too
i.	the_title()
ii.	the_id()

Classes are like blue prints. You can have millions instances of each class
In case of : being copied in memory/inherit from parent, can we access them? how to access them, 
	Go to reusable and read the cheatsheets and firmulas in them. Memorize them
