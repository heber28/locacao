<?

include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/session.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/config.php');

echo "<h2>Exclu&iacute;ndo o Im&oacute;vel</h2>";
if (isset($_GET['id'])) {
	$id = (int) $_GET['id'];
	$row = mysql_fetch_array(mysql_query("SELECT * FROM `imoveis` WHERE `id` = '$id' "));
	$disabled = '';
	if (isset($_POST['delbutton'])) {
		mysql_query("DELETE FROM `imoveis` WHERE `id` = '$id' ");
		echo (mysql_affected_rows()) ? "Cadastro exclu&iacute;do" : "Nada exclu&iacute;do";
		echo " | <a href='list.php'>Voltar</a>";
		$disabled = 'disabled';
	} elseif (isset($_POST['cancelbutton'])) {
		echo "Cancelado a exclus&atilde;o";
		echo " | <a href='list.php'>Voltar</a>";
		$disabled = 'disabled';
	} else {
		echo "<form action='' method='POST'>";
		echo 'Tem certeza que deseja excluir o imovel: ' . $row['endereco'] . '?<br /><br />';
		echo "<input name='delbutton' value='Excluir' type='submit'" . $disabled . ">";
		echo "<input name='cancelbutton' value='Cancelar' type='submit'" . $disabled . ">";
		echo "</form>";
	}
	mysql_close($link);
}
?>