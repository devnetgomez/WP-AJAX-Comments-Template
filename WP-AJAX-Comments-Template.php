<?php 
/*
* Plugin Name: Comentários do Wordpress
* Plugin URL: http://mycodewith.wordpress.com
* Description: Este plugin Wordpress sobscreve o template padrão de comentários, através de filtros permitindo adicionar validação de tamanho do comentário, bem como definir o estilo do formulário de envio e listagem de comentários. Utiliza PHP, AJAX e jQuery.
* Author: Janynne Gomes
* Version: 1.0
* Author URL: http://mycodewith.wordpress.com
*/


require_once dirname( __FILE__ ) . '/submenu.php';
require_once dirname( __FILE__ ) . '/shape.php';
require_once dirname( __FILE__ ) . '/ajax.php';
require_once dirname( __FILE__ ) . '/contador-carcateres.php';


function template_personalizado_comentario( $comment_template ) 
{
     
    return dirname(__FILE__) . '/comments.php';
}

add_filter( "comments_template", "template_personalizado_comentario" );


add_filter( 'comment_reply_link', 'link_resposta_comentario',10,4);

function link_resposta_comentario($link, $options, $comment, $post) { 
   
   $link = '<a class="comment-reply-link reply" href="'.get_permalink($post->ID).'?replytocom='.$comment->comment_ID.'#comment-form-comment" > <span class="reply-icon"></span> Responder</a>';

   //$link = str_replace('>Responder', '> <span class="reply-icon"></span> Responder', $link); 
   return $link;
}?>