<?php
session_start();
include('conexao.php');

$mensagem = "";

// Se vier o aviso de sucesso do registo
if (isset($_GET['registado'])) {
    $mensagem = "<p style='color:#10b981; font-weight:600; margin-bottom:15px;'>🎉 Registo efetuado! Faça login agora.</p>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $mysqli->real_escape_string($_POST['email']);
    $senha = $mysqli->real_escape_string($_POST['senha']); // Adicionado campo senha para segurança real
    
    // Validar e-mail e senha correspondentes
    $sql = "SELECT * FROM cliente WHERE email = '$email' AND senha = '$senha'";
    $resultado = $mysqli->query($sql);
    
    if ($resultado && $resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        
        $_SESSION['id_cliente'] = $usuario['id_cliente'];
        $_SESSION['nome_cliente'] = $usuario['nome']; 
        
        header("Location: index.php");
        exit();
    } else {
        $mensagem = "<p style='color:#ef4444; font-weight:600; margin-bottom:15px;'>❌ E-mail ou Senha incorretos!</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Login - Isaque Cortes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #f1f5f9; display: flex; justify-content: center; align-items: center; height: 100vh;">
    <div style="background: white; padding: 40px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); max-width: 400px; width: 100%; text-align: center;">
        <h2 style="color: #1e293b; margin-bottom: 10px;">Entrar na Barbearia</h2>
        <p style="color: #64748b; font-size: 14px; margin-bottom: 25px;">Insira os seus dados para aceder ao agendamento</p>
        
        <?php echo $mensagem; ?>

        <form action="" method="POST" style="display: flex; flex-direction: column; gap: 15px; text-align: left;">
            <div>
                <label style="font-size: 14px; font-weight: 600; color: #334155; display:block; margin-bottom:5px;">O seu E-mail:</label>
                <input type="email" name="email" required placeholder="exemplo@email.com" style="padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 16px; width: 100%;">
            </div>
            
            <div>
                <label style="font-size: 14px; font-weight: 600; color: #334155; display:block; margin-bottom:5px;">Senha:</label>
                <input type="password" name="senha" required placeholder="Sua senha" style="padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 16px; width: 100%;">
            </div>

            <button type="submit" class="btn-confirm" style="margin-top: 10px;">Entrar no Sistema</button>
        </form>

        <p style="margin-top: 20px; font-size: 14px; color: #64748b;">
            Não tem conta? <a href="registar.php" style="color: #2563eb; text-decoration: none; font-weight: 600;">Registe-se aqui</a>
        </p>
    </div>
</body>
</html>