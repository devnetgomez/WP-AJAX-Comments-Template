<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to shape_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package Shape
 * @since Shape 1.0
 */


    /*
     * If the current post is protected by a password and
     * the visitor has not yet entered the password we will
     * return early without loading the comments.
     */
    if ( post_password_required() )
        return;

    EscreveJavascript(); 
   
    do_action('template_comentario');

    /*$template_de_comentario_padrao = '<span>Teste de Filtro de Template</span>';

    $template = apply_filters('template_de_comentario', $template_de_comentario_padrao); 

    var_dump($template);*/

    ?>

    <section id="comments" class="comments comments-area">

    <?php EscreveJavascriptContadorCaracteres();    

    $estiloTitulo = esc_attr(get_option('estiloTituloFormulario'));

    $campos = array();

    $campo_comentario = '';

    switch ($estiloTitulo) {
      case 'Label':

        $campos = array(

        'author' => '<label>
        <input type="text" name="author" id="author" value="' . esc_attr( $commenter['comment_author'] ) .'">  Nome '.( $req ? '<span>*</span>' : '' ).'</label>',

        'email' => '<label>
        <input type="email" name="email" id="email" placeholder="seuemail@email.com.br" value="' . esc_attr( $commenter['comment_author_email'] ) .'">  E-mail '.( $req ? '<span>*</span>' : '' ).'</label>',

        'url' => '<label>
        <input type="text" name="url" id="url" value="' . esc_attr( $commenter['comment_author_url'] ) .'">  Website '.( $req ? '<span>*</span>' : '' ).'</label>') ;

        $campo_comentario = '<p class="comment-form-comment"><h2>Mensagem</h2><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" ></textarea> <span class="textarea-required" >*</span></p>';

        break;
      
     case 'PlaceHolder':

        $campos = array(

        'author' => '<input type="text" name="author" 
          placeholder="Autor"   '. 
          ( $req ? 'class="input-required"' : '' ).' id="author" value="' . esc_attr( $commenter['comment_author'] ) .'">'.( $req ? '<span>*</span>' : '' ),

        'email' => '<input type="email" name="email" id="email"  '. 
          ( $req ? 'class="input-required"' : '' ).' placeholder="seuemail@email.com.br" value="' . esc_attr( $commenter['comment_author_email'] ) .'">'.( $req ? '<span>*</span>' : '' ),

        'url' => '<input type="text" name="url" id="url" '. 
          ( $req ? 'class="input-required"' : '' ).' placeholder="http://" value="' . esc_attr( $commenter['comment_author_url'] ) .'">'.( $req ? '<span>*</span>' : '' ));

        $campo_comentario = '<p class="comment-form-comment"><textarea 
            id="comment" 
            placeholder="Mensagem"
            name="comment" 
            cols="45" 
            rows="8" 
            aria-required="true" ></textarea><span class="textarea-required">*</span></p>';

        break;
    }
    


      $parametros = array(
        'label_submit' =>'Enviar',
        'comment_field' =>  $campo_comentario,
        'logged_in_as'=>
        '<p class="logged-in-as">' . sprintf('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' , admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',


        'comment_notes_after'=>'<input type="hidden" name="action" value="EnviarComentario" />
        <div id="contadorcaracteres"></div>',

        'fields' => $campos);

        comment_form($parametros); 

        ListarComentarios();

          // If comments are closed and there are comments, let's leave a little note, shall we?
          if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
      ?>
          <p class="nocomments"><?php _e( 'Comments are closed.', 'shape' ); ?></p>
      <?php endif; ?>       
   
  </section>