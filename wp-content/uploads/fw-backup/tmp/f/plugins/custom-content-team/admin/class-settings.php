<?php
/**
 * Plugin settings screen.
 *
 * @package    CustomContentTeam
 * @subpackage Admin
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013-2015, Justin Tadlock
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/**
 * Sets up and handles the plugin settings screen.
 *
 * @since  1.0.0
 * @access public
 */
final class CCT_Settings_Page {

	/**
	 * Settings page name.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $settings_page = '';

	/**
	 * Sets up the needed actions for adding and saving the meta boxes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	private function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Sets up custom admin menus.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_menu() {

		// Create the settings page.
		$this->settings_page = add_submenu_page(
			'edit.php?post_type=' . cct_get_member_post_type(),
			esc_html__( 'Team Settings', 'custom-content-team' ),
			esc_html__( 'Settings',           'custom-content-team' ),
			apply_filters( 'cct_settings_capability', 'manage_options' ),
			'cct_settings',
			array( $this, 'cct_settings_page' )
		);

		if ( $this->settings_page ) {

			// Register settings.
			add_action( 'admin_init', array( $this, 'register_settings' ) );

			// Add help tabs.
			add_action( "load-{$this->settings_page}", array( $this, 'add_help_tabs' ) );
		}
	}

	/**
	 * Registers the plugin settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	function register_settings() {

		// Register the setting.
		register_setting( 'cct_settings', 'cct_settings', array( $this, 'validate_settings' ) );

		/* === Settings Sections === */

		add_settings_section( 'general',    esc_html__( 'General Settings', 'custom-content-team' ), array( $this, 'section_general'    ), $this->settings_page );
		add_settings_section( 'permalinks', esc_html__( 'Permalinks',       'custom-content-team' ), array( $this, 'section_permalinks' ), $this->settings_page );

		/* === Settings Fields === */

		// General section fields
		add_settings_field( 'team_title',       esc_html__( 'Title',       'custom-content-team' ), array( $this, 'field_team_title'       ), $this->settings_page, 'general' );
		add_settings_field( 'team_description', esc_html__( 'Description', 'custom-content-team' ), array( $this, 'field_team_description' ), $this->settings_page, 'general' );

