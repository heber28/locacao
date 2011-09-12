<?

include('config.php');
if (isset($_GET['imovel_id'])) {
    $id = (int) $_GET['id'];
    mysql_query("DELETE FROM `boletos` WHERE `id` = '$id' ");
    echo (mysql_affected_rows()) ? "Cadastro excluido<br /> " : "Nada alterado<br /> ";
    $imovel_id = $_GET['imovel_id'];
    echo "<a href='list.php?imovel_id=$imovel_id'>Voltar para lista</a>";
}
?>