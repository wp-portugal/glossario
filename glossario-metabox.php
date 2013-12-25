<?php

/**
 * @file Metabox manager
 */

class Glossario_Metabox {

    protected $_meta_box;

    // Create meta box based on given data
    function Glossario_Metabox( $meta_box ) {
		$this->_meta_box = $meta_box;

		foreach( $meta_box['post_types'] as $post_type ) {
			add_meta_box( $this->_meta_box['id'], $this->_meta_box['title'], array( $this, 'render_form' ),
				$post_type, $this->_meta_box['context'], $this->_meta_box['priority'] );
		}

		add_filter( 'wp_insert_post_data' , array( $this, 'wp_insert_post_data' ) , '99', 2 );
		add_action( 'save_post', array( $this, 'save_post' ) );
    }

    // Callback function to show fields in meta box
    function render_form() {

		$field_template = '<tr valign="top"><th scope="row"><label for="%s">%s</label></th><td>%s</td></tr>';

		// Use nonce for verification
		echo '<input type="hidden" name="' . Glossario::$slug . '_nonce" value="', wp_create_nonce( basename( __FILE__ ) ), '" />';
		echo '<table class="form-table">';

		foreach ( $this->_meta_box['fields'] as $field ) {
			printf( $field_template, $field['id'], $field['name'], $this->render_field( $field ) );
		}

		echo '</table>';

	}

	function render_field( $field ) {

		global $post;

		$meta = get_post_meta( $post->ID, $field['id'], true );

		ob_start();

		switch ($field['type']) {

			case 'text':
				echo '<input class="widefat" type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="', $meta ? $meta : $field['std'], '" />';
				echo '<p class="description">' . $field['desc'] . '</p>';
			break;

			case 'textarea':
				echo '<textarea class="widefat" name="' . $field['id'] . '" id="' . $field['id'] . '" rows="4">', $meta ? $meta : $field['std'], '</textarea>';
				echo '<p class="description">' . $field['desc'] . '</p>';
			break;

		}

		return ob_get_clean();

	}

	function wp_insert_post_data( $data , $postarr ) {
		$key = Glossario::$slug . '_original_term_singular';
		if ( !empty( $postarr[ $key ] ) )
			$data['post_title'] = $postarr[ $key ];
		return $data;
	}

	// Save data from meta box
    function save_post( $post_id ) {

		// verify nonce
		$nonce = Glossario::$slug . '_nonce';
		if ( empty( $_POST[ $nonce ] ) || !wp_verify_nonce( $_POST[ $nonce ], basename( __FILE__ ) ) )
			return $post_id;

		// check autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		// check permissions
		if ( 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ) )
				return $post_id;
		} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		// Write changes
		foreach ( $this->_meta_box['fields'] as $field ) {
			$old = get_post_meta( $post_id, $field['id'], true );
			$new = $_POST[ $field['id'] ];

			if ( $new && $new != $old )
				update_post_meta( $post_id, $field['id'], $new );
			elseif ('' == $new && $old)
				delete_post_meta( $post_id, $field['id'], $old );

		}
    }
}
