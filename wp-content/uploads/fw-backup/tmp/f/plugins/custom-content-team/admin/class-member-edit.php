<?php
/**
 * New/Edit member admin screen.
 *
 * @package    CustomContentTeam
 * @subpackage Admin
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013-2015, Justin Tadlock
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Member edit screen functionality.
 *
 * @since  1.0.0
 * @access public
 */
final class CCT_Member_Edit {

	/**
	 * Holds the fields manager instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    object
	 */
	public $manager = '';

	/**
	 * Sets up the needed actions.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	private function __construct() {

		add_action( 'load-post.php',     array( $this, 'load' ) );
		add_action( 'load-post-new.php', array( $this, 'load' ) );

		// Add the help tabs.
		add_action( 'cct_load_member_edit', array( $this, 'add_help_tabs' ) );
	}

	/**
	 * Runs on the page load. Checks if we're viewing the member post type and adds
	 * the appropriate actions/filters for the page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function load() {

		$screen       = get_current_screen();
		$member_type = cct_get_member_post_type();

		// Bail if not on the members screen.
		if ( empty( $screen->post_type ) || $member_type !== $screen->post_type )
			return;

		// Custom action for loading the edit member screen.
		do_action( 'cct_load_member_edit' );

		// Load the fields manager.
		require_once( cct_plugin()->dir_path . 'admin/fields-manager/class-manager.php' );

		// Create a new member details manager.
		$this->manager = new CCT_Fields_Manager( 'member_details' );

		// Enqueue scripts and styles.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

		// Output the member details box.
		add_action( 'edit_form_after_editor', array( $this, 'member_details_box' ) );

		// Add/Remove meta boxes.
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );

		// Add custom option to the publish/submit meta box.
		add_action( 'post_submitbox_misc_actions', array( $this, 'submitbox_misc_actions' ) );

		// Save metadata on post save.
		add_action( 'save_post', array( $this, 'update' ) );

		// Filter the post author drop-down.
		add_filter( 'wp_dropdown_users_args', array( $this, 'dropdown_users_args' ), 10, 2 );
	}

	/**
	 * Load scripts and styles.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue() {

		wp_enqueue_style( 'cct-admin' );
		wp_enqueue_script( 'cct-edit-member' );
	}

	/**
	 * Adds/Removes meta boxes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string  $post_type
	 * @return void
	 */
	public function add_meta_boxes( $post_type ) {

		//remove_meta_box( 'postexcerpt', $post_type, 'normal' );
	}

	/**
	 * Callback on the `post_submitbox_misc_actions` hook (submit meta box). This handles 
	 * the output of the sticky member feature.
	 *
	 * @note   Prior to WP 4.4.0, the `$post` parameter was not passed.
	 * @since  1.0.0
	 * @access public
	 * @param  object  $post
	 * @return void
	 */
	public function submitbox_misc_actions( $post = '' ) {

		// Pre-4.4.0 compatibility.
		if ( ! $post ) {
			global $post;
		}

		// Get the post type object.
		$post_type_object = get_post_type_object( cct_get_member_post_type() );

		// Is the member sticky?
		$is_sticky = cct_is_member_sticky( $post->ID );

		// Set the label based on whether the member is sticky.
		$label = $is_sticky ? esc_html__( 'Sticky', 'custom-content-team' ) : esc_html__( 'Not Sticky', 'custom-content-team' ); ?>

		<div class="misc-pub-section curtime misc-pub-member-sticky">

			<?php wp_nonce_field( 'cct_member_publish_box_nonce', 'cct_member_publish_box' ); ?>

			<i class="dashicons dashicons-sticky"></i>
			<?php printf( esc_html__( 'Sticky: %s', 'custom-content-team' ), "<strong class='cct-sticky-status'>{$label}</strong>" ); ?>

			<?php if ( current_user_can( $post_type_object->cap->publish_posts ) ) : ?>

				<a href="#cct-sticky-edit" class="cct-edit-sticky"><span aria-hidden="true"><?php esc_html_e( 'Edit', 'custom-content-team' ); ?></span> <span class="screen-reader-text"><?php esc_html_e( 'Edit sticky status', 'custom-content-team' ); ?></span></a>

				<div id="cct-sticky-edit" class="hide-if-js">
					<label>
						<input type="checkbox" name="cct_member_sticky" id="cct-member-sticky" <?php checked( $is_sticky ); ?> value="true" />
						<?php esc_html_e( 'Stick to the team page', 'custom-content-team' ); ?>
					</label>
					<a href="#cct-member-sticky" class="cct-save-sticky hide-if-no-js button"><?php esc_html_e( 'OK', 'custom-content-portolio' ); ?></a>
					<a href="#cct-member-sticky" class="cct-cancel-sticky hide-if-no-js button-cancel"><?php esc_html_e( 'Cancel', 'custom-content-portolio' ); ?></a>
				</div><!-- #cct-sticky-edit -->

			<?php endif; ?>

		</div><!-- .misc-pub-member-sticky -->
	<?php }

