<?php
/*
 * Plugin Name: Glossario
 * Plugin URI: http://github.com/wpbrasil/glossario
 * Description: A glossary for managing terms in collaborative translations
 * Version: 0.01
 * Author: Brazilian and Portuguese WordPress Communities
 * Author URI: http://github.com/wpbrasil/glossario
 */

class Glossario {

	var $slug = 'glossario';
	var $textdomain = 'glossario';
	var $post_term = 'glossario_term';
	var $post_pofile = 'glossario_po_file';
	var $tax_language = 'glossario_term_language';
	var $tax_class = 'glossario_term_class';
	var $tax_status = 'glossario_term_status';

	function Glossario() {
		add_action( 'init', array( $this, 'init' ) );
	}

	function activate() {
		// @TODO: write plugin data if not exists
	}

	function deactivate() {
		// @TODO: flush plugin data
	}

	function uninstall() {
		// @TODO: remove plugin data
	}

	function init() {
		$this->register_custom_post_types();
		$this->register_custom_taxonomies();
	}

	function register_custom_post_types() {
		$post_types = array(
			$this->post_term => array(
				'labels' => array(
					'name' => __( 'Glossary', $this->textdomain ),
					'singular_name' => __( 'Glossary', $this->textdomain ),
					'add_new' => __( 'Add new glossary term', $this->textdomain ),
					'add_new_item' => __( 'Add new glossary term', $this->textdomain ),
					'edit_item' => __( 'Edit glossary term', $this->textdomain ),
					'view_item' => __( 'View glossary term', $this->textdomain ),
					'search_items' => __( 'Search for glossary terms', $this->textdomain ),
				),
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'rewrite' => array(
					'slug' => 'glossario/term',
					'with_front' => false
				),
				'has_archive' => true,
				'menu_position' => null,
				'supports' => array( 'title', 'comments' )
			),
			$this->post_pofile => array(
				'labels' => array(
					'name' => __( 'PO file', $this->textdomain ),
					'singular_name' => __( 'PO files', $this->textdomain ),
					'menu_name' => __( 'PO files', $this->textdomain ),
					'add_new' => __( 'Add new PO file', $this->textdomain ),
					'add_new_item' => __( 'Add new PO file', $this->textdomain ),
					'edit_item' => __( 'Edit PO file', $this->textdomain ),
					'view_item' => __( 'View PO file', $this->textdomain ),
					'search_items' => __( 'Search for PO files', $this->textdomain ),
				),
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'rewrite' => array(
					'slug' => 'glossario/po-file',
					'with_front' => false,
				),
				'has_archive' => true,
				'hierarchical' => false,
				'menu_position' => null,
				'supports' => array( 'title', 'thumbnail' )
			)
		);
		foreach ( $post_types as $type => $args ) {
			register_post_type( $type, $args );
		}
	}

	function register_custom_taxonomies() {
		$taxonomies = array(
			$this->tax_language => array(
				'object_types' => array( 'glossario_term', 'glossario_po_file' ),
				'labels' => array(
					'name' => __( 'Glossary languages', $this->textdomain ),
					'singular_name' => __( 'Glossary language', $this->textdomain ),
					'all_items' => __( 'All glossary languages', $this->textdomain ),
					'edit_item' => __( 'Edit glossary language', $this->textdomain ),
					'view_item' => __( 'View glossary language', $this->textdomain ),
					'update_item' => __( 'Update glossary language', $this->textdomain ),
					'add_new_item' => __( 'Add new glossary language', $this->textdomain ),
					'new_item_name' => __( 'New glossary language', $this->textdomain ),
				),
				'hierarchical' => true,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'glossario/language' ),
			),
			$this->tax_class => array(
				'object_types' => array( 'glossario_term' ),
				'labels' => array(
					'name' => __( 'Morfology classes', $this->textdomain ),
					'singular_name' => __( 'Morfology class', $this->textdomain ),
					'all_items' => __( 'All morfology classes', $this->textdomain ),
					'edit_item' => __( 'Edit morfology class', $this->textdomain ),
					'view_item' => __( 'View morfology class', $this->textdomain ),
					'update_item' => __( 'Update morfology class', $this->textdomain ),
					'add_new_item' => __( 'Add new morfology class', $this->textdomain ),
					'new_item_name' => __( 'New morfology class', $this->textdomain ),
				),
				'hierarchical' => true,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'glossario/class' ),
			),
			$this->tax_status => array(
				'object_types' => array( 'glossario_term' ),
				'labels' => array(
					'name' => __( 'Translation status', $this->textdomain ),
					'singular_name' => __( 'Translation status', $this->textdomain ),
					'all_items' => __( 'All glossary term status', $this->textdomain ),
					'edit_item' => __( 'Edit glossary term status', $this->textdomain ),
					'view_item' => __( 'View glossary term status', $this->textdomain ),
					'update_item' => __( 'Update glossary term status', $this->textdomain ),
					'add_new_item' => __( 'Add new glossary term status', $this->textdomain ),
					'new_item_name' => __( 'New glossary term status', $this->textdomain ),
				),
				'hierarchical' => true,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'glossario/status' ),
			),
		);
		foreach ( $taxonomies as $taxonomy => $args ) {
			register_taxonomy( $taxonomy, $args['object_types'], $args );
		}
	}

}

function better_front_page_ui_init() {
	new Glossario();
}
add_action( 'plugins_loaded', 'better_front_page_ui_init' );

register_activation_hook( __FILE__, array( 'Glossario', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Glossario', 'deactivate' ) );
register_uninstall_hook( __FILE__, array( 'Glossario', 'uninstall' ) );
