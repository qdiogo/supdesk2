<?php
// Limpa a sessão 
session_unset();
session_write_close();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <style>
	body {
    background: url("/img/FUNDO5.PNG") no-repeat center top fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	margin-top: -90px
	}
	
  </style>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Login</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <script>
  
	function limpar()
	{
		document.getElementById("SENHA").value="";
		document.getElementById("EMAIL").value="";
	}
	function baixarapp(endereco)
	{
		location.href=endereco;
	}
  </script>
</head>

<body>

  <div class="container">
    <br><br><br><br>
    <div class="row justify-content-center">
      <div class="col-xl-5 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><i class="fas fa-desktop"></i> SUP-DESK</h1><br>
					
                  </div>
                  <form class="user" METHOD="post" action="login3.php">
                    <?php 
                    $EMAIL="";
                    $SENHA="";
                    $CNPJ="";
                    if (!empty($_COOKIE['EMAIL']))
                    {
                      $EMAIL=$_COOKIE['EMAIL'];
                      $SENHA=$_COOKIE['SENHA'];
                      $CNPJ=$_COOKIE['CNPJ'];
                    }
                    
                    ?>
					<div class="form-group">
					<h6 align="center" style="color:red"></h6>
					  <label style="text-align:center">Selecione a Empresa</label>
					  <SELECT NAME="EMPRESA" ID="EMPRESA" class="form-control form-control-auto" placeholder="Selecione a Empresa" title="Empresa" REQUIRED style="border-radius:30px">
						<option value="GA" selected>GA</option>
					  </SELECT>
                    </div>
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" AUTOFOCUS id="EMAIL" value="<?php echo $EMAIL?>" name="EMAIL" aria-describedby="emailHelp" placeholder="Email..." REQUIRED>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="SENHA" value="<?php echo $SENHA?>" name="SENHA" placeholder="Senha**" REQUIRED>
                    </div>

                    <button type="submit" class="btn btn-success btn-user btn-block">
                      Login
                    </button>
					<button type="submit" class="btn btn-danger btn-user btn-block" onclick="limpar()">
                      Limpar
                    </button>
					<button type="button" class="btn btn-info btn-user btn-block" onclick="baixarapp('http://gasuporte.sytes.net:5008/rustdesk.zip')">
                      Baixar Acesso Remoto
                    </button>
					
                  </form>
                  <hr>
                </div>
              </div>
            </div>
			
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php  
  function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

?>
 
  
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
