<?php

namespace Cekurte;

if( !defined('ABSPATH') ) exit;

require realpath(dirname(__FILE__) . '/autoloader.php');

/*
Plugin Name: 	Cekurte Wordpress Custom Panel
Plugin URI: 	http://sistemas.cekurte.com/portfolio/wp/cekurte-wp-panel-custom
Description: 	Customiza algumas funcionalidades do painel de administração do Wordpress.
Version: 		1.0
Author: 		Cekurte Sistemas
Author URI: 	http://sistemas.cekurte.com
*/

if( !class_exists('\\Cekurte\\WordpressPanelCustom') ) :

/**
 * Customiza o painel de controle do Wordpress
 */
class WordpressPanelCustom {
	
	/**
	 * 
	 * @var array armazena as options "ck_wp_panel_custom"
	 */
	private $options;
    
    /**
     * Adiciona um hook na inicialização do Wordpress
     */
    public function __construct() {
    	add_action('init', array($this, 'init'), 10);
    	register_activation_hook(__FILE__, array($this, 'install'));
    }
    
    /**
     * Adiciona uma nova opção no banco de dados, executada quando o plugin é ativado
     */
    public function install() {
    	add_option('ck_wp_panel_custom', array(
    		'show_admin_bar'			=> 1,
    		'show_admin_bar_front'		=> 1,
    		'remove_wp_logo'			=> 1,
    		'business_name'				=> 'Cekurte Sistemas',
    		'business_slogan'			=> 'Programando o futuro do seu negócio',
    		'business_site'				=> 'http://sistemas.cekurte.com/',
    		'business_logo'				=> plugins_url('assets/img/logo.png', __FILE__),
    		'rename_posts_singular_to'	=> __('Notícia', 'cekurte'),
    		'rename_posts_plural_to'	=> __('Notícias', 'cekurte'),
    	));
    }
    
    /**
     * Inicializa a customização
     */
    public function init() {
    	
    	new \Cekurte\WordpressPanelCustom\Config();
    	
    	$this->options = get_option('ck_wp_panel_custom');
    	 
    	$this->hideAdminBar();
    	
    	add_action('init', array($this, 'loadScripts'), 50);
    	
    	add_action('init', array($this, 'loadStyles'), 50);
    	
    	add_action('admin_init', array($this, 'hideAdminBarTools'));
    	
    	add_action('init', array($this, 'updateLabelsPostTypeObject'));
    	
    	add_action('admin_menu', array($this, 'updateLabelsPostType'));
    	 
    	add_filter('admin_footer_text', array($this, 'updateLabelAdminFooter'));
    	
    	add_action('wp_before_admin_bar_render', array($this, 'removeWordpressAdminLogo'), 0);
    	
    	add_filter('login_headertitle', array($this, 'updateAltLoginTitle'));
    	
    	add_action('login_head', array($this, 'updateLoginLogo'));
    	
    	add_filter('login_headerurl', array($this, 'updateAltLoginUrl'));
    }
    
    /**
     * Carrega os scripts da página
     */
    public function loadScripts() {
    
    	global $pagenow;
    
    	if (is_admin() and ($pagenow == 'admin.php') and ($_GET['page'] == 'cekurte-wordpress-panel-custom')) {
    		wp_enqueue_script('bootstrap', plugins_url('assets/js/bootstrap.min.js', __FILE__), array('jquery'), false, false);
    	}
    }
    
    /**
     * Carrega os estilos da página
     */
    public function loadStyles() {
    	
    	global $pagenow;
    
    	if (is_admin() and ($pagenow == 'admin.php') and ($_GET['page'] == 'cekurte-wordpress-panel-custom')) {
    		wp_enqueue_style('bootstrap', 				plugins_url('assets/css/bootstrap.min.css', __FILE__));
    		wp_enqueue_style('cekurte_options', 		plugins_url('assets/css/cekurte_options.css', __FILE__));
    	}
    }
    
    /**
     * Mostra a barra de Admin apenas para os administradores
     */
    public function hideAdminBar() {
    	if( !current_user_can('manage_options') ) {
    		if ($this->options['show_admin_bar'] == 1) {
    			add_filter('show_admin_bar', '__return_false');
    		}
    	}
    }
    
