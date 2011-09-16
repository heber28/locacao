<?
if (isset($_GET['imovel_id']) and isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $imovel_id = (int) $_GET['imovel_id'];
    include('config.php');
    $row = mysql_fetch_array(mysql_query("SELECT * FROM `boletos` WHERE `id` = '$id' "));
    $disabled = '';
    if (isset($_POST['delbutton'])) {
        mysql_query("DELETE FROM `boletos` WHERE `id` = '$id' ");
        echo (mysql_affected_rows()) ? "Cadastro excluido<br /> " : "Nada excluido<br /> ";
        echo "<a href='list.php?imovel_id=$imovel_id'>Voltar para lista</a><br /><br />";
        $disabled = 'disabled';
    } elseif (isset($_POST['cancelbutton'])) {
        echo "Cancelado a exclusao <br />";
        echo "<a href='list.php?imovel_id=$imovel_id'>Voltar para lista</a><br /><br />";
        $disabled = 'disabled';
    }
}
?>
<form action='' method='POST'>
    <?
    $data = strtotime(stripslashes($row['vencimento']));
    echo 'Tem certeza que deseja excluir o boleto: ' . date('d-m-Y', $data) . ' de ' . $row['sacado'] . '?<br />';
    echo "<input name='delbutton' value='Excluir' type='submit'" . $disabled . ">";
    echo "<input name='cancelbutton' value='Cancelar' type='submit'" . $disabled . ">";
    ?>
</form>
<br />
<br />
