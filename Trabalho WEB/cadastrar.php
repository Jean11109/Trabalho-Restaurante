<?php
// Configuração do banco de dados
$servername = "localhost";
$username = "root";  // No XAMPP, o nome de usuário padrão é 'root'
$password = "";      // A senha padrão no XAMPP é em branco
$dbname = "gourmet_db";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Validar se as senhas coincidem
    if ($senha !== $confirmar_senha) {
        echo "As senhas não coincidem!";
        exit;
    }

    // Criptografar a senha antes de armazená-la
    $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

    // Preparar e executar a consulta SQL para inserir os dados no banco
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha_criptografada);

    if ($stmt->execute()) {
        echo "Cadastro realizado com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    // Fechar a declaração e a conexão
    $stmt->close();
    $conn->close();
}
?>
