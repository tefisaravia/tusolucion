<?php
/**
 * Genesis Framework.
 *
 * WARNING: This file is part of the core Genesis Framework. DO NOT edit this file under any circumstances.
 * Please do all modifications in the form of a child theme.
 *
 * @package StudioPress\Genesis\Admin
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://my.studiopress.com/themes/genesis/
 */

add_action( 'wp_ajax_genesis_do_onboarding_process', 'genesis_do_onboarding_process' );
/**
 * Processes onboarding tasks in batches.
 *
 * @since 2.8.0
 */
function genesis_do_onboarding_process() {

	check_ajax_referer( 'genesis-onboarding', 'nonce' );

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$task             = isset( $_POST['task'] ) ? sanitize_key( $_POST['task'] ) : 'dependencies';
	$step             = isset( $_POST['step'] ) ? absint( $_POST['step'] ) : 0;
	$next_step        = $step;
	$percent_complete = 0;
	$complete         = false;
	$errors           = [];

	/**
	 * Install plugin dependencies.
	 */
	if ( 'dependencies' === $task ) {

		$onboarding_plugins       = genesis_onboarding_plugins();
		$total_onboarding_plugins = count( $onboarding_plugins );

		if ( $total_onboarding_plugins === $step ) {
			wp_send_json_success(
				[
					'task'             => 'dependencies',
					'percent_complete' => 100,
					'next_step'        => 0,
					'complete'         => true,
					'errors'           => $errors,
				]
			);
		}

		$installed = genesis_onboarding_install_dependencies( $onboarding_plugins, $step );

		if ( is_wp_error( $installed ) ) {
			$errors[] = $installed->get_error_message();
			$next_step++;
			wp_send_json_success(
				[
					'percent_complete' => $percent_complete,
					'next_step'        => $next_step,
					'task'             => $task,
					'complete'         => $complete,
					'errors'           => $errors,
				]
			);
		}

		$step++;

		$percent_complete = round( ( $step / $total_onboarding_plugins ) * 100, 2 );

		$next_step++;

		if ( $total_onboarding_plugins === $step ) {
			$percent_complete = 100;
			$next_step        = 0;
			$complete         = true;
		}

		wp_send_json_success(
			[
				'percent_complete' => $percent_complete,
				'task'             => 'dependencies',
				'next_step'        => $next_step,
				'complete'         => $complete,
				'errors'           => $errors,
			]
		);
	}

	/**
	 * Import demo content.
	 */
	if ( 'content' === $task ) {

		$content = genesis_onboarding_content();

		$imported = genesis_onboarding_import_content( $content );

		if ( ! empty( $imported['errors'] ) ) {
			$errors[] = $imported['errors'];
		}

		$menus = genesis_onboarding_create_navigation_menus();

		if ( ! empty( $menus ) ) {
			$errors[] = $menus;
		}

		$menu_items = genesis_onboarding_create_navigation_menu_items();

		if ( ! empty( $menu_items ) ) {
			$errors[] = $menu_items;
		}

		wp_send_json_success(
			[
				'percent_complete'   => 100,
				'task'               => 'content',
				'next_step'          => 0,
				'complete'           => true,
				'homepage_edit_link' => isset( $imported['homepage_edit_link'] ) ? $imported['homepage_edit_link'] : false,
				'errors'             => $errors,
			]
		);
	}

	/**
	 * Send a default response in the unlikely event we reach this.
	 */
	wp_send_json_success(
		[
			'percent_complete' => 100,
			'task'             => $task,
			'next_step'        => $next_step,
			'complete'         => true,
			'errors'           => $errors,
		]
	);
}

add_action( 'wp_ajax_genesis_do_onboarding_pack_selection', 'genesis_do_onboarding_pack_selection' );
/**
 * Set the chosen Starter Pack.
 *
 * Temporarily store the chosen starter pack in a `genesis_onboarding_chosen_pack`
 * option so that onboarding functions can return information specific to that pack.
 *
 * Sends a JSON response that includes tasks to run for the chosen pack, which the
 * calling JavaScript code uses to update and trigger needed onboarding tasks.
 *
 * @since 3.1.0
 */
function genesis_do_onboarding_pack_selection() {

	check_ajax_referer( 'genesis-onboarding', 'nonce' );

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$pack = isset( $_POST['pack'] ) ? sanitize_key( $_POST['pack'] ) : '';

	update_option( 'genesis_onboarding_chosen_pack', $pack, false );

	$menus = genesis_onboarding_navigation_menus();

	wp_send_json_success(
		[
			'tasks'    => genesis_onboarding_tasks(),
			'hasMenus' => count( $menus ) > 0,
		]
	);

}
