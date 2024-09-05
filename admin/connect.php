<?php

define('HOST', 'localhost');

define('DB', 'site');

define('USER', 'root');

define('PASS', '');


class connect
{

  function select($sql)
  {
    try {
      $cnx = new PDO('mysql:host=' . HOST . ';dbname=' . DB . '', USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      $con = $cnx->prepare($sql);
      $con->execute();
      return $con->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "Ops! desculpe, algo deu errado, por favor tente mais tarde:<br>";
      if ($_SESSION['debug'] == true) {
        echo $e->getMessage();
      }
      exit;
    }
    $cnx = null;
  }

  function selectFor($sql)
  {
    try {
      $cnx = new PDO('mysql:host=' . HOST . ';dbname=' . DB . '', USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      $con = $cnx->prepare($sql);
      $con->execute();
      return $con->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "Ops! desculpe,  algo deu errado, por favor tente mais tarde:<br>";
      if ($_SESSION['debug'] == true) {
        echo $e->getMessage();
      }
      exit;
    }
    $cnx = null;
  }


  public function selectDinamico($tabela, $array, $order)
  {
    $i = 0;
    $query = "SELECT * FROM " . $tabela . " ";
    foreach ($array as $k => $v) {
      if ($v && $i == 0) {
        $query .= " WHERE ";
        $query .= $k . " = '" . $v . "'";
      }
      if ($v && $i > 1) {
        $query .= " AND " . $k . " = '" . $v . "'";
      }
      $i++;
    }

    $query .= " " . $order;
    return $query;
  }

  function delete($query)
  {
    $cnx = new PDO('mysql:host=' . HOST . ';dbname=' . DB . '', USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $con = $cnx->prepare($query);
    if (!$con->execute()) {
      $erro = $con->errorInfo();
      return array('msg' => $erro['2'], "codErro" => $erro['1']);
    }
    return "Excluído com Sucesso!";
    $cnx = null;
  }

  function insert($tabela, $dados)
  {
    $cnx = new PDO('mysql:host=' . HOST . ';dbname=' . DB . '', USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $arrCampo = array_keys($dados);
    $arrValores = array_values($dados);
    $numCampo = count($arrCampo);
    $numValores = count($arrValores);

    if ($numCampo == $numValores) {
      $SQL = "INSERT INTO " . $tabela . " (";
      foreach ($arrCampo as $campo) {
        $SQL .= "$campo, ";
      }
      $SQL = substr_replace($SQL, ")", -2, 1);
      $SQL .= " VALUES (";
      foreach ($arrValores as $valores) {
        $SQL .= "'" . $valores . "', ";
      }
      $SQL = substr_replace($SQL, ")", -2, 1);
    }
    $con = $cnx->prepare($SQL);
    if (!$con->execute()) {
      $erro = $con->errorInfo();
      return array('msg' => $erro['2'], "codErro" => $erro['1']);
    }
    return "Inserido com Sucesso!";
    $cnx = null;
  }

  function update($tabela, $dados, $condicao)
  {
    $cnx = new PDO('mysql:host=' . HOST . ';dbname=' . DB . '', USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $arrCampo = array_keys($dados);
    $arrValores = array_values($dados);
    $c = count($arrCampo);
    $v = count($arrValores);

    if ($c == $v) {
      $SQL = "UPDATE " . $tabela . " SET ";

      for ($i = 0; $i < $c - 1; $i++) {
        $SQL .= "$arrCampo[$i] = '$arrValores[$i]', ";
      }
      $u = $c - 1;
      $SQL .= "$arrCampo[$u] = '$arrValores[$u]' ";

      $SQL .= "WHERE $condicao;";
    }
    $con = $cnx->prepare($SQL);
    if (!$con->execute()) {
      $erro = $con->errorInfo();
      return array("msg" => $erro['2'], "codErro" => $erro['1']);
    }
    return "Alterado com Sucesso!";
    $cnx = null;
  }
}
