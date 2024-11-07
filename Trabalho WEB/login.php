<?php
// Iniciar sessão
session_start();

// Configuração do banco de dados
$servername = "localhost";
$username = "root"; // No XAMPP, o nome de usuário padrão é 'root'
$password = ""; // A senha padrão no XAMPP é em branco
$dbname = "gourmet_db"; // O nome do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['password'];

    // Consultar o banco de dados para verificar o usuário
    $stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $nome, $senha_armazenada);

    if ($stmt->fetch()) {
        // Verificar se a senha está correta
        if (password_verify($senha, $senha_armazenada)) {
            // Login bem-sucedido
            $_SESSION['id'] = $id;
            $_SESSION['nome'] = $nome;
            $_SESSION['email'] = $email;
            header("Location: index.php"); // Redirecionar para a página principal
            exit;
        } else {
            echo "Senha incorreta!";
        }
    } else {
        echo "Usuário não encontrado!";
    }

    // Fechar a declaração e a conexão
    $stmt->close();
    $conn->close();
}
?>
