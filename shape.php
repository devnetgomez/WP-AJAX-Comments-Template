<?php 
if ( ! function_exists( 'shape_comment' ) ) :

function shape_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;   

    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
        default : ?>

    <div class="comment-item <?php echo ($depth > 1 ? 'reply':'');?>">

        <?php if($depth > 1) {?>
            <div class="reply-indicator"></div>
        <?php }  ?>

        <figure>
            <?php echo get_avatar( $comment, 70 ); ?>
        </figure>

        <div class="comment-item-shape-bg"></div>
        <div class="comment-item-shape"></div>
        <div class="comment-item-container">            
            <a href="#"><?php echo get_comment_author_link($comment->comment_ID);?></a>

            <time>
                <?php printf( __( '%1$s às %2$s', 'shape' ), get_comment_date('d M y'), get_comment_time( 'H:i' ) ); ?>
                    
                    <?php edit_comment_link( __( '- Editar', 'shape' ), ' ' );
                    ?></time>

            <?php comment_text(); ?>
        </div>

        <section class="social-bar">
            <?php comment_reply_link( array_merge( $args, 
                array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        </section>
    </div>

 <?php
  break;
    
endswitch ;
}

endif; ?>