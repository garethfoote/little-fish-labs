<?php

use Timber\Site;

/**
 * Class StarterSite
 */
class StarterSite extends Site {
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'init', array( $this, 'lfl_add_custom_capabilities' ) );
    add_filter( 'wp_enqueue_scripts', array( $this, 'lfl_remove_jquery') );
    add_action('admin_head', array( $this, 'lfl_admin_custom_css'));
    add_action('admin_menu', array( $this, 'lfl_remove_appearance_submenus'), 9999);
    
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_filter( 'timber/twig/environment/options', [ $this, 'update_twig_environment_options' ] );

		add_action('wp_enqueue_scripts', array( $this, 'load_scripts' ) );

		add_action( 'admin_head', array( $this,'lfl_remove_admin_items'));
		add_action( 'admin_head', array( $this, 'lfl_remove_comments') );
		
		add_filter( 'custom_menu_order', array( $this,'lfl_custom_menu_order') );
		add_filter( 'menu_order', array( $this,'lfl_custom_menu_order') );

    add_action('admin_enqueue_scripts', array($this, 'lfl_custom_change_title_placeholder'));

		parent::__construct();
	}

  public function lfl_remove_appearance_submenus() {
    if (current_user_can('editor')) {
      // Remove Customize submenu
      remove_submenu_page('themes.php', 'customize.php');
      
      // Remove Themes submenu
      // remove_submenu_page('themes.php', 'themes.php');
      
      // Remove Patterns submenu
      remove_submenu_page('themes.php', 'edit.php?post_type=wp_block');
    }
  }

	/**
	 * Adding custom capabilities to editor role
	 */
  public function lfl_add_custom_capabilities() {
    // Get the role object
    $role = get_role( 'editor' ); // or use 'administrator' or any other role

    // Add desired capabilities
    $role->add_cap( 'edit_theme_options' ); // Required for managing menus
    $role->add_cap( 'manage_nav_menus' ); // Allows managing navigation menus
    $role->remove_cap('customize');
}

	/**
	 * Adding custom css to admin
   * - hide View 'Post' 
	 */
  public function lfl_custom_change_title_placeholder() {
    $post_types = array("lfl_wwd", "lfl_team", "lfl_brands");
    global $typenow;
    if(in_array($typenow, $post_types)){
        wp_enqueue_script(
            'lfl-custom-change-title-placeholder',
            get_template_directory_uri() . '/public/admin/post-title-placeholder.js',
            array('jquery'),
            '1.0',
            true
        );
    }
}

	/**
	 * Adding custom css to admin
   * - hide View 'Post' 
	 */
  public function lfl_admin_custom_css() {
    $post_types = array("lfl_wwd", "lfl_team", "lfl_brands");
    global $post;
    // print_r($post->post_type); exit();
    if($post && in_array($post->post_type, $post_types)){
      echo '<style>
        #wp-admin-bar-view {
          display: none;
        }
        .row-actions .inline { display: none; }
      </style>';
    }

    if (current_user_can('editor')) {
      echo '<style type="text/css">
          /* Hide Customize menu item */
          li.hide-if-no-customize { display: none !important; }
          .theme-browser .active-theme { display: none !important; }
      </style>';
    }
  }
	/**
	 * Remove jQuery
	 */
  public function lfl_remove_jquery() {
    if (!is_admin()) {
      wp_dequeue_script( 'jquery');
      wp_deregister_script( 'jquery'); 
    }
  }

	/**
	 * Remove the content editor from pages as all content is handled through Panels
	 */
	public function lfl_remove_admin_items()
	{
		if((int) get_option('page_on_front') == get_the_ID()) {
			remove_post_type_support('page', 'editor');
		}

    remove_menu_page('edit-comments.php');
    remove_menu_page('edit.php');
	}

  public function lfl_custom_menu_order( $menu_ord ) {
    if ( !$menu_ord ) return true;

    return array(
      'index.php', // Dashboard
      'separator1', // First separator
      'edit.php', // Posts
      'edit.php?post_type=page', // Pages
      'separator2', // Second separator
      'edit.php?post_type=lfl_brands', // Brands
      'edit.php?post_type=lfl_team', // Team
      'edit.php?post_type=lfl_wwd', // What we do
      'separator-last', // Last separator
      'upload.php', // Media
      'themes.php', // Appearance
      'plugins.php', // Plugins
      'users.php', // Users
      'tools.php', // Tools
      'options-general.php', // Settings
    );
  }

	public function load_scripts() {
		$manifestPath = get_theme_file_path('public/dist/manifest.json');
	   
		if (is_array(wp_remote_get('http://localhost:5173/'))) {
	   
		 $theme = wp_get_theme();
		 $theme_directory = $theme->get_stylesheet();

		 wp_enqueue_script('vite', 'http://localhost:5173/@vite/client', [], null);
		 wp_enqueue_script('main-js', 'http://localhost:5173/assets/js/main.js', [], null, true);
		 wp_enqueue_style('style-css', 'http://localhost:5173/assets/css/styles.css', [], 'null');
	   
		} elseif (file_exists($manifestPath)) {
		
		 $manifest = json_decode(file_get_contents($manifestPath), true);
		 wp_enqueue_script('main-js', get_theme_file_uri('public/dist/' . $manifest['assets/js/main.js']['file']), [], null, true);
		 wp_enqueue_style('style-css', get_theme_file_uri('public/dist/' . $manifest['assets/css/styles.css']['file']), [], null);
	   
		}
	}

	/**
	 * This is where you can register custom post types.
	 */
	public function register_post_types() {

		register_post_type('lfl_brands',
			array(
				'labels'      => array(
					'name'          => __('Brands', 'textdomain'),
					'singular_name' => __('Brand', 'textdomain'),
					'edit_item' => 'Edit Brand',
					'view_item' => 'View Brand',
					'view_items' => 'View Brands',
					'add_new_item' => 'Add New Brand',
					'add_new' => 'Add New Brand',
					'new_item' => 'New Brand',
				),
				'public'      => true,
        'publicly_queryable' => false,
				'has_archive' => false,
				'menu_icon' => 'dashicons-carrot',
				'supports' => array('title')
			)
		);

		register_post_type('lfl_team',
			array(
				'labels'      => array(
					'name'          => __('Team', 'textdomain'),
					'singular_name' => __('Team Member', 'textdomain'),
					'edit_item' => 'Edit Member',
					'view_item' => 'View Member',
					'view_items' => 'View Team',
					'add_new_item' => 'Add New Member',
					'add_new' => 'Add New Member',
					'new_item' => 'New Member',
				),
				'public'      => true,
        'publicly_queryable' => false,
				'has_archive' => false,
				'menu_icon' => 'dashicons-smiley',
				'supports' => array('title')
			)
		);

    register_post_type('lfl_wwd',
      array(
        'labels'      => array(
          'name'          => __('What We Do', 'textdomain'),
          'singular_name' => __('What We Do item', 'textdomain'),
          'edit_item' => 'Edit What We Do item',
          'view_item' => 'View What We Do item',
          'view_items' => 'View What We Do items',
          'add_new_item' => 'Add New What We Do item',
          'add_new' => 'Add New What We Do item',
          'new_item' => 'New What We Do item',
        ),
        'public'      => true,
        'publicly_queryable' => false,
        'has_archive' => false,
        'menu_icon' => 'dashicons-hammer',
        'supports' => array('title')
      )
    );
		
	}

	/**
	 * This is where you can register custom taxonomies.
	 */
	public function register_taxonomies() {

	}

	/**
	 * This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['foo']   = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['menu']  = Timber::get_menu('primary', ['depth' => 1]);
		$context['site']  = $this;

		return $context;
	}

	public function theme_supports() {

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );
	}

	/**
	 * his would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/**
	 * This is where you can add your own functions to twig.
	 *
	 * @param Twig\Environment $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		/**
		 * Required when you want to use Twig’s template_from_string.
		 * @link https://twig.symfony.com/doc/3.x/functions/template_from_string.html
		 */
		// $twig->addExtension( new Twig\Extension\StringLoaderExtension() );

		$twig->addFilter( new Twig\TwigFilter( 'myfoo', [ $this, 'myfoo' ] ) );

		return $twig;
	}

	/**
	 * Updates Twig environment options.
	 *
	 * @link https://twig.symfony.com/doc/2.x/api.html#environment-options
	 *
	 * \@param array $options An array of environment options.
	 *
	 * @return array
	 */
	function update_twig_environment_options( $options ) {
	    // $options['autoescape'] = true;

	    return $options;
	}
}
