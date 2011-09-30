<?php

session_start();
if (isset($_SESSION['usuario']))
echo "Bem-vindo, " . $_SESSION['usuario'] . "!&nbsp<a href='/locacao/logout.php'>Sair</a><br/><br/>";
else
die("Voce precisa estar logado para acessar esta pagina<br/><a href='/locacao/login.php'>Clique aqui</a> para logar-se.<br/>");
?>
