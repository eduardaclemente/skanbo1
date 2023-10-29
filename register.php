<?php
require_once('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifica se o usuário já existe
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() > 0) {
        echo "Este usuário já existe. Escolha outro nome de usuário.";
    } else {
        // Insere o novo usuário no banco de dados
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $hashed_password]);
        header("Location: login.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
    <style>
        /* Estilização para a página de registro */
        body {
            background-color: #f0f0ff; /* Cor de fundo azul claro */
            font-family: Arial, sans-serif;
        }

        h2 {
            color: #000080; /* Cor do título azul escuro */
            text-align: center;
        }

        form {
            width: 300px;
            margin: 0 auto;
            background-color: #ffffff; /* Fundo do formulário branco */
            padding: 20px;
            border: 1px solid #ccc; /* Borda cinza */
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #000080; /* Cor do texto azul escuro */
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc; /* Borda cinza */
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #000080; /* Cor de fundo do botão azul escuro */
            color: #fff; /* Cor do texto do botão branco */
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0000cc; /* Cor de fundo do botão azul mais escuro no hover */
        }

        a {
            color: #000080; /* Cor do link azul escuro */
        }

        p {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Registro</h2>
    <form method="post" action="register.php">
        <div>
            <label for="username">Nome de usuário:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label for="password">Senha:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <input type="submit" value="Registrar">
        </div>
    </form>
</body>
</html>
