<?php

// +----------------------------------------------------------------------+
// | BoletoPhp - Versao Beta                                              |
// +----------------------------------------------------------------------+
// | Este arquivo esta disponovel sob a Licenca GPL disponivel pela Web   |
// | em http://pt.wikipedia.org/wiki/GNU_General_Public_License           |
// | Voce deve ter recebido uma copia da GNU Public License junto com     |
// | esse pacote; se nao, escreva para:                                   |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Originado do Projeto BBBoletoFree que tiveram colaboracoes de Daniel |
// | William Schultz e Leandro Maniezo que por sua vez foi derivado do	  |
// | PHPBoleto de Joao Prado Maia e Pablo Martins F. Costa	          |
// |           			                                          |
// | Se vc quer colaborar, nos ajude a desenvolver p/ os demais bancos :-)|
// | Acesse o site do Projeto BoletoPhp: www.boletophp.com.br             |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Equipe Coordenacao Projeto BoletoPhp: <boletophp@boletophp.com.br>   |
// | Desenvolvimento Boleto Real: Juan Basso         		          |
// +----------------------------------------------------------------------+
// ------------------------- DADOS DINAMICOS DO SEU CLIENTE PARA A GERACAO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulario c/ POST, GET ou de BD (MySql,Postgre,etc)  //
// DADOS DO BOLETO PARA O SEU CLIENTE
#include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/session.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/locacao/resources/config.php');
if (isset($_GET['id']) == FALSE)
    exit;

$id = (int) $_GET['id'];
$row = mysql_fetch_array(mysql_query("SELECT *, (aluguel + iptu + sanepar + limpeza + material + copel + outros) as total, (sanepar + limpeza + material + copel + outros) as condominio FROM `boletos` WHERE `id` = '$id' "));


$dadosboleto["nosso_numero"] = $row['nosso_num'];  // Nosso numero - REGRA: M�ximo de 13 caracteres!
$dadosboleto["numero_documento"] = $row['num_doc']; // Num do pedido ou do documento
$data_venc = date("d/m/Y", strtotime($row['vencimento']));
$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
$dadosboleto["data_documento"] = ""; #date("d/m/Y"); // Data de emissao do Boleto
$dadosboleto["data_processamento"] = ""; #date("d/m/Y"); // Data de processamento do boleto (opcional)
$valor_boleto = number_format($row['total'], 2, ',', '');
$dadosboleto["valor_boleto"] = $valor_boleto;  // Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula
// DADOS DO SEU CLIENTE
$dadosboleto["sacado"] = $row['sacado'];
$dadosboleto["endereco1"] = $row['imovel_endereco'];
$dadosboleto["endereco2"] = "Londrina/PR";

// INFORMACOES PARA O CLIENTE

if ($row['condominio'] == 0) {
    if ($row['iptu'] == 0)
        $dadosboleto["demonstrativo1"] = "Ref: Pagamento do Aluguel (R$ " . $row['aluguel'] . ")";
    else
        $dadosboleto["demonstrativo1"] = "Ref: Pagamento do Aluguel (R$ " . $row['aluguel'] . ") e IPTU (R$ " . $row['iptu'] . ")";
}
else {
    if ($row['iptu'] == 0)
        $dadosboleto["demonstrativo1"] = "Ref: Pagamento do Aluguel (R$ " . $row['aluguel'] . ") e Condominio (R$ " . $row['condominio'] . ")";
    else
        $dadosboleto["demonstrativo1"] = "Ref: Pagamento do Aluguel (R$ " . $row['aluguel'] . ") e Condominio (R$ " . $row['condominio'] . ") e IPTU (R$ " . $row['iptu'] . ")";
}
$dadosboleto["demonstrativo2"] = "";
$dadosboleto["demonstrativo3"] = "";

# FreeBoleto1.Instrucoes.Add('APOS O VENCIMENTO MORA DIARIA DE R$ ' + FormatFloat('0.00', qBoleto.FieldByName('total').AsCurrency / 300) + ' E MULTA DE 2%');
if ($row['desconto'] > 0) {
    $dadosboleto["instrucoes1"] = "Ate o vencimento conceder desconto de R$ " . number_format($row['desconto'], 2, ',', '');
    $dadosboleto["instrucoes2"] = "Apos o vencimento mora diaria de R$ " . number_format($row['total'] / 300, 2, ',', '') . " e multa de 2%";
} else {
    $dadosboleto["instrucoes1"] = "Apos o vencimento mora diaria de R$ " . number_format($row['total'] / 300, 2, ',', '') . " e multa de 2%";
    $dadosboleto["instrucoes2"] = "";
}
$dadosboleto["instrucoes3"] = "";
$dadosboleto["instrucoes4"] = "";

// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
$dadosboleto["quantidade"] = "";
$dadosboleto["valor_unitario"] = "";
$dadosboleto["aceite"] = "N";
$dadosboleto["especie"] = "R$";
$dadosboleto["especie_doc"] = "";


// ---------------------- DADOS FIXOS DE CONFIGURA��O DO SEU BOLETO --------------- //
// DADOS DA SUA CONTA - REAL
$dadosboleto["agencia"] = $row["agencia"];
$dadosboleto["conta"] = $row["ccorrente"];
$dadosboleto["carteira"] = $row["carteira"];
// SEUS DADOS
$dadosboleto["identificacao"] = "";
$dadosboleto["cpf_cnpj"] = "";
$dadosboleto["endereco"] = "";
$dadosboleto["cidade_uf"] = "";
$dadosboleto["cedente"] = $row["cedente_nome"];

// NAO ALTERAR!
include_once("include/funcoes_real.php");
include_once("include/layout_real.php");
mysql_close($link);
?>
