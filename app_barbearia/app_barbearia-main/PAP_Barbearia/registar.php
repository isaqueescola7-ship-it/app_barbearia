<?php
include('conexao.php');

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escapar os dados para evitar erros de sintaxe no SQL
    $nome = $mysqli->real_escape_string($_POST['nome']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $telemovel = $mysqli->real_escape_string($_POST['telemovel']);
    $senha = $mysqli->real_escape_string($_POST['senha']);

    // Verificar se o e-mail já existe na base de dados
    $verificar = $mysqli->query("SELECT * FROM cliente WHERE email = '$email'");

    if ($verificar && $verificar->num_rows > 0) {
        $mensagem = "<p style='color:#ef4444; font-weight:600; margin-bottom:15px;'>❌ Este e-mail já está registado!</p>";
    } else {
        // Query calibrada exatamente para as tuas colunas: nome, telemovel, email, senha
        $sql = "INSERT INTO cliente (nome, telemovel, email, senha) VALUES ('$nome', '$telemovel', '$email', '$senha')";

        if ($mysqli->query($sql)) {
            // Redireciona para o login com uma nota de sucesso
            header("Location: login.php?registado=1");
            exit();
        } else {
            $mensagem = "<p style='color:#ef4444; font-weight:600; margin-bottom:15px;'>❌ Erro ao registar: " . $mysqli->error . "</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Registo - Isaque Cortes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #f1f5f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px;">
    <div style="background: white; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); max-width: 400px; width: 100%; text-align: center;">
        <h2 style="color: #1e293b; margin-bottom: 10px;">Criar Conta</h2>
        <p style="color: #64748b; font-size: 14px; margin-bottom: 25px;">Registe-se para começar a agendar os seus cortes</p>
        
        <?php echo $mensagem; ?>

        <form action="" method="POST" style="display: flex; flex-direction: column; gap: 15px; text-align: left;">
            <div>
                <label style="font-size: 14px; font-weight: 600; color: #334155; display:block; margin-bottom: 5px;">Nome Completo:</label>
                <input type="text" name="nome" placeholder="Teu nome" required style="padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 16px; width: 100%;">
            </div>

            <div>
                <label style="font-size: 14px; font-weight: 600; color: #334155; display:block; margin-bottom: 5px;">Telemóvel:</label>
                <input type="text" name="telemovel" placeholder="9xxxxxxxx" required style="padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 16px; width: 100%;">
            </div>

            <div>
                <label style="font-size: 14px; font-weight: 600; color: #334155; display:block; margin-bottom: 5px;">E-mail:</label>
                <input type="email" name="email" placeholder="exemplo@email.com" required style="padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 16px; width: 100%;">
            </div>

            <div>
                <label style="font-size: 14px; font-weight: 600; color: #334155; display:block; margin-bottom: 5px;">Senha:</label>
                <input type="password" name="senha" placeholder="Escolha uma senha" required style="padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 16px; width: 100%;">
            </div>

            <button type="submit" class="btn-confirm" style="margin-top: 10px;">Criar minha conta</button>
        </form>

        <p style="margin-top: 20px; font-size: 14px; color: #64748b;">
            Já tem conta? <a href="login.php" style="color: #2563eb; text-decoration: none; font-weight: 600;">Faça Login</a>
        </p>
    </div>
</body>
</html>