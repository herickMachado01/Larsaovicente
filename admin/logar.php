
<?php

session_start();

// $login = isset($_POST['login']) ? $_POST['login'] : '';
// $senha = isset($_POST['senha']) ? $_POST['senha'] : '';

// a partir do PHP 7.0, você pode usar o operador de coalescência nula (??), 
// que é uma maneira mais concisa de fazer essa verificação:
$login = $_POST['login'] ?? '';
$senha = $_POST['senha'] ?? '';

include_once "./connect.php";
include_once "./helpers.php";

$sql = new connect();

$query = "SELECT login, senha from usuarios WHERE login = '{$login}' ";

$loginDb = $sql->select($query);


if (isset($loginDb) && $loginDb != false) {
    $senhaDb = Helpers::decripta($loginDb['senha']);    
    if ($senha == $senhaDb) {
        $_SESSION['login'] = $login;
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Senha Incorreta.']);
    }
}else{
    echo json_encode(['success' => false, 'message' => 'Login Incorreto.']);
}
?>
