<?php

	require_once("PHPMailer/PHPMailerAutoload.php");


if(isset($_POST["email"])){	

    	require_once("admin/class/Depoimento.php");
	
		$assunto	= "Site Mania de Arte Atelie";
		$nomeCli	= $_POST["nomeCli"];
        $email		= $_POST["email"];
        $endereco	= $_POST["endereco"];
        $numPedido	= $_POST["numPedido"];
        $notaProd   = $_POST["notaProd"];
        $textoDepo	= $_POST["textoDepo"];

        $contato            = new Depoimento();
        $contato->nomeCli   = $nomeCli;
        $contato->email     = $email;
        $contato->endereco  = $endereco;
        $contato->numPedido = $numPedido;
        $contato->notaProd  = $notaProd;
        $contato->textoDepo = $textoDepo;
        $contato->InserirDepoimento();
    


        $phpmail = new PHPMailer(); // Instânciamos a classe PHPmailer para poder utiliza-la          
        $phpmail->isSMTP(); // envia por SMTP
        
        $phpmail->SMTPDebug = 0;
        $phpmail->Debugoutput = 'html';
        
        $phpmail->Host = "smtp.gmail.com"; // SMTP servidor de envio         
        $phpmail->Port = 587; // Porta SMTP do GMAIL
        
        //$phpmail->SMTPSecure = 'tls';
        $phpmail->SMTPAuth = true; // Caso o servidor SMTP precise de autenticação   
        
        $phpmail->Username = "oficialmaniadearteatelie@gmail.com"; // SMTP e-mail de envio         
        $phpmail->Password = "499216672"; // SMTP senha          
        $phpmail->IsHTML(true);         
        
        $phpmail->setFrom($email, $nomeCli); // E-mail do remetende enviado pelo method post  
                 
        $phpmail->addAddress("oficialmaniadearteatelie@gmail.com", "Site Mania de Arte Atelie");// E-mail do destinatario/*  
        
        $phpmail->Subject = $assunto; // Assunto do remetende enviado pelo method post
                
        $phpmail->msgHTML(" Nome:               $nomeCli <br>
                            E-mail:             $email <br>
                            Cidade e Estado:    $endereco <br>
                            Numero do Pedido:   $numPedido <br>
                            Nota do Produto:    $notaProd <br>
                            Mensagem:           $textoDepo");
        
        $phpmail->AlrBody = "Nome:              $nomeCli \n
                            E-mail:             $email \n
                            Cidade e Estado:    $endereco \n
                            Numero do Pedido:   $numPedido\n
                            Nota do Produto:    $notaProd \n
                            Mensagem:           $textoDepo";
            
        if($phpmail->send()){
			$OK = "OK";
			
        }else{
            $OK = "ERRO";
        }
         
        
        // ############## RESPOSTA AUTOMATICA
        $phpmailResposta = new PHPMailer();        
        $phpmailResposta->isSMTP();
        
        $phpmailResposta->SMTPDebug = 0;
        $phpmailResposta->Debugoutput = 'html';
        
        $phpmailResposta->Host = "smtp.gmail.com";         
        $phpmailResposta->Port = 587;
        
        $phpmailResposta->SMTPSecure = 'tls';
        $phpmailResposta->SMTPAuth = true;   
        
        $phpmailResposta->Username = "oficialmaniadearteatelie@gmail.com";         
        $phpmailResposta->Password = "499216672";          
        $phpmailResposta->IsHTML(true);         
        
        $phpmailResposta->setFrom($email, $nomeCli); // E-mail do remetende enviado pelo method post  
                 
        $phpmailResposta->addAddress($email, "Site Mania de Arte Atelie");// E-mail do destinatario/*  
        
        $phpmailResposta->Subject = "Resposta - " .$assunto; // Assunto do remetende enviado pelo method post
                
        $phpmailResposta->msgHTML(" Nome: $nomeCli <br>
                            Em breve daremos o retorno");
        
        $phpmailResposta->AlrBody = "Nome: $nomeCli \n
                            Em breve daremos o retorno";
            
        $phpmailResposta->send();	

        header("Location:msgEnvio.php?mens=OK&nome=$nomeCli");	
        
}

?>





