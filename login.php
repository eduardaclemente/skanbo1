<?php
require_once('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verifica se o usuário existe no banco de dados
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch();
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: index.php");
        } else {
            echo "Senha incorreta. Tente novamente.";
        }
    } else {
        echo "Usuário não encontrado. Registre-se primeiro.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
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
            text-align: center;
        }

        p {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <div>
            <label for="username">Nome de usuário:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label for="password">Senha:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <input type="submit" value="Login">
        </div>
    </form>
    <p>Não tem uma conta? <a href="register.php">Registre-se aqui</a></p>
</body>
</html>
