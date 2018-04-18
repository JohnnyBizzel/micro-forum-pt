<?php

		//INSTALAÇÃO DA BASE DE DADOS DO SITIO
		
		include 'config.php';
		
		//------------------------------------
		//criação da base de dados
		$ligacao=new PDO("mysql:host=$host",$user,$password);
		$motor= $ligacao->prepare("CREATE DATABASE $base_dados");
		$motor->execute();
		$ligacao=null;
		
		echo '<p>Base de dados criada com sucesso</p><hr>';
		
		//------------------------------------
		//Abrir base dados para adicionar tabelas
		$ligacao=new PDO("mysql:dbname=$base_dados;host=$host",$user,$password);
		
		//------------------------------------
		//tabela "users" - utilizadores do micro forum
		$sql="CREATE TABLE utilizadores(
				id_ut		INT NOT NULL PRIMARY KEY,
				ut_nome		VARCHAR(30),
				passe		VARCHAR(100),
				avatar		VARCHAR(250)
		)";
		$motor=$ligacao->prepare($sql);
		$motor->execute();
		
		echo '<p>Tabela utilizadores criada com sucesso.</p>';
		
		//------------------------------------
		//tabela "mensagens" - mensagens do micro forum
		
		$sql="CREATE TABLE mensagens(
				id_msg		INT NOT NULL PRIMARY KEY,
				id_ut		INT NOT NULL,
				titulo		VARCHAR(100),
				mensagem	TEXT,
				data_msg	DATETIME,
				FOREIGN KEY(id_ut) REFERENCES utilizadores(id_ut) ON DELETE CASCADE
		)";
		
		$motor=$ligacao->prepare($sql);
		$motor->execute();
		$ligacao=null;
		
		echo '<p>Tabela mensagens criada com sucesso.</p>
		<hr>
		<p>Processo de criação da bd terminado com sucesso</p>';
		
?>