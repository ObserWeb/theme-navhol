
<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		/* Decide si es EDITORIAL o no */
		$ed = 0;
		$posttags = get_the_tags();
		if ($posttags) {
			foreach($posttags as $tag) {
			if($tag->name == ':Editorial') $ed = 1;
			}
		}
if($ed) { ?> 
<h1 style="color: green;" class="entry-title"><?php the_title(); ?></h1> 
<?php
} else {
			/* Get the url from the first link in the content */
			$content = get_the_content();
			$ret = NULL;
			$r = explode("href=", $content,2);
			if (strlen($r[0])<200){
				$r = explode(">", $r[1],2);
					if (isset($r[1])){
					$ret = $r[0];
				} 
			}
			if (!$ret){
				echo "falta URL inicial";
			}?> 
<h1 class="entry-title"><a href=<?php echo $ret ; ?> title="este mismo titulo" rel="bookmark"><?php the_title(); ?></a></h1> 
<?php
}

$etnombres = array();
foreach($posttags as $tag) { $etnombres[] =$tag->name; };
$etlist = implode(", ", $etnombres);
echo "ETIQUETAS:  <font color='blue'> $etlist  </font>";
?> <br> <?php
echo "<font color='#095514'> Lo que sigue es sólo una introducción. Para leer el artículo original, pinche el título. </font>";

		if ( 'post' == get_post_type() ) : ?><br><br>
		<div class="entry-meta">
			<?php twentyeleven_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php   
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'twentyeleven' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'twentyeleven' ) );
			if ( '' != $tag_list ) {
				$utility_text = __( 'Etiquetas: %2$s. ', 'twentyeleven' );
			} else {
				$utility_text = __( 'Este enlace no está etiquetado.', 'twentyeleven' );
			}

/*			printf(
				$utility_text,
				$categories_list,
				$tag_list,
				esc_url( get_permalink() ),
				the_title_attribute( 'echo=0' ),
				get_the_author(),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
			);*/
		?>
		<?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>

		<?php if ( get_the_author_meta( 'description' ) && ( ! function_exists( 'is_multi_author' ) || is_multi_author() ) ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries ?>
		<div id="author-info">
			<div id="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyeleven_author_bio_avatar_size', 68 ) ); ?>
			</div><!-- #author-avatar -->
			<div id="author-description">
				<h2><?php printf( __( 'About %s', 'twentyeleven' ), get_the_author() ); ?></h2>
				<?php the_author_meta( 'description' ); ?>
				<div id="author-link">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
						<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentyeleven' ), get_the_author() ); ?>
					</a>
				</div><!-- #author-link	-->
			</div><!-- #author-description -->
		</div><!-- #entry-author-info -->
		<?php endif; ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
