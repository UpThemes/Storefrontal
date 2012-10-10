<?php

// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) {
	?> <p><?php _e("This post is password protected. Enter the password to view comments.","storefrontal"); ?></p> <?php
	return;
}
	
function theme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	
	<li>
		<div <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
			<?php echo get_avatar( $comment, 48 ); ?>
			<p class="comment-meta"><?php comment_date('F d, Y'); ?> at <?php comment_time('g:i a'); ?>, <?php comment_author_link(); ?> said:</p>
			<?php if ($comment->comment_approved == '0') : ?>
			<p><?php _e("Your comment is awaiting moderation.","storefrontal"); ?></p>
			<?php else: ?>
			<?php comment_text(); ?>
			<?php endif; ?>
			
			<?php
				comment_reply_link(array_merge( $args, array(
					'reply_text' => __("Reply","storefrontal"),
					'before' => '<p>',
					'after' => '</p>',
					'depth' => $depth,
					'max_depth' => $args['max_depth']
				))); ?>
		</div>
	<?php }
	
	function theme_comment_end() { ?>
		</li>
	<?php }
?>

<?php if ( have_comments() ) : ?>

<div class="section comments" id="comments">

	<h4><?php comments_number( __("No Responses","storefrontal"), __("One Response","storefrontal"), __("% Responses","storefrontal") ); ?> <?php _e("to","storefrontal"); ?> &#8220;<?php the_title(); ?>&#8221;</h4>

	<ol class="commentlist">
		<?php wp_list_comments(array(
			'callback' => 'theme_comment',
			'end-callback' => 'theme_comment_end'
			)); ?>
	</ol>

	<div class="navigation">
		<div class="next"><?php previous_comments_link(__("&laquo; Older Comments","storefrontal")) ?></div>
		<div class="prev"><?php next_comments_link(__("Newer Comments &raquo;","storefrontal")) ?></div>
	</div>

</div>

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p><?php _e("Comments are closed.","storefrontal"); ?></p>

	<?php endif; ?>
	
<?php endif; ?>


<?php if ( comments_open() ) : ?>

<div id="respond">
	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" name="commentform" id="commentform" class="form-holder">
		<h4><?php comment_form_title( __("Leave a Reply","storefrontal"), __("Leave a Reply to %s","storefrontal") ); ?></h4>
		<div class="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></div>
	
		<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
		<p><?php echo str_replace( "%s",wp_login_url( get_permalink() ), __('You must be <a href="%s">logged in</a> to post a comment.','storefrontal') ); ?></p>
		<?php else : ?>
		
		<?php if ( is_user_logged_in() ) : ?>

		<p><?php _e("Logged in as","storefrontal"); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e("Log out &raquo;","storefrontal"); ?></a></p>

		<?php else : ?>
		<div class="row">
			<label for="author"><?php _e("Name","storefrontal"); ?></label>
			<div class="text-holder">
				<input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" />
			</div>
		</div>
		<div class="row">
			<label for="email"><?php _e("E-Mail (will not be published)","storefrontal"); ?></label>
			<div class="text-holder">
				<input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" />
			</div>
		</div>
		<div class="row">
			<label for="url"><?php _e("Website","storefrontal"); ?></label>
			<div class="text-holder">
				<input type="text" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" />
			</div>
		</div>
		<?php endif; ?>
		<div class="row">
			<label for="comment"><?php _e("Comment","storefrontal"); ?></label>
			<textarea name="comment" id="comment" cols="50" rows="10"></textarea>
		</div>
		<div class="row">
			<a href="#" onclick="commentform.submit();return false;" class="btn-add"><span><?php _e("Submit Comment","storefrontal"); ?></span></a>
		</div>
		<?php
			comment_id_fields();
			do_action('comment_form', $post->ID);
		?>
		
		<?php endif; ?>

	</form>
</div>

<?php endif; ?>