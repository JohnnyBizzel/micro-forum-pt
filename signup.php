<?php 

	$id_sessao= session_id();
	if(empty($id_sessao)) session_start();

	include 'cabecalho.php';

    if(!isset($_POST['btn_submit'])) {
        ApresentarFormulario();
    } else {
        RegistratUtilizor();   
    }

	
	include 'rodape.php';

    function ApresentarFormulario() { 
        echo '<form class="form_signup" method="post" action="signup.php?a=signup"
            enctype="multipart/form-data">
            <p>Signup:</p>
            Username:<br>
            <input type="text" size="20" name="txtUsername"/>
            <br/>
            Password:<br>
            <input type="password" size="20" name="txtPassword1"/>
            <br/>
            Confirm Password:<br>
            <input type="password" size="20" name="txtPassword2"/>
            <br/>
            <input type="hidden" name="MAX_FILE_SIZE" value="50000" />
            Avatar (use JPG < 50Kb):
            <br/>
            <input type="file" name="imagem_avatar" />
            <br/>
            
            <br/>
            <input type="submit" name="btn_submit" value="Registrar" />
            </form>
            <a href="index.php">Voltar</a>';
    }	
	
	function RegistratUtilizor() {
	    $username = $_POST['txtUsername'];
	    $password1 = $_POST['txtPassword1'];
	    $password2 = $_POST['txtPassword2'];
	    $avatar = $_FILES['imagem_avatar'];
	    $erro = false;
	    // verificacao
	    if ($username == "" || $password1 == "" || $password2 == "") {
	        echo '<div class="error">Registrar Error!! Please enter user name &amp; passwords.</div>';
	        $erro = true;
	    } else if ($password1 != $password2) {
	        echo '<div class="error">Error!! Passwords n&#227;o coincidem.</div>';
	        $erro = true;
	    } else if ($avatar['name'] != "" && $avatar['type'] != "image/jpeg") {
	        echo '<div class="error">Error!! Ficheiro de imagem inv&#225;lido. Wrong file type.</div>';
	        $erro = true;
	    } else if ($avatar['name'] != "" && $avatar['size'] > $_POST['MAX_FILE_SIZE']) {
	        echo '<div class="error">Error!! Ficheiro de imagem inv&#225;lido. Too Big.</div>';
	        $erro = true;
	    }
	    if ($erro) {
	        ApresentarFormulario();
	        // incluir o rodape
	        include 'rodape.php';
	        exit;
	    }
	    
	    // Validation ok - process new user
	    include 'config.php';
	    
	    $connect = new PDO("mysql:dbname=$base_dados;host=$host", $user, $password);
	    
	    // check for same username in Db
	    $motor = $connect->prepare("SELECT ut_nome FROM utilizadores WHERE ut_nome = ?");
	    $motor->bindParam(1, $username, PDO::PARAM_STR);
	    $motor->execute();
	    
	    if ($motor->rowCount() != 0) {
	        // Erro - ut exists!
	        echo '<div class="error">Error!! User exists already.</div>';
	        $connect = null;
	        ApresentarFormulario();
	        include 'rodape.php';
	        exit;
	    } else {
	        // register new user
	        $motor = $connect->prepare("SELECT MAX(id_ut) AS MaxID FROM utilizadores");
	        $motor->execute();
	        $id_temp = $motor->fetch(PDO::FETCH_ASSOC)['MaxID'];
	        if ($id_temp == null) {
	            $id_temp = 0;
	        } else {
	            $id_temp++;
	        }
	        
	        // encriptar a password
	        $passwordEnc = md5($password1);
	        
	        $sql ="INSERT INTO utilizadores VALUES (:id_ut, :ut_nome, :passe, :avatar)";
	        $motor = $connect->prepare($sql);
	        $motor->bindParam(":id_ut", $id_temp, PDO::PARAM_INT);
	        $motor->bindParam(":ut_nome", $username, PDO::PARAM_STR);
	        $motor->bindParam(":passe", $password1, PDO::PARAM_STR);
	        $motor->bindParam(":avatar", $avatar['name'], PDO::PARAM_STR);
	        $motor->execute();
	        $connect = null;
	        
	        // upload avatar to web?
	        move_uploaded_file($avatar['tmp_name'], "imagens/avatars/".$avatar['name']);
	        
	        // confirm success message
	        echo '<div class="novo_registo">Bem-bindo ao Micro forum,<strong>'.
	        $user.'<br><br>A partir yatta yatta yata....<br></div><br>';
	        echo '<a href="index.php">Quadro de login</a>';
	        
	    }
	    
	    echo '<p>Terminado</p>';
	    
	}
?>