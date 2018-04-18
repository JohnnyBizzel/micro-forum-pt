<?php
	
	//INDEX
	$id_sessao= session_id();
	if(empty($id_sessao)) session_start();
	
	//----------------------
	//CABEÇALHO
	
	include 'cabecalho.php';
	
	if($id_sessao == null)
	{
		include 'login.php';
	}
	
	//----------------------
	//RODAPÉ
	
	include 'rodape.php';
?>