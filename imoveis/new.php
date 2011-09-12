<? 
include('config.php'); 
if (isset($_POST['submitted'])) { 
foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
$sql = "INSERT INTO `imoveis` ( `endereco` ,  `alugado`  ) VALUES(  '{$_POST['endereco']}' ,  '{$_POST['alugado']}'  ) "; 
mysql_query($sql) or die(mysql_error()); 
echo "Cadastro adicionado<br />";
echo "<a href='list.php'>Voltar para lista</a>";
echo "<br />";
} 
?>

<form action='' method='POST'> 
<p><b>Endereco:</b><br /><input type='text' name='endereco' size=80/>
<p><b>Alugado:</b><br />
    <input type='radio' name='alugado' value='1' checked>Sim
    <input type='radio' name='alugado' value='0'>Nao
<p><input type='submit' value='Adicionar cadastro' /><input type='hidden' value='1' name='submitted' />
</form> 
