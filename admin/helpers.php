<?php
require_once ("connect.php");
/**
 * Helpers [TIPO]
 *
 * @author Anderson Donaire - MASTER WEBS
 */
class Helpers extends connect {

    public static function encripta($string) {
        $result = '';
        $key = '28102005';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keychar));
            $result .= $char;
        }
        return base64_encode($result);
    }

    public static function decripta($string) {
        $result = '';
        $key = '28102005';
        $string = base64_decode($string);
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) - ord($keychar));
            $result .= $char;
        }
        return $result;
    }


/**
 * Exibe um modal de alerta com título, mensagem, classe de estilo e botões opcionais.
 *
 * Esta função gera um modal utilizando o Bootstrap 4.5.2 para exibir uma mensagem de alerta
 * ao usuário. O modal pode conter um título, uma mensagem, e pode ser estilizado com diferentes
 * classes de Bootstrap, como 'success', 'danger', 'warning', etc. Além disso, permite a inclusão
 * de botões personalizados no rodapé do modal.
 *
 * @param string|null $titulo O título do modal. Se não for fornecido, o título será nulo.
 * @param string $mensagem A mensagem de alerta que será exibida no corpo do modal.
 * @param string $classe A classe de Bootstrap que será aplicada ao modal para estilização. 
 *                       O valor padrão é 'success'.
 * @param array|null $arrBt Um array opcional de botões a serem exibidos no rodapé do modal. 
 *                          Cada botão deve ser um array associativo com as seguintes chaves:
 *                          - 'link' (string): O link de destino do botão.
 *                          - 'class' (string): A classe de estilo Bootstrap a ser aplicada ao botão.
 *                          - 'nome' (string): O texto exibido no botão.
 *
 * @return void
 */
public static function alerta($titulo=null, $mensagem="", $classe='success', $arrBt = null) {

  $html = "
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          var myModal = new bootstrap.Modal(document.getElementById('modalAlerta'));
          myModal.show();
        });
      </script>
      <div class=\"modal fade\" id=\"modalAlerta\" tabindex=\"-1\" aria-labelledby=\"modalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\" role=\"document\">
          <div class=\"modal-content\">
            <div class=\"modal-header\">
              <h5 class=\"modal-title\" id=\"modalLabel\">{$titulo}</h5>
              <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body alert alert-{$classe}\">
              {$mensagem}
            </div>
            <div class=\"modal-footer\">";

  if ($arrBt == null) {
      $html .= "<a href=\"javascript:history.go(-1)\" class=\"btn btn-primary\">Voltar</a>";
  } else {
      foreach ($arrBt as $bt) {
          $html .= "<a href=\"{$bt['link']}\" class=\"btn {$bt['class']}\">{$bt['nome']}</a>";
      }
  }

  $html .= " </div>
          </div>
        </div>
      </div>";
  echo $html;
}

public static function alertaErro($mensagem, $urlVolta = null) {

  $volta = $urlVolta ? $urlVolta : "javascript:history.go(-1)";

  echo "
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          var myModal = new bootstrap.Modal(document.getElementById('modalErro'));
          myModal.show();
        });
      </script>
      <div class=\"modal fade\" id=\"modalErro\" tabindex=\"-1\" aria-labelledby=\"modalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\" role=\"document\">
          <div class=\"modal-content\">
            <div class=\"modal-header\">
              <h5 class=\"modal-title\" id=\"modalLabel\">Erro!</h5>
              <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body alert alert-danger\">
              {$mensagem}
            </div>
            <div class=\"modal-footer\">
              <a href=\"{$volta}\" class=\"btn btn-primary\">Voltar</a>
            </div>
          </div>
        </div>
      </div>";
  exit();
}

public static function alertaSucesso($mensagem, $urlVolta = null) {
  $volta = $urlVolta ? $urlVolta : "javascript:history.go(-1)";

  $html = "
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          var myModal = new bootstrap.Modal(document.getElementById('modalSucesso'));
          myModal.show();
        });
      </script>
      <div class=\"modal fade\" id=\"modalSucesso\" tabindex=\"-1\" aria-labelledby=\"modalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\" role=\"document\">
          <div class=\"modal-content\">
            <div class=\"modal-header\">
              <h5 class=\"modal-title\" id=\"modalLabel\">Sucesso!</h5>
              <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body alert alert-success\">
              {$mensagem}
            </div>
            <div class=\"modal-footer\">";

  if ($urlVolta != null) {
      $html .= "<button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Fechar e ficar</button>";
      $html .= "<a href=\"{$volta}\" class=\"btn btn-primary\">Voltar</a>";
  } else {
      $html .= "<button type=\"button\" class=\"btn btn-secondary\" data-bs-dismiss=\"modal\">Fechar</button>";
  }

  $html .= "
            </div>
          </div>
        </div>
      </div>";
  echo $html;
}

public static function alertaConfirma($mensagem, $urlSim, $urlNao) {

  echo "
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          var myModal = new bootstrap.Modal(document.getElementById('modalConfirma'));
          myModal.show();
        });
      </script>
      <div class=\"modal fade\" id=\"modalConfirma\" tabindex=\"-1\" aria-labelledby=\"modalLabel\" aria-hidden=\"true\">
        <div class=\"modal-dialog\" role=\"document\">
          <div class=\"modal-content\">
            <div class=\"modal-header\">
              <h5 class=\"modal-title\" id=\"modalLabel\">Confirmação!</h5>
              <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
            </div>
            <div class=\"modal-body\">
              {$mensagem}
            </div>
            <div class=\"modal-footer\">
              <a href=\"{$urlSim}\" class=\"btn btn-success\">Sim</a>
              <a href=\"{$urlNao}\" class=\"btn btn-danger\">Não</a>
            </div>
          </div>
        </div>
      </div>";
  exit();
}

  

  public static function tiraAcento(string $string): string {
    // Substituição de acentos e caracteres especiais por suas versões simples.
    $ac = [
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'AE', 'Ç'=>'C',
        'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I',
        'Ð'=>'D', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O',
        'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'ss', 'à'=>'a',
        'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'ae', 'ç'=>'c', 'è'=>'e',
        'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'d',
        'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u',
        'ú'=>'u', 'û'=>'u', 'ü'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
        ' '=>'_', '+' => '_', '%' => '', '&' => 'e', '/' => '_', 'ª' => 'a', 'º' => 'o',
        '\'' => '', '’' => '', '´' => '', '`' => '', '^' => ''
    ];

    // Remove os espaços em branco no início e no final da string.
    $string = trim($string);
    
    // Transliteração dos caracteres especiais e acentuados.
    $string = strtr($string, $ac);

    // Convertendo a string para minúsculas usando multibyte.
    $string = mb_strtolower($string, 'UTF-8');

    return $string;
}


    public static function getProxId($tabela) {
//        include_once $_SESSION['dir'] . './set/config.php';
//        $sql = new connect();
        $proxId = parent::select("SHOW TABLE STATUS LIKE '{$tabela}'");
        return $proxId['Auto_increment'];
    }


}
