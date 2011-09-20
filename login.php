<? ob_start() ?>
<html>
    <head>
        <style type="text/css">
        </style>
    </head>
    <body>
        <?php
        echo "<form method=post>";
        echo "Usuario<br />";
        echo "<input type=text name=usuario>";
        echo "<br />";
        echo "Senha<br />";
        echo "<input type=password name=senha>";
        echo "<input type='submit' value='Entrar' /><input type='hidden' value='1' name='submitted'>";
        echo "</form>";
        if (isset($_POST['submitted'])) {
            $usuario = $_POST['usuario'];
            $senha = $_POST['senha'];
            if ($usuario && $senha) {
                include('config.php');
                $result = mysql_query("select * from usuarios where usuario='$usuario'");
                if (mysql_num_rows($result) == 0)
                    echo('Usuario nao encontrado');
                else {
                    $row = mysql_fetch_array($result);
                    $salt = $row['salt'];
                    $hash = crypt($senha, $salt);
                    $result = mysql_query("select * from usuarios where usuario='$usuario' and hash='$hash'");
                    if (mysql_num_rows($result) == 0)
                        die('Senha incorreta');
                    else {
                        session_start();
                        $_SESSION['usuario'] = $usuario;
                        header("location: /locacao/imoveis/list.php");
                    }
                }
                mysql_close($link);
            }
        }
        ?>
    </body>
</html>
<? ob_flush() ?>