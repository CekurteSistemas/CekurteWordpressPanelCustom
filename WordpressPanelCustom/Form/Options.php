<?php

namespace Cekurte\WordpressPanelCustom\Form;

if( !defined('ABSPATH') ) exit;

if( !class_exists('\\Cekurte\\WordpressPanelCustom\\Form\\Options') ) :

class Options extends \Cekurte\Library\Form {

	public function setup() {

		$this->addElement('select', 'show_admin_bar', array(
			'id' 			=> 'show_admin_bar',
			'label' 		=> __('Mostrar Barra de Ferramentas para o Administrador', 'cekurte') . ':',
			'class' 		=> 'input-xxlarge',
			'required' 		=> true,
			'validators' 	=> array('NotEmpty'),
			'multiOptions' 	=> array(
				0			=> __('Não', 'cekurte'),
				1			=> __('Sim', 'cekurte'),
			),
		));
		
		$this->addElement('select', 'show_admin_bar_front', array(
			'id' 			=> 'show_admin_bar_front',
			'label' 		=> __('Mostrar Barra de Ferramentas para o Administrador no FrontEnd', 'cekurte') . ':',
			'class' 		=> 'input-xxlarge',
			'required' 		=> true,
			'validators' 	=> array('NotEmpty'),
			'multiOptions' 	=> array(
				0			=> __('Não', 'cekurte'),
				1			=> __('Sim', 'cekurte'),
			),
		));
		
		$this->addElement('select', 'remove_wp_logo', array(
			'id' 			=> 'remove_wp_logo',
			'label' 		=> __('Remover o Logo do WP', 'cekurte') . ':',
			'class' 		=> 'input-xxlarge',
			'required' 		=> true,
			'validators' 	=> array('NotEmpty'),
			'multiOptions' 	=> array(
				0			=> __('Não', 'cekurte'),
				1			=> __('Sim', 'cekurte'),
			),
		));
		
		$this->addElement('text', 'business_name', array(
			'id' 			=> 'business_name',
			'label' 		=> __('Nome da Empresa', 'cekurte') . ':',
			'placeholder'	=> __('O Nome da Empresa.', 'cekurte'),
			'class' 		=> 'input-xxlarge',
			'required' 		=> true,
			'filters' 		=> array('StringTrim', 'StripTags'),
			'validators' 	=> array('NotEmpty'),
		));
		
		$this->addElement('text', 'business_slogan', array(
			'id' 			=> 'business_slogan',
			'label' 		=> __('Slogan da Empresa', 'cekurte') . ':',
			'placeholder'	=> __('O Slogan da Empresa, será exibido no rodapé do painel de controle.', 'cekurte'),
			'class' 		=> 'input-xxlarge',
			'required' 		=> true,
			'filters' 		=> array('StringTrim', 'StripTags'),
			'validators' 	=> array('NotEmpty'),
		));
		
		$this->addElement('text', 'business_site', array(
			'id' 			=> 'business_site',
			'label' 		=> __('Website da Empresa', 'cekurte') . ':',
			'placeholder'	=> __('http://www.site-da-empresa.com.br', 'cekurte'),
			'class' 		=> 'input-xxlarge',
			'required' 		=> true,
			'filters' 		=> array('StringTrim', 'StripTags'),
			'validators' 	=> array('NotEmpty'),
		));
		
		$this->addElement('text', 'business_logo', array(
			'id' 			=> 'business_logo',
			'label' 		=> __('Logomarca da Empresa', 'cekurte') . ':',
			'placeholder'	=> __('http://www.site-da-empresa.com.br/images/logo.png', 'cekurte'),
			'class' 		=> 'input-xxlarge',
			'required' 		=> true,
			'filters' 		=> array('StringTrim', 'StripTags'),
			'validators' 	=> array('NotEmpty'),
		));
		
		$this->addElement('text', 'rename_posts_singular_to', array(
			'id' 			=> 'rename_posts_singular_to',
			'label' 		=> __('Renomear Post (singular) para', 'cekurte') . ':',
			'placeholder'	=> __('Permite alterar o nome como um post será exibido. Exemplo: Notícia.', 'cekurte'),
			'class' 		=> 'input-xxlarge',
			'required' 		=> true,
			'filters' 		=> array('StringTrim', 'StripTags'),
			'validators' 	=> array('NotEmpty'),
		));
		
		$this->addElement('text', 'rename_posts_plural_to', array(
			'id' 			=> 'rename_posts_plural_to',
			'label' 		=> __('Renomear Posts (plural) para', 'cekurte') . ':',
			'placeholder'	=> __('Permite alterar o nome como os posts serão exibidos. Exemplo: Notícias.', 'cekurte'),
			'class' 		=> 'input-xxlarge',
			'required' 		=> true,
			'filters' 		=> array('StringTrim', 'StripTags'),
			'validators' 	=> array('NotEmpty'),
		));
		
		$this
			->addFieldSubmit()
			->addFieldReset()
		;
	}
}

endif;