    /**
     * Modifica a configuração de cada usuário para não exibir a barra de ferramentas
     * ao ver o site
     */
    public function hideAdminBarTools() {
    
    	if ($this->options['show_admin_bar_front'] == 1) {
	    		
	    	$users = get_users();
	    
	    	foreach ($users as $user) {
	    		update_user_meta( $user->ID, 'show_admin_bar_front', 'false' );
	    	}
    	}
    }
    
    /**
     * Remove o "Wordpress" do Rodapé do Painel
     */
    public function updateLabelAdminFooter() {
		echo sprintf(
			'<a href="%s" target="_blank">%s</a> - %s.', 
			$this->options['business_site'],
			$this->options['business_name'],
			$this->options['business_slogan']
		);
	}
	
	/**
	 * Remove o Logo do Wordpress na barra de administração dentro do painel
	 */
	public function removeWordpressAdminLogo() {
		
		if ($this->options['remove_wp_logo'] == 1) {
			global $wp_admin_bar;
			
			$wp_admin_bar->remove_menu('wp-logo');
		}
	}
	
	/**
	 * Atualiza o atributo "href" do logo presente na página de login
	 */
	public function updateAltLoginUrl() {
		return $this->options['business_site'];
	}
	
	/**
	 * Atualiza o atributo "title" do logo presente na página de login
	 */
	public function updateAltLoginTitle() {
		return $this->options['business_name'];
	}
	
	/**
	 * Atualiza a imagem que será utilizada como logo na página de login
	 */
	public function updateLoginLogo() {	
		echo sprintf('<style type="text/css"> h1 a {  background-image:url(%s) !important; } </style>', $this->options['business_logo']);
	}
	
	/**
	 * Modifica os labels do Painel de "Posts" para "Notícias"
	 */
	public function updateLabelsPostType() {
		global $menu;
		global $submenu;
		
		$menu[5][0] 				= __($this->options['rename_posts_singular_to'], 'cekurte');
		$submenu['edit.php'][5][0] 	= __($this->options['rename_posts_singular_to'], 'cekurte');
		$submenu['edit.php'][10][0] = __('Adicionar', 'cekurte') . ' ' . __($this->options['rename_posts_plural_to'], 'cekurte');
		$submenu['edit.php'][16][0] = __('Tags', 'cekurte');
	}
	
	/**
	 * Modifica os labels do Painel de "Posts" para "Notícias"
	 */
	public function updateLabelsPostTypeObject() {
		
		global $wp_post_types;
		
		$labels 					= &$wp_post_types['post']->labels;
		$labels->name 				= __($this->options['rename_posts_plural_to'], 'cekurte');
		$labels->singular_name 		= __($this->options['rename_posts_plural_to'], 'cekurte');
		$labels->add_new 			= __('Adicionar', 'cekurte') 	. ' ' . __($this->options['rename_posts_singular_to'], 'cekurte');
		$labels->add_new_item 		= __('Adicionar', 'cekurte') 	. ' ' . __($this->options['rename_posts_singular_to'], 'cekurte');
		$labels->edit_item 			= __('Editar', 'cekurte') 		. ' ' . __($this->options['rename_posts_singular_to'], 'cekurte');
		$labels->new_item 			= __($this->options['rename_posts_singular_to'], 'cekurte');
		$labels->view_item 			= __('Visualizar', 'cekurte') 	. ' ' . __($this->options['rename_posts_plural_to'], 'cekurte');
		$labels->search_items 		= __('Pesquisar', 'cekurte') 	. ' ' . __($this->options['rename_posts_plural_to'], 'cekurte');
		$labels->not_found 			= __('Nenhuma', 'cekurte') 		. ' ' . __($this->options['rename_posts_singular_to'], 'cekurte') . ' ' . __('encontrada', 'cekurte');
		$labels->not_found_in_trash = __('Nenhuma', 'cekurte') 		. ' ' . __($this->options['rename_posts_singular_to'], 'cekurte') . ' ' . __('encontrada na lixeira', 'cekurte');
	}
}

$GLOBALS['cekurte-wp-panel-custom'] = new \Cekurte\WordpressPanelCustom();

endif;