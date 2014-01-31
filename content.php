<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" target="_blank" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		</header><!-- .entry-header -->

		<?php if ( is_sticky() ){ ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php } ?>

		<footer class="entry-meta">
			<?php $show_sep = false; ?>

			<?php if ( is_object_in_taxonomy( get_post_type(), 'post_tag' ) ) : // Hide tag text when not supported ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'twentyeleven' ) );
				if ( $tags_list ):
				if ( $show_sep ) : ?>
			<span class="sep"> | </span>
				<?php endif; // End if $show_sep ?>
			<span class="tag-links">
				<?php //printf( __( '<span class="%1$s">Etiquetas:</span> %2$s', 'twentyeleven' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
				$show_sep = true; ?>
			</span>
			<?php endif; // End if $tags_list ?>
			<?php endif; // End if is_object_in_taxonomy( get_post_type(), 'post_tag' ) ?>

<?php
        $currtags_array = get_curr_tags_array(); //etiquetas activas
	$posttags = get_the_tags();
	if ( empty( $posttags ) || is_wp_error( $tags ) )
                return;
	$greentags = array();
	$redtags = array();
        foreach ( $posttags as $key => $tag ) {
                $tagarr = $currtags_array;
                $dkey = array_search($tag->term_id, $tagarr);
                if ($dkey!== FALSE) { 
                        unset($tagarr[$dkey]); //se saca la etiqueta, si activa; para preparar el $tag[$key]->link que gatilla la próxima iteracion.
			 $greentags[] = $tag; // pasa a ser "activa"
                }
                else {
                        $tagarr = array_merge($tagarr, array($tag->term_id)); //así que este array tiene las activas más la agregada
			 $redtags[] = $tag; // pasa a ser "inactiva"
                }

        $taglist = implode(",", $tagarr);
        $link = add_query_arg( "tags", $taglist );
                  
                if ( is_wp_error( $link ) )
                        return false;

                $posttags[ $key ]->link = $link;
                $posttags[ $key ]->id = $tag->term_id;
                $posttags[ $key ]->tagarr = $tagarr;
        }
       $cutting = wp_generate_tag_cloud( $redtags,"smallest=10&largest=10"); 
//echo 'Etiquetas Inactivas ';
echo 'ETIQUETAS INACTIVAS ';
echo $cutting;

?>

			<?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post-<?php the_ID(); ?> -->
