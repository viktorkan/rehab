<?php
/**
 * The template for displaying all single posts and attachments
 */

//$theme_options = valeo_get_theme_mods();

get_header();
remove_filter( 'the_content', 'cct_the_content_filter', 25 );
$pID = get_the_ID();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<div class="post-container">
			<div class="site__row member-team-wrapper">
			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();
				if ( in_the_loop() && cct_is_single_member() && cct_is_member() && ! post_password_required() ) :

					$categories = get_categories( array( 'type' => 'services_article', 'orderby' => 'name', 'taxonomy' => 'services_category' ) );
					$tags = get_categories( array( 'type' => 'services_article', 'orderby' => 'name', 'taxonomy' => 'services_tag' ) );

					$before = '';
					$after = '';
					$address = cct_get_member_meta( $pID, 'address' );
					$address_formatted = cct_get_member_address( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
					$phone = cct_get_member_meta( $pID, 'phone' );
					$phone_formatted = cct_get_member_phone( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
					$email = cct_get_member_meta( $pID, 'email' );
					$email_formatted = cct_get_member_phone( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );

					$get_skill_1 = get_post_meta($pID, 'skill_1', true);
					$skill_1 = !empty($get_skill_1) ? get_post_meta($pID, 'skill_1', true) : false;
					$get_skill_name_1 = get_post_meta($pID, 'skill_name_1', true);
					$skill_name_1 = !empty($get_skill_name_1) ? get_post_meta($pID, 'skill_name_1', true) : false;
					$get_skill_2 = get_post_meta($pID, 'skill_2', true);
					$skill_2 = !empty($get_skill_2) ? get_post_meta($pID, 'skill_2', true) : false;
					$get_skill_name_2 = get_post_meta($pID, 'skill_name_2', true);
					$skill_name_2 = !empty($get_skill_name_2) ? get_post_meta($pID, 'skill_name_2', true) : false;
					$get_skill_3 = get_post_meta($pID, 'skill_3', true);
					$skill_3 = !empty($get_skill_3) ? get_post_meta($pID, 'skill_3', true) : false;
					$get_skill_name_3 = get_post_meta($pID, 'skill_name_3', true);
					$skill_name_3 = !empty($get_skill_name_3) ? get_post_meta($pID, 'skill_name_3', true) : false;
					$get_skill_4 = get_post_meta($pID, 'skill_4', true);
					$skill_4 = !empty($get_skill_4) ? get_post_meta($pID, 'skill_4', true) : false;
					$get_skill_name_4 = get_post_meta($pID, 'skill_name_4', true);
					$skill_name_4 = !empty($get_skill_name_4) ? get_post_meta($pID, 'skill_name_4', true) : false;

					/*$management = !empty(get_post_meta($pID, 'management', true)) ? get_post_meta($pID, 'management', true) : false;
					$psychology = !empty(get_post_meta($pID, 'psychology', true)) ? get_post_meta($pID, 'psychology', true) : false;
					$nurcing = !empty(get_post_meta($pID, 'nurcing', true)) ? get_post_meta($pID, 'nurcing', true) : false;
					$medical_help = !empty(get_post_meta($pID, 'medical_help', true)) ? get_post_meta($pID, 'medical_help', true) : false;*/

					$facebook = cct_get_member_meta( $pID, 'facebook' );
					$facebook_formatted = cct_get_member_facebook( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
					$twitter = cct_get_member_meta( $pID, 'twitter' );
					$twitter_formatted = cct_get_member_twitter( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
					$googleplus = cct_get_member_meta( $pID, 'googleplus' );
					$googleplus_formatted = cct_get_member_googleplus( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
					$linkedin = cct_get_member_meta( $pID, 'linkedin' );
					$linkedin_formatted = cct_get_member_linkedin( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
					$pinterest = cct_get_member_meta( $pID, 'pinterest' );
					$pinterest_formatted = cct_get_member_pinterest( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
					$instagram = cct_get_member_meta( $pID, 'instagram' );
					$instagram_formatted = cct_get_member_instagram( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );

					$member_position = cct_get_member_meta( $pID, 'position' );

					$member_contacts = ( !empty($address) ) ? '<li class="member-address"><i class="rt-icon icon-location-outline"></i>' . esc_html($address) . '</li>' : '';
					$member_contacts .= ( !empty($phone) ) ? '<li class="member-phone"><i class="rt-icon icon-device-tablet"></i>' . esc_html($phone) . '</li>' : '';
					$member_contacts .= ( !empty($email) ) ? '<li class="member-email"><i class="rt-icon icon-mail2"></i>' . esc_html($email) . '</li>' : '';

					$member_social = ( !empty($facebook) ) ? '<li class="member-facebook">' . $facebook_formatted . '</li>' : '';
					$member_social .= ( !empty($twitter) ) ? '<li class="member-twitter">' . $twitter_formatted . '</li>' : '';
					$member_social .= ( !empty($googleplus) ) ? '<li class="member-googleplus">' . $googleplus_formatted . '</li>' : '';
					$member_social .= ( !empty($linkedin) ) ? '<li class="member-linkedin">' . $linkedin_formatted . '</li>' : '';
					$member_social .= ( !empty($pinterest) ) ? '<li class="member-pinterest">' . $pinterest_formatted . '</li>' : '';
					$member_social .= ( !empty($instagram) ) ? '<li class="member-instagram">' . $instagram_formatted . '</li>' : '';

					$member_skills = array();
					$member_skills_name = array();
					$member_skills[] = ( !empty($skill_1) ) ? $skill_1 : false;
					$member_skills_name[] = ( !empty($skill_name_1) ) ? $skill_name_1 : false;
					$member_skills[] = ( !empty($skill_2) ) ? $skill_2 : false;
					$member_skills_name[] = ( !empty($skill_name_2) ) ? $skill_name_2 : false;
					$member_skills[] = ( !empty($skill_3) ) ? $skill_3 : false;
					$member_skills_name[] = ( !empty($skill_name_3) ) ? $skill_name_3 : false;
					$member_skills[] = ( !empty($skill_4) ) ? $skill_4 : false;
					$member_skills_name[] = ( !empty($skill_name_4) ) ? $skill_name_4 : false;
			?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-content">

						<div class="container">
							<div class="row">

								<div class="col-md-5">
									<div class="row member-row1">
										<?php if(has_post_thumbnail()) : ?>
										<div class="member-thumbnail col-md-12 col-sm-6 col-xs-12">
											<?php the_post_thumbnail('large'); ?>
										</div>
										<?php endif; ?>
										<div class="member-info col-md-12 col-sm-6 col-xs-12">
											<?php the_title('<h3 class="member-title">','</h3>'); ?>
											<?php echo ( ! empty( $member_position ) ) ? '<p class="member-position">' . esc_html( $member_position ) . '</p>' : ''; ?>
											<hr>
											<?php echo ( ! empty( $member_contacts ) ) ? '<ul class="member-contacts">' . $member_contacts . '</ul>' : ''; ?>
											<?php echo ( ! empty( $member_social ) ) ? '<ul class="member-social social-navigation">' . $member_social . '</ul>' : '' ?>
										</div>
									</div>
								</div>

								<div class="col-md-7">
									<div id="member-content-tabs" class="member-content-tabs">
										<!-- Nav tabs -->
										<ul class="nav nav-tabs">
											<li class="active"><a href="#member-content" data-toggle="tab"><?php esc_html_e('Biography','valeo') ?></a></li>
											<li><a href="#member-skills" data-toggle="tab"><?php esc_html_e('Skils','valeo') ?></a></li>
											<li><a href="#message-form" data-toggle="tab"><?php esc_html_e('Send Message','valeo') ?></a></li>
										</ul>
										<!-- Tab panes -->
										<div class="tab-content">
											<div class="tab-pane active" id="member-content"><?php the_content(); ?></div>
											<div class="tab-pane" id="member-skills">
												<?php foreach($member_skills as $i => $skill_val) : ?>
													<?php if($skill_val) : ?>
														<?php echo !empty($member_skills_name[$i]) ? esc_html($member_skills_name[$i]) : '';  ?>
														<div class="progress">
															<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo esc_attr($skill_val); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($skill_val); ?>%">
																<span class="sr-only"><?php echo esc_html($skill_val); ?><?php esc_html_e('Complete (success)', 'valeo'); ?></span>
															</div>
														</div>
													<?php endif; ?>
												<?php endforeach; ?>
											</div>
											<div class="tab-pane" id="message-form">
												<?php echo cct_get_member_contact_form(); ?>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>

					</div>
				</article><?php
				endif;
			endwhile; ?>
			</div>
		</div>
	</main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); ?>
