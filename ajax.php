<?php 

function EnviarComentario()
{
    $comentarista = wp_get_current_commenter();

    //var_dump($comentarista);

    $email_nome_obrigatorio = get_option( 'require_name_email' );

    $comment = $_POST['comment']; 
    $comment_post_ID = $_POST['comment_post_ID']; 
    $comment_parent = $_POST['comment_parent'];   

    
    $user_id = 0;

    $time = current_time('mysql');

    if(is_user_logged_in())
    {
      global $current_user;

      get_currentuserinfo();

     

      $comment_author       = $current_user->display_name; 
      $comment_author_email = $current_user->user_email;
      $comment_author_url   = $current_user->user_url;
      $user_id =$current_user->ID;
      
    }
    else
    {
      $comment_author       = $_POST['author'];
      $comment_author_email = $_POST['email'];
      $comment_author_url   = $_POST['url'];
    }



    if(empty($comment))
    {
      echo '<small><em>Você deve informar algum texto em seu comentário.</em></small>';
      
      $comments = get_comments(array(
      'post_id' => $comment_post_ID,
      'status' => 'approve'
      ));

      wp_list_comments( array( 'callback' => 'shape_comment',
          'style'=> 'ul',          
          'reverse_top_level' => false ), $comments );

      die();
    }
    else
    { 
      $qtdeMinimaCaracteres = intval(esc_attr(get_option('qtdeMinimaCaracteres')));

      $qtdeMaximaCaracteres = intval(esc_attr(get_option('qtdeMaximaCaracteres')));

      if(strlen($comment) < intval($qtdeMinimaCaracteres) | 
            ($qtdeMaximaCaracteres > 0 ? (strlen($comment) > intval($qtdeMaximaCaracteres)):false))
      {
          echo '<small><em>O comentário deve ter no mínimo '.$qtdeMinimaCaracteres.($qtdeMaximaCaracteres > 0 ? (' e no máximo '.$qtdeMaximaCaracteres):'').' caracteres.</em></small>';
      
          $comments = get_comments(array(
          'post_id' => $comment_post_ID,
          'status' => 'approve'
          ));

          wp_list_comments( array( 'callback' => 'shape_comment',
              'style'=> 'ul',          
              'reverse_top_level' => false ), $comments );

          die();
      }

      
    }

    // validação
    if( ($email_nome_obrigatorio == '1') &&(empty($comment_author)|| empty($comment_author_email)))
    {
      echo '<small><em>Você deve informar nome e e-mail</em></small>';

      $comments = get_comments(array(
      'post_id' => $comment_post_ID,
      'status' => 'approve'
      ));

      wp_list_comments( array( 'callback' => 'shape_comment',
          'style'=> 'ul',          
          'reverse_top_level' => false ), $comments );

      die();
    }

    $novo_comentario = array(
        'comment_post_ID' => $comment_post_ID,
        'comment_author' => $comment_author,
        'comment_author_email' => $comment_author_email,
        'comment_author_url' => $comment_author_url,
        'comment_content' => esc_html($comment),
        'comment_type' => '',
        'comment_parent' => $comment_parent,
        'user_id' => $user_id,
        'comment_author_IP' => '127.0.0.1',
        'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
        'comment_date' => $time,
        'comment_approved' => 1,
    );

    $idComentario = wp_insert_comment($novo_comentario);

    if($idComentario > 0)
    {?>
      <script>
        var comentario =  document.getElementById("comment").value = ' ' ;

        var contadorcaracteres =  document.getElementById("contadorcaracteres").innerHTML = ' ' ;
      </script>
    <?php }

    $comments = get_comments(array(
      'post_id' => $comment_post_ID,
      'status' => 'approve'
    ));

    wp_list_comments( array( 'callback' => 'shape_comment',
          'style'=> 'ul',          
          'reverse_top_level' => false ), $comments );

    die();
}

//Adiciona a funcao extra aos hooks ajax do WordPress.
add_action('wp_ajax_EnviarComentario', 'EnviarComentario');
add_action('wp_ajax_nopriv_EnviarComentario', 'EnviarComentario');

function EscreveJavascript()
{ ?>
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<script>

jQuery(function($)
    {
        $.fn.LimparTexto = function()
          {
                this.val('');
                this.focus();
          }

        $.data(document.body, 'ajaxUrl', <?php echo '\''.admin_url("admin-ajax.php").'\''; ?>);

        $('#commentform').submit(function(e) {            

            e.preventDefault();            

            $.ajax( {
              url: $.data(document.body, 'ajaxUrl' ),
              type: 'POST',
              cache: false,
              data: $(this).serialize(),
              success: function(dados) {
                $('.comments-bottom').html( dados );
                
                $('#comment').focus();
              }
            });            
          }); 
    });               
</script>

<?php } 

function ListarComentarios()
{ ?>
  <div class="comments-bottom">

  <?php if ( have_comments() ) : ?>
        
          <h4> <?php echo number_format_i18n( get_comments_number() ).' Comentarios';?></h4>       
          <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through? If so, show navigation ?>
          <nav role="navigation" id="comment-nav-above" class="site-navigation comment-navigation">
              <h1 class="assistive-text"><?php _e( 'Comment navigation', 'shape' ); ?></h1>
              <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'shape' ) ); ?></div>
              <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'shape' ) ); ?></div>
          </nav><!-- #comment-nav-before .site-navigation .comment-navigation -->
          <?php endif; // check for comment navigation ?>
          
          <!-- Inicio da lista -->
          <?php wp_list_comments( array( 'callback' => 'shape_comment',
          'style'=> 'ul' ) );?>
          <!-- Fim da lista -->    
             
          <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through? If so, show navigation ?>
          <nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
              <h1 class="assistive-text"><?php _e( 'Comment navigation', 'shape' ); ?></h1>
              <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'shape' ) ); ?></div>
              <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'shape' ) ); ?></div>
          </nav><!-- #comment-nav-below .site-navigation .comment-navigation -->
          <?php endif; // check for comment navigation ?>   
        
    <?php endif; // have_comments() ?>

    </div>
  
 <?php }
 ?>