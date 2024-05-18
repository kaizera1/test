<?php
include('conexao.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["senha"])) {
        echo 'Por favor, preencha todos os campos';
    } else {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    $sql = "INSERT INTO usuarios (name, email, senha) VALUES (?,?,?)";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("sss", $name, $email, $senha); 

    if($stmt->execute()) {
        echo 'Usuário cadastrado com sucesso!';
    } else {
        echo "Erro: " . $sql . "<br>" . $mysqli->error;
    }
    $stmt->close();
    }
}
$mysqli->close();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro</title>
</head>

<body>

<h1>Cadastrar</h1>
    <form action="" method="POST">
        <p>
            <label>Nome</label>
            <input type="text" name="name">
        </p>
        <p>
            <label>E-mail</label>
            <input type="text" name="email">
        </p>
        <p>
            <label>Senha</label>
            <input type="password" name="senha">
        </p>
        <p>
            <button type="submit">Cadastrar</button>
        </p>
    </form>
    <a href="index.php">Faça login</a>
</body>
</html>