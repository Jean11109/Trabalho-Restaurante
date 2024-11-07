<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber os dados do formulário
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $telefone = $_POST['phone'];
    $assunto = $_POST['subject'];
    $tipo_contato = $_POST['reservation'];
    $data_reserva = $_POST['date'];
    $hora_reserva = $_POST['time'];
    $quantidade_pessoas = $_POST['guests'];
    $mensagem = $_POST['message'];

    // Definir o destinatário (para onde será enviado o e-mail)
    $destinatario = "seuemail@dominio.com"; // Altere para o seu e-mail

    // Definir o assunto do e-mail
    $assunto_email = "Novo Contato de: $nome";

    // Corpo do e-mail
    $corpo_email = "
    <h2>Mensagem de Contato</h2>
    <p><strong>Nome:</strong> $nome</p>
    <p><strong>E-mail:</strong> $email</p>
    <p><strong>Telefone:</strong> $telefone</p>
    <p><strong>Assunto:</strong> $assunto</p>
    <p><strong>Tipo de Contato:</strong> $tipo_contato</p>
    <p><strong>Data da Reserva:</strong> $data_reserva</p>
    <p><strong>Hora da Reserva:</strong> $hora_reserva</p>
    <p><strong>Quantidade de Pessoas:</strong> $quantidade_pessoas</p>
    <p><strong>Mensagem:</strong> $mensagem</p>
    ";

    // Definir cabeçalhos do e-mail
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: $email" . "\r\n"; // Remetente (e-mail de quem está enviando)

    // Enviar o e-mail
    if (mail($destinatario, $assunto_email, $corpo_email, $headers)) {
        // Redirecionar para a página de contato com sucesso
        header("Location: contato.html?status=success");
        exit();
    } else {
        // Redirecionar para a página de contato com erro
        header("Location: contato.html?status=error");
        exit();
    }
} else {
    // Caso o formulário não tenha sido enviado corretamente
    header("Location: contato.html?status=error");
    exit();
}
?>
