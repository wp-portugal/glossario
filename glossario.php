<?php
/*
 * Plugin Name: Glossario
 * Plugin URI: http://github.com/wpbrasil/glossario
 * Description: A glossary for managing terms in collaborative translations
 * Version: 0.01
 * Author: Brazilian and Portuguese WordPress Communities
 * Author URI: http://github.com/wpbrasil/glossario
 */

include( dirname( __FILE__ ) . '/glossario-metabox.php' );

class Glossario {

	public static $slug = 'glossario';
	var $post_term = 'glossario_term';
	var $post_pofile = 'glossario_po_file';
	var $tax_language = 'glossario_term_language';
	var $tax_class = 'glossario_term_class';
	var $tax_status = 'glossario_term_status';

	function Glossario() {
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
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

	/**
	 * Add Glossary term info meta box
	 */
	function add_meta_boxes() {
		$meta_box = array(
			'id' => Glossario::$slug . '_term_info',
			'title' => __( 'Glossary term info', 'glossario' ),
			'post_types' => array( $this->post_term ),
			'context' => 'normal',
			'priority' => 'high',
			'fields' => array(
				array(
					'type' => 'text',
					'id' => Glossario::$slug . '_original_term_singular',
					'name' => __( 'Original term singular', 'glossario' ),
					'desc' => __( 'Non-translated term in its singular form.', 'glossario' ),
					'std' => ''
				), array(
					'type' => 'text',
					'id' => Glossario::$slug . '_original_term_plural',
					'name' => __( 'Original term plural', 'glossario' ),
					'desc' => __( 'Non-translated term in its plural form.', 'glossario' ),
					'std' => ''
				), array(
					'type' => 'text',
					'id' => Glossario::$slug . '_term_singular',
					'name' => __( 'Singular translation', 'glossario' ),
					'desc' => __( 'Translated term in its singular form.', 'glossario' ),
					'std' => ''
				), array(
					'type' => 'text',
					'id' => Glossario::$slug . '_term_plural',
					'name' => __( 'Plural translation', 'glossario' ),
					'desc' => __( 'Translated term in its plural form.', 'glossario' ),
					'std' => ''
				), array(
					'type' => 'textarea',
					'id' => Glossario::$slug . '_translation_notes',
					'name' => __( 'Translation notes', 'glossario' ),
					'desc' => __( 'Optional notes or explanation about the translation above.' ),
					'std' => '',
				),
			),
		);
		new Glossario_Metabox( $meta_box );
	}

	function register_custom_post_types() {
		$post_types = array(
			$this->post_term => array(
				'labels' => array(
					'name' => __( 'Glossary', 'glossario' ),
					'singular_name' => __( 'Glossary', 'glossario' ),
					'add_new' => __( 'Add new glossary term', 'glossario' ),
					'add_new_item' => __( 'Add new glossary term', 'glossario' ),
					'edit_item' => __( 'Edit glossary term', 'glossario' ),
					'view_item' => __( 'View glossary term', 'glossario' ),
					'search_items' => __( 'Search for glossary terms', 'glossario' ),
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
				'supports' => array( 'comments' )
			),
			$this->post_pofile => array(
				'labels' => array(
					'name' => __( 'PO file', 'glossario' ),
					'singular_name' => __( 'PO files', 'glossario' ),
					'menu_name' => __( 'PO files', 'glossario' ),
					'add_new' => __( 'Add new PO file', 'glossario' ),
					'add_new_item' => __( 'Add new PO file', 'glossario' ),
					'edit_item' => __( 'Edit PO file', 'glossario' ),
					'view_item' => __( 'View PO file', 'glossario' ),
					'search_items' => __( 'Search for PO files', 'glossario' ),
				),
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => 'edit.php?post_type=' . $this->post_term,
				'rewrite' => array(
					'slug' => 'glossario/po-file',
					'with_front' => false,
				),
				'has_archive' => true,
				'hierarchical' => false,
				'menu_position' => null,
				'supports' => array( 'title', 'comments' )
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
					'name' => __( 'Glossary languages', 'glossario' ),
					'singular_name' => __( 'Glossary language', 'glossario' ),
					'all_items' => __( 'All glossary languages', 'glossario' ),
					'edit_item' => __( 'Edit glossary language', 'glossario' ),
					'view_item' => __( 'View glossary language', 'glossario' ),
					'update_item' => __( 'Update glossary language', 'glossario' ),
					'add_new_item' => __( 'Add new glossary language', 'glossario' ),
					'new_item_name' => __( 'New glossary language', 'glossario' ),
				),
				'hierarchical' => true,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'glossario/language' ),
			),
			$this->tax_class => array(
				'object_types' => array( 'glossario_term' ),
				'labels' => array(
					'name' => __( 'Morphology classes', 'glossario' ),
					'singular_name' => __( 'Morphology class', 'glossario' ),
					'all_items' => __( 'All morphology classes', 'glossario' ),
					'edit_item' => __( 'Edit morphology class', 'glossario' ),
					'view_item' => __( 'View morphology class', 'glossario' ),
					'update_item' => __( 'Update morphology class', 'glossario' ),
					'add_new_item' => __( 'Add new morphology class', 'glossario' ),
					'new_item_name' => __( 'New morphology class', 'glossario' ),
				),
				'hierarchical' => true,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'glossario/class' ),
			),
			$this->tax_status => array(
				'object_types' => array( 'glossario_term' ),
				'labels' => array(
					'name' => __( 'Translation status', 'glossario' ),
					'singular_name' => __( 'Translation status', 'glossario' ),
					'all_items' => __( 'All glossary term status', 'glossario' ),
					'edit_item' => __( 'Edit glossary term status', 'glossario' ),
					'view_item' => __( 'View glossary term status', 'glossario' ),
					'update_item' => __( 'Update glossary term status', 'glossario' ),
					'add_new_item' => __( 'Add new glossary term status', 'glossario' ),
					'new_item_name' => __( 'New glossary term status', 'glossario' ),
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
