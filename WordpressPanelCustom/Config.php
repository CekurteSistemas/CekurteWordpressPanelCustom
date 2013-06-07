<?php

namespace Cekurte\WordpressPanelCustom;

use \Cekurte\Library\Html\Element\Admin\Container;
use \Cekurte\Library\Html\Message;

if( !defined('ABSPATH') ) exit;

if( !class_exists('\\Cekurte\\WordpressPanelCustom\\Config') ) :

/**
 * Customiza o painel de controle do Wordpress
 */
class Config {
    
    /**
     * Adiciona um hook na inicialização do Wordpress
     */
    public function __construct() {
    	add_action('init', array($this, 'init'), 100);
    }
    
    /**
     * Inicializa a criação do painel de configuração
     */
    public function init() {
    	add_action('admin_menu', array($this, 'add_admin_menu'));
    }
    
    public function add_admin_menu() {
    	add_menu_page(__('Cekurte WPanel', 'cekurte'), __('Cekurte WPanel', 'cekurte'), 'manage_options', 'cekurte-wordpress-panel-custom', array($this, 'cekurteWordpressPanelCustom'));
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
     * Configura o formulário para realizar a leitura das requisiões e armazena em uma option no banco de dados
     */
    public function cekurteWordpressPanelCustom() {
    	
    	$container = Container::getInstance()->getHeader(__('Cekurte WPanel', 'cekurte'), __('Personalize algumas informações do painel de controle do Wordpress.', 'cekurte'));
    	
    	$form = new Form\Options();
    	
    	$options = get_option('ck_wp_panel_custom');
    	
    	if (!empty($options)) {
    		foreach ($options as $name => $value) {
    			$form->getElement($name)->setValue($value);
    		}
    	}
    	
    	if (!empty($_POST)) {
    		
    		if ($form->isValid($_POST)) {
    			
    			foreach ($options as $name => $value) {
    				
    				$value = $form->getElement($name)->getValue();
    				
    				if (!empty($value)) {
    					$options[$name] = $value;
    				}
    			}
    			
	    		$success = update_option('ck_wp_panel_custom', $options);
	    			 
	    		if ($success !== false) {
	    			$container->append(Message::generate('Registro(s) armazenado(s) com sucesso.'));
	    		}
    		}
    	
    		if (!isset($success) or ($success === false)) {
    			$container->append(Message::generate('Ocorreu um problema ao armazenar as suas configurações.', Message::ERROR));
    		}
    	}
    	
    	$container->append((string) $form);
    	
    	echo $container;
    }
}

endif;