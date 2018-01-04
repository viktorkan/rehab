<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 */
get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">
		<div class="post-container">

			<div class="container">

				<div class="fw-heading fw-heading-h3 fw-heading-center fw-heading-w-subtitle team-fw-heading">
					<h3 class="fw-special-title"><?php echo cct_get_team_title(); ?></h3>
					<div class="fw-special-subtitle"><?php echo cct_get_team_description(); ?></div>
				</div>

			<div class="site__row member-team-wrapper archive">
			<?php if ( have_posts() ) :
				while ( have_posts() ) : the_post();

					$before = '';
					$after = '';

					$pID = get_the_ID();

					$address = cct_get_member_meta( $pID, 'address' );
					$address_formatted = cct_get_member_address( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
					$phone = cct_get_member_meta( $pID, 'phone' );
					$phone_formatted = cct_get_member_phone( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
					$email = cct_get_member_meta( $pID, 'email' );
					$email_formatted = cct_get_member_phone( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );

					$social_quote = cct_get_member_meta( get_the_ID(), 'social_quote' );
					$social_quote_formatted = cct_get_member_social_quote( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
					$facebook = cct_get_member_meta( get_the_ID(), 'facebook' );
					$facebook_formatted = cct_get_member_facebook( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
					$twitter = cct_get_member_meta( get_the_ID(), 'twitter' );
					$twitter_formatted = cct_get_member_twitter( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
					$googleplus = cct_get_member_meta( get_the_ID(), 'googleplus' );
					$googleplus_formatted = cct_get_member_googleplus( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
					$linkedin = cct_get_member_meta( get_the_ID(), 'linkedin' );
					$linkedin_formatted = cct_get_member_linkedin( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
					$pinterest = cct_get_member_meta( get_the_ID(), 'pinterest' );
					$pinterest_formatted = cct_get_member_pinterest( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );
					$instagram = cct_get_member_meta( get_the_ID(), 'instagram' );
					$instagram_formatted = cct_get_member_instagram( array( 'text' => '%s', 'before' => $before, 'after' => $after ) );

					//var_dump(get_post_meta(get_the_ID()));

					$member_position = cct_get_member_meta( get_the_ID(), 'position' );
					$member_short_desc = cct_get_member_meta( get_the_ID(), 'short_desc' );

					$social_quote .= ( !empty($social_quote) ) ? $social_quote_formatted : '';

					$member_contacts = ( !empty($address) ) ? '<li class="member-address"><i class="rt-icon icon-location-outline"></i>' . esc_html($address) . '</li>' : '';
					$member_contacts .= ( !empty($phone) ) ? '<li class="member-phone"><i class="rt-icon icon-device-tablet"></i>' . esc_html($phone) . '</li>' : '';
					$member_contacts .= ( !empty($email) ) ? '<li class="member-email"><i class="rt-icon icon-mail2"></i>' . esc_html($email) . '</li>' : '';

					$member_social = ( !empty($facebook) ) ? '<li class="member-facebook">' . $facebook_formatted . '</li>' : '';
					$member_social .= ( !empty($twitter) ) ? '<li class="member-twitter">' . $twitter_formatted . '</li>' : '';
					$member_social .= ( !empty($googleplus) ) ? '<li class="member-googleplus">' . $googleplus_formatted . '</li>' : '';
					$member_social .= ( !empty($linkedin) ) ? '<li class="member-linkedin">' . $linkedin_formatted . '</li>' : '';
					$member_social .= ( !empty($pinterest) ) ? '<li class="member-pinterest">' . $pinterest_formatted . '</li>' : '';
					$member_social .= ( !empty($instagram) ) ? '<li class="member-instagram">' . $instagram_formatted . '</li>' : '';

					?>
					<article id="post-<?php the_ID(); ?>" class="col-md-4">
						<div class="fw-team list-item">

							<div class="fw-team-image">
								<?php valeo_post_thumbnail( array(
									'print'          => true,
									'background'     => false,
									'no_url'         => true,
									'thumbnail_class' => '',
									'thumbnail_size' => 'large'
								) ) ?>
							</div>

							<div class="fw-team-inner">
								<div class="fw-team-name">
									<?php the_title('<h3><a href="'.get_the_permalink().'" title="'.get_the_title().'">', '</a></h3>') ?>
									<?php echo (!empty($member_position)) ? '<span>' .$member_position. '</span>' : '' ?>
									<div class="helper"></div>
								</div>
								<div class="fw-team-text">
									<p><?php
									//the_excerpt();
										echo ( ! empty( $member_short_desc ) ) ? '' . $member_short_desc . '' : ''
									?></p>
								</div>
								<hr>
								<div class="fw-team-social">
									<?php echo ( ! empty( $social_quote ) ) ? '<div class="social-quote">' . $social_quote . '</div>' : '' ?>
									<?php echo ( ! empty( $member_contacts ) ) ? '<ul class="member-contacts">' . $member_contacts . '</ul>' : ''; ?>
									<?php echo ( ! empty( $member_social ) ) ? '<ul class="member-social social-navigation">' . $member_social . '</ul>' : '' ?>
								</div>
							</div>

						</div>
					</article>
				<?php endwhile;
					// If no content, include the "No posts found" template.
				else :
					get_template_part( 'partials/content', 'none' );
				endif;
				?>
			</div>

			</div>

		</div>

	</main><!-- .site-main -->


</div><!-- .content-area -->

<?php get_footer(); ?>