	/**
	 * Output the member details box.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $post
	 * @return void
	 */
	public function member_details_box( $post ) { ?>

		<div id="cct-member-tabs" class="postbox">

			<h3><?php printf( esc_html__( 'Member Details: %s', 'members' ), '<span class="cct-which-tab"></span>' ); ?></h3>

			<div class="inside">
				<?php $this->manager->display( $post->ID ); ?>
			</div><!-- .inside -->

		</div><!-- .postbox -->
	<?php }

	/**
	 * Save member details settings on post save.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  int     $post_id
	 * @return void
	 */
	public function update( $post_id ) {

		$this->manager->update( $post_id );

		// Verify the nonce.
		if ( ! isset( $_POST['cct_member_publish_box'] ) || ! wp_verify_nonce( $_POST['cct_member_publish_box'], 'cct_member_publish_box_nonce' ) )
			return;

		// Is the sticky checkbox checked?
		$should_stick = ! empty( $_POST['cct_member_sticky'] );

		// If checked, add the member if it is not sticky.
		if ( $should_stick && ! cct_is_member_sticky( $post_id ) )
			cct_add_sticky_member( $post_id );

		// If not checked, remove the member if it is sticky.
		elseif ( ! $should_stick && cct_is_member_sticky( $post_id ) )
			cct_remove_sticky_member( $post_id );
	}

	/**
	 * Filter on the post author drop-down (used in the "Author" meta box) to only show users
	 * of roles that have the correct capability for editing team members.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array   $args
	 * @param  array   $r
	 * @global object  $wp_roles
	 * @global object  $post
	 * @return array
	 */
	function dropdown_users_args( $args, $r ) {
		global $wp_roles, $post;

		// WP version 4.4.0 check. Bail if we can't use the `role__in` argument.
		if ( ! method_exists( 'WP_User_Query', 'fill_query_vars' ) )
			return $args;

		// Check that this is the correct drop-down.
		if ( 'post_author_override' === $r['name'] && cct_get_member_post_type() === $post->post_type ) {

			$roles = array();

			// Loop through the available roles.
			foreach ( $wp_roles->roles as $name => $role ) {

				// Get the edit posts cap.
				$cap = get_post_type_object( cct_get_member_post_type() )->cap->edit_posts;

				// If the role is granted the edit posts cap, add it.
				if ( isset( $role['capabilities'][ $cap ] ) && true === $role['capabilities'][ $cap ] )
					$roles[] = $name;
			}

			// If we have roles, change the args to only get users of those roles.
			if ( $roles ) {
				$args['who']      = '';
				$args['role__in'] = $roles;
			}
		}

		return $args;
	}

	/**
	 * Adds custom help tabs.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function add_help_tabs() {

		$screen = get_current_screen();

		// Title and editor help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'title_editor',
				'title'    => esc_html__( 'Title and Editor', 'custom-content-team' ),
				'callback' => array( $this, 'help_tab_title_editor' )
			)
		);

		// Member details help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'member_details',
				'title'    => esc_html__( 'Member Details', 'custom-content-team' ),
				'callback' => array( $this, 'help_tab_member_details' )
			)
		);

		// Set the help sidebar.
		$screen->set_help_sidebar( cct_get_help_sidebar_text() );
	}

	/**
	 * Displays the title and editor help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_title_editor() { ?>

		<ul>
			<li><?php _e( "<strong>Title:</strong> Enter a title for your member. After you enter a title, you'll see the permalink below, which you can edit.", 'custom-content-team' ); ?></li>
			<li><?php _e( '<strong>Editor:</strong> The editor allows you to add or edit content for your member. You can insert text, media, or shortcodes.', 'custom-content-team' ); ?></li>
		</ul>
	<?php }

	/**
	 * Displays the member details help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_member_details() { ?>

		<p>
			<?php esc_html_e( 'The Member Details meta box allows you to customize the details of your member. All fields are optional.', 'custom-content-team' ); ?>
		</p>

		<ul>
			<li><?php _e( '<strong>URL:</strong> The URL to the Web site or page associated with the member, such as a client Web site.', 'custom-content-team' ); ?></li>
			<li><?php _e( '<strong>Client:</strong> The name of the client the member was built for.', 'custom-content-team' ); ?></li>
			<li><?php _e( '<strong>Location:</strong> A physical location where the member took place (e.g., Highland Home, AL, USA).', 'custom-content-team' ); ?></li>
			<li><?php _e( '<strong>Pros:</strong> Good Sides of the teamed subject.', 'custom-content-team' ); ?></li>
			<li><?php _e( '<strong>Cons:</strong> Bad Sides of the teamed subject.', 'custom-content-team' ); ?></li>
			<li><?php _e( '<strong>Conclusion:</strong> A short summary of the member. Some themes may show this on archive pages.', 'custom-content-team' ); ?></li>
		</ul>
	<?php }

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) )
			$instance = new self;

		return $instance;
	}
}

CCT_Member_Edit::get_instance();
