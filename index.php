<?php
$SERVIDOR = "localhost";
$USUARIO = "root";
$SENHA = "";
$BASE = "skanbo";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Agendamento de Serviço Skanbo</title>
	
<style>
    * {
        font-family: Arial, sans-serif;
        background-color: #F0F0F0;
        color: #black;
    }

    div {
        margin: 10px;
        padding: 10px;
        background-color: #FFFFFF;
    }

    h1, h2 {
        text-align: center;
        background-color: #3498DB;
        color: #FFFFFF;
        padding: 10px;
    }

    img {
        background-color: transparent;
    }

    table {
        border-collapse: collapse;
        margin: auto;
    }

    th {
        background-color: #E74C3C;
        color: #FFFFFF;
    }

    a {
        text-decoration: none;
        color: #3498DB;
    }

    th a {
        background-color: #E74C3C;
        color: #FFFFFF;
    }

    th, td {
        padding: 10px;
    }

    table, th, td {
        border: 1px solid #DDDDDD;
    }

    #cab {
        clear: both;
        display: flex;
        background-color: #3498DB;
        padding: 10px;
    }

    #logo {
        width: 20%;
        float: left;
    }

    #topo {
        width: 70%;
        float: left;
    }

    #logo, #topo {
        height: 90%;
        background-color: #3498DB;
    }

    #area {
        text-align: center;
        width: 95%;
    }

    #bot {
        margin-bottom: 20px;
    }

    #rodape {
        text-align: center;
        font-size: 80%;
        background-color: #3498DB;
        padding: 5px;
    }

    #rodape p {
        background-color: #3498DB;
        padding: 5px;
        margin: 5px;
    }

    .botao {
        display: inline-block;
        padding: 15px 30px;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        background-color: #2ECC71;
        color: #FFFFFF;
        border-radius: 10px;
        border: 2px solid #E74C3C;
        text-transform: uppercase;
        cursor: pointer;
    }
</style>

	</head>
	<body>
		<div id="cont">
			<div id="cab">
				<div id="logo">
					<img src="logo.png">
				</div>
				<div id="topo">
					<h1>Serviços Skanbo</h1>
					<h2>Agendamento de Serviços</h2>
				</div>
				<div id="logo">
					<img src="logo.png">
				</div>
			</div>
			<div id="area">
				<h3>Agenda</h3>
				<table>
					<tr><th>Data</th><th>Horário</th><th>Cliente</th>
						<th>Prestador<a href="controle.php?op=new" title="Novo prestador"></a></th>
						<th>Categoria</th><th></th></tr>
<?php
$con = mysqli_connect($SERVIDOR, $USUARIO, $SENHA, $BASE);
$dados = mysqli_query($con, "select * from vProxAgendamento");
mysqli_close($con);
while ($linha = mysqli_fetch_assoc($dados)) {
	$id = $linha["id_agendamento"];
	$dia = $linha["data_c"];
	$hora = $linha["hora"];
	$cli = $linha["cliente"];
	$prestador = $linha["prestador"];
	$categoria = $linha["categoria"];
	$cancela = $linha["dif"] > 48 ? "<a href=\"controle.php?op=canc&id=$id\">&#x1F5D1;</a>" : "&nbsp;" ;
 echo "<tr><td>$dia</td><td>$hora</td><td>$cli</td><td>$prestador</td><td>$categoria</td>" . 
  "<td>$cancela <a href=\"controle.php?op=alt&id=$id\">&#9842;</a></td></tr>";
}
?>
				</table>
				<p id="bot">
					<a href="controle.php?op=nova" class="botao">Novo agendamento</a>
				</p>
			</div>
			<div id="rodape">
				<p>Serviços Skanbo</p>
				<p>Travessa dos Palmares, 1888</p>
				<p>Ouro Preto, Minas gerais</p>
			</div>
		</div>
	</body>
</html>