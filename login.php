<?php
	
	//ENTRADA
	echo '
		<form class="form_login" method="post" action="login.php">
		
		<h3>Entrar</h3><hr><br>
		Para entrar no Micro F&#243;rum, necessita introduzir o seu nome de utilizador e passe.<br>
		Se n&#227;o tem conta de utilizador, pode criar uma <a href="signup.php">nova conta de utilizador</a>.<br><br>
		
		Nome de utilizador:<br><input type="text" size="20" name="nome_utilizador"><br><br>
		Passe:<br><input type="password" size="20" name="text_password"><br><br>
		<input type="submit" name="btn_submit" value="Entrar">
		</form>';
?>