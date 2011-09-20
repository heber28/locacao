<?

include('/../session.php');
if (isset($_GET['imovel_id']) and isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $imovel_id = (int) $_GET['imovel_id'];
    include('/../config.php');
    $row = mysql_fetch_array(mysql_query("SELECT * FROM `boletos` WHERE `id` = '$id' "));
    if (isset($_POST['delbutton'])) {
        mysql_query("DELETE FROM `boletos` WHERE `id` = '$id' ");
        echo (mysql_affected_rows()) ? "Cadastro excluido<br /> " : "Nada excluido<br /> ";
        echo "<a href='list.php?imovel_id=$imovel_id'>Voltar</a><br /><br />";
    } elseif (isset($_POST['cancelbutton'])) {
        echo "Cancelado a exclusao <br />";
        echo "<a href='list.php?imovel_id=$imovel_id'>Voltar</a><br /><br />";
    } else {
        echo "<form action='' method='POST'>";
        echo 'Tem certeza que deseja excluir o boleto: ' . $row['vencimento'] . ' de ' . $row['sacado'] . '?<br />';
        echo "<input name='delbutton' value='Excluir' type='submit'>";
        echo "<input name='cancelbutton' value='Cancelar' type='submit'>";
        echo "</form>";
    }
    mysql_close($link);
}
?>

