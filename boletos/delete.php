<?

include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/session.php');
if (isset($_GET['imovel_id']) and isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $imovel_id = (int) $_GET['imovel_id'];
    include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/db.php');
    echo "<h2>Excluindo o Boleto</h2>";
    $row = mysql_fetch_array(mysql_query("SELECT * FROM `boletos` WHERE `id` = '$id' "));
    if (isset($_POST['delbutton'])) {
        mysql_query("DELETE FROM `boletos` WHERE `id` = '$id' ");
        echo (mysql_affected_rows()) ? "Boleto exclu&iacute;do<br /><br />" : "Nada exclu&iacute;do<br /><br />";
        echo "<a href='list.php?imovel_id=$imovel_id'>Voltar</a><br /><br />";
    } elseif (isset($_POST['cancelbutton'])) {
        echo "Cancelado a exclus&atilde;o<br /><br />";
        echo "<a href='list.php?imovel_id=$imovel_id'>Voltar</a><br /><br />";
    } else {
        echo "<form action='' method='POST'>";
        echo 'Tem certeza que deseja excluir o boleto: ' . $row['vencimento'] . ' de ' . $row['sacado'] . '?<br /><br />';
        echo "<input name='delbutton' value='Excluir' type='submit'>";
        echo "<input name='cancelbutton' value='Cancelar' type='submit'>";
        echo "</form>";
    }
    mysql_close($link);
}
?>

