<?php 

add_action( 'admin_init', 'registrar_configuracoes_comentarios' );
add_action( 'admin_menu', 'AdicionaSubMenuComentario' );


function AdicionaSubMenuComentario()
{
  add_comments_page( 'Validação', 'Configurações', 'moderate_comments', 'configuracao-comentario', 'PaginaConfiguracaoMenu');
}

function registrar_configuracoes_comentarios() { 
  register_setting( 'configuracao_comentarios', 'qtdeMinimaCaracteres' );
  register_setting( 'configuracao_comentarios', 'qtdeMaximaCaracteres' );
  register_setting( 'configuracao_comentarios', 'templateFormulario' );

  register_setting( 'configuracao_comentarios', 'estiloTituloFormulario' );

  
}

function PaginaConfiguracaoMenu()
{?>
  <script type="text/javascript">
  
  </script>

  <div class="wrap">
  <?php screen_icon(); ?>
  <h2>Validação adicional do comentário</h2>
   <form method="post" action="options.php">
    <?php settings_fields( 'configuracao_comentarios' ); ?>
    
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Tamanho do comentário</th>
        <td>
          <fieldset>
            <legend></legend>
            <label for="qtdeMinimaCaracteres">Quantidade mínima de caracteres</label>
            <input type="text"  style="width:100px;" name="qtdeMinimaCaracteres" value="<?php echo esc_attr(get_option('qtdeMinimaCaracteres')); ?>" />
            <br/>
            <label for="qtdeMinimaCaracteres">Quantidade máxima de caracteres</label>
            <input type="text" style="width:100px;" name="qtdeMaximaCaracteres" value="<?php echo esc_attr(get_option('qtdeMaximaCaracteres')); ?>" />
            <small>
              <em>Se não houver preenchimento, será ilimitado.</em>
            </small>
          </fieldset>
          </td>
        </tr> 

        <tr valign="top">
        <th scope="row">Formulário de Envio</th>
        <td>
          <fieldset>                    
            <label for="estiloTituloFormulario">Exibir titulos como</label>
            <?php $listaEstilosTitulo = array('PlaceHolder','Label'); ?>
            <ul>
              <?php foreach ($listaEstilosTitulo as $estilo){ ?>

                <li>
                  <input type="radio" name="estiloTituloFormulario" value="<?php echo $estilo;?>"

                  <?php echo (esc_attr(get_option('estiloTituloFormulario')) == $estilo ? 'checked':''); ?>

                  > <?php echo $estilo;?>
                </li>


              <?php } ?>                      
          </fieldset>
          </td>
        </tr> 
    </table>    
    <?php submit_button(); ?>
</form>
</div>
<?php } ?>