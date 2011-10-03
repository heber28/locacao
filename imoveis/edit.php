<?

include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/session.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/config.php');
echo "<a href='list.php'>Voltar</a><br />";
echo "<h2>Editando o Im&oacute;vel</h2>";
if (isset($_GET['id'])) {
	$id = (int) $_GET['id'];
	if (isset($_POST['submitted'])) {
		foreach ($_POST AS $key => $value) {
			$_POST[$key] = mysql_real_escape_string($value);
		}
		$sql = "UPDATE `imoveis` SET  `endereco` =  '{$_POST['endereco']}' ,  `alugado` =  '{$_POST['alugado']}'   WHERE `id` = '$id' ";
		mysql_query($sql) or die(mysql_error());
		echo (mysql_affected_rows()) ? "Cadastro salvo" : "Nada foi alterado";		
	}
	$row = mysql_fetch_array(mysql_query("SELECT * FROM `imoveis` WHERE `id` = '$id' "));

	echo "<form action='' method='POST'>";
	echo "<p><b>Endereco:</b><br /><input type='text' name='endereco' size=80 value='" . stripslashes($row['endereco']) . "'>";
	echo "<p><b>Alugado:</b><br />";

	echo "<input type='radio' name='alugado' value='1'";
	if (isset($row['alugado']) && $row['alugado'] == 1) {
		echo 'checked';
	}
	echo '>Sim';
	echo "<input type='radio' name='alugado' value='0'";
	if (isset($row['alugado']) && $row['alugado'] == 0) {
		echo 'checked';
	}
	echo '>Nao';
	echo "<p><input type='submit' value='Salvar' /><input type='hidden' value='1' name='submitted' />";
	echo "</form>";
	mysql_close($link);
}
?>