		// Permalinks section fields.
		add_settings_field( 'team_rewrite_base', esc_html__( 'Team Base', 'custom-content-team' ), array( $this, 'field_team_rewrite_base' ), $this->settings_page, 'permalinks' );
		add_settings_field( 'member_rewrite_base',   esc_html__( 'Member Slug',   'custom-content-team' ), array( $this, 'field_member_rewrite_base'   ), $this->settings_page, 'permalinks' );
		add_settings_field( 'category_rewrite_base',  esc_html__( 'Category Slug',  'custom-content-team' ), array( $this, 'field_category_rewrite_base'  ), $this->settings_page, 'permalinks' );
		add_settings_field( 'tag_rewrite_base',       esc_html__( 'Tag Slug',       'custom-content-team' ), array( $this, 'field_tag_rewrite_base'       ), $this->settings_page, 'permalinks' );
		add_settings_field( 'author_rewrite_base',    esc_html__( 'Author Slug',    'custom-content-team' ), array( $this, 'field_author_rewrite_base'    ), $this->settings_page, 'permalinks' );
	}

	/**
	 * Validates the plugin settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array  $input
	 * @return array
	 */
	function validate_settings( $settings ) {

		// Text boxes.
		$settings['team_rewrite_base'] = $settings['team_rewrite_base'] ? trim( strip_tags( $settings['team_rewrite_base'] ), '/' ) : 'team';
		$settings['member_rewrite_base']   = $settings['member_rewrite_base']   ? trim( strip_tags( $settings['member_rewrite_base']   ), '/' ) : '';
		$settings['category_rewrite_base']  = $settings['category_rewrite_base']  ? trim( strip_tags( $settings['category_rewrite_base']  ), '/' ) : '';
		$settings['tag_rewrite_base']       = $settings['tag_rewrite_base']       ? trim( strip_tags( $settings['tag_rewrite_base']       ), '/' ) : '';
		$settings['author_rewrite_base']    = $settings['author_rewrite_base']    ? trim( strip_tags( $settings['author_rewrite_base']    ), '/' ) : '';
		$settings['team_title']        = $settings['team_title']        ? strip_tags( $settings['team_title'] )                     : esc_html__( 'Team', 'custom-content-team' );

		// Kill evil scripts.
		$settings['team_description'] = stripslashes( wp_filter_post_kses( addslashes( $settings['team_description'] ) ) );

		/* === Handle Permalink Conflicts ===*/

		// No member or category base, members win.
		if ( ! $settings['member_rewrite_base'] && ! $settings['category_rewrite_base'] )
			$settings['category_rewrite_base'] = 'categories';

		// No member or tag base, members win.
		if ( ! $settings['member_rewrite_base'] && ! $settings['tag_rewrite_base'] )
			$settings['tag_rewrite_base'] = 'tags';

		// No member or author base, members win.
		if ( ! $settings['member_rewrite_base'] && ! $settings['author_rewrite_base'] )
			$settings['author_rewrite_base'] = 'authors';

		// No category or tag base, categories win.
		if ( ! $settings['category_rewrite_base'] && ! $settings['tag_rewrite_base'] )
			$settings['tag_rewrite_base'] = 'tags';

		// No category or author base, categories win.
		if ( ! $settings['category_rewrite_base'] && ! $settings['author_rewrite_base'] )
			$settings['author_rewrite_base'] = 'authors';

		// No author or tag base, authors win.
		if ( ! $settings['author_rewrite_base'] && ! $settings['tag_rewrite_base'] )
			$settings['tag_rewrite_base'] = 'tags';

		// Return the validated/sanitized settings.
		return $settings;
	}

	/**
	 * General section callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function section_general() { ?>

		<p class="description">
			<?php esc_html_e( 'General team settings for your site.', 'custom-content-team' ); ?>
		</p>
	<?php }

	/**
	 * Team title field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_team_title() { ?>

		<label>
			<input type="text" class="regular-text" name="cct_settings[team_title]" value="<?php echo esc_attr( cct_get_team_title() ); ?>" />
			<br />
			<span class="description"><?php esc_html_e( 'The name of your team. May be used for the team page title and other places, depending on your theme.', 'custom-content-team' ); ?></span>
		</label>
	<?php }

	/**
	 * Team description field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_team_description() {

		wp_editor(
			cct_get_team_description(),
			'cct_team_description',
			array(
				'textarea_name'    => 'cct_settings[team_description]',
				'drag_drop_upload' => true,
				'editor_height'    => 150
			)
		); ?>

		<p>
			<span class="description"><?php esc_html_e( 'Your team description. This may be shown by your theme on the team page.', 'custom-content-team' ); ?></span>
		</p>
	<?php }

	/**
	 * Permalinks section callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function section_permalinks() { ?>

		<p class="description">
			<?php esc_html_e( 'Set up custom permalinks for the team section on your site.', 'custom-content-team' ); ?>
		</p>
	<?php }

	/**
	 * Team rewrite base field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_team_rewrite_base() { ?>

		<label>
			<code><?php echo esc_url( home_url( '/' ) ); ?></code>
			<input type="text" class="regular-text code" name="cct_settings[team_rewrite_base]" value="<?php echo esc_attr( cct_get_team_rewrite_base() ); ?>" />
		</label>
	<?php }

	/**
	 * Team rewrite base field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_member_rewrite_base() { ?>

		<label>
			<code><?php echo esc_url( home_url( cct_get_team_rewrite_base() . '/' ) ); ?></code>
			<input type="text" class="regular-text code" name="cct_settings[member_rewrite_base]" value="<?php echo esc_attr( cct_get_member_rewrite_base() ); ?>" />
		</label>
	<?php }

	/**
	 * Team rewrite base field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_category_rewrite_base() { ?>

		<label>
			<code><?php echo esc_url( home_url( cct_get_team_rewrite_base() . '/' ) ); ?></code>
			<input type="text" class="regular-text code" name="cct_settings[category_rewrite_base]" value="<?php echo esc_attr( cct_get_category_rewrite_base() ); ?>" />
		</label>
	<?php }

	/**
	 * Team rewrite base field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_tag_rewrite_base() { ?>

		<label>
			<code><?php echo esc_url( home_url( cct_get_team_rewrite_base() . '/' ) ); ?></code>
			<input type="text" class="regular-text code" name="cct_settings[tag_rewrite_base]" value="<?php echo esc_attr( cct_get_tag_rewrite_base() ); ?>" />
		</label>
	<?php }

	/**
	 * Author rewrite base field callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function field_author_rewrite_base() { ?>

		<label>
			<code><?php echo esc_url( home_url( cct_get_team_rewrite_base() . '/' ) ); ?></code>
			<input type="text" class="regular-text code" name="cct_settings[author_rewrite_base]" value="<?php echo esc_attr( cct_get_author_rewrite_base() ); ?>" />
		</label>
	<?php }

	/**
	 * Renders the settings page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function cct_settings_page() {

		// Flush the rewrite rules if the settings were updated.
		if ( isset( $_GET['settings-updated'] ) )
			flush_rewrite_rules(); ?>

		<div class="wrap">
			<h1><?php esc_html_e( 'Team Settings', 'custom-content-team' ); ?></h1>

			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php settings_fields( 'cct_settings' ); ?>
				<?php do_settings_sections( $this->settings_page ); ?>
				<?php submit_button( esc_attr__( 'Update Settings', 'custom-content-team' ), 'primary' ); ?>
			</form>

		</div><!-- wrap -->
	<?php }

	/**
	 * Adds help tabs.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function add_help_tabs() {

		// Get the current screen.
		$screen = get_current_screen();

		// General settings help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'general',
				'title'    => esc_html__( 'General Settings', 'custom-content-team' ),
				'callback' => array( $this, 'help_tab_general' )
			)
		);

		// Permalinks settings help tab.
		$screen->add_help_tab(
			array(
				'id'       => 'permalinks',
				'title'    => esc_html__( 'Permalinks', 'custom-content-team' ),
				'callback' => array( $this, 'help_tab_permalinks' )
			)
		);

		// Set the help sidebar.
		$screen->set_help_sidebar( cct_get_help_sidebar_text() );
	}

	/**
	 * Displays the general settings help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_general() { ?>

		<ul>
			<li><?php _e( '<strong>Title:</strong> Allows you to set the title for the team section on your site. This is general shown on the team members archive, but themes and other plugins may use it in other ways.', 'custom-content-team' ); ?></li>
			<li><?php _e( '<strong>Description:</strong> This is the description for your team. Some themes may display this on the team members archive.', 'custom-content-team' ); ?></li>
		</ul>
	<?php }

	/**
	 * Displays the permalinks help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function help_tab_permalinks() { ?>

		<ul>
			<li><?php _e( '<strong>Team Base:</strong> The primary URL for the team section on your site. It lists your team members.', 'custom-content-team' ); ?></li>
			<li>
				<?php _e( '<strong>Member Slug:</strong> The slug for single team members. You can use something custom, leave this field empty, or use one of the following tags:', 'custom-content-team' ); ?>
				<ul>
					<li><?php printf( esc_html__( '%s - The member author name.', 'custom-content-team' ), '<code>%author%</code>' ); ?></li>
					<li><?php printf( esc_html__( '%s - The member category.', 'custom-content-team' ), '<code>%' . cct_get_category_taxonomy() . '%</code>' ); ?></li>
					<li><?php printf( esc_html__( '%s - The member tag.', 'custom-content-team' ), '<code>%' . cct_get_tag_taxonomy() . '%</code>' ); ?></li>
				</ul>
			</li>
			<li><?php _e( '<strong>Category Slug:</strong> The base slug used for team category archives.', 'custom-content-team' ); ?></li>
			<li><?php _e( '<strong>Tag Slug:</strong> The base slug used for team tag archives.', 'custom-content-team' ); ?></li>
			<li><?php _e( '<strong>Author Slug:</strong> The base slug used for team author archives.', 'custom-content-team' ); ?></li>
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

CCT_Settings_Page::get_instance();
