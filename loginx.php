
<?php
// Limpa a sessão 
session_unset();
session_write_close();
    
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <style>
	body {
    background: url("/img/FUNDOX.PNG") no-repeat center top fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
	}
	
	
  </style>

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
	
	window.onload = function e(){
		$('#exampleModalLabel').modal();
	}
  </script>
</head>

<body>
<script>

	(function(m,a,i,s,_i,_m){m.addEventListener("load",function(){m.top.maisim||(function(){_m=a.createElement(i);i=a.getElementsByTagName(i)[0];_m.async=!0;_m.src=s;_m.id="maisim";_m.charset="utf-8";_m.setAttribute("data-token",_i);i.parentNode.insertBefore(_m,i)})()})})(window,document,"script","https://app.mais.im/support/assets/js/core/embed.js", "9431992aaa3c1e00a0e426611d7f2a77");

</script>
  <div class="container">
    <br><br>
	
    <div class="row justify-content-center" style="opacity: 0.9;">
      <div class="col-xl-5 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><i class="fas fa-desktop"></i> SUP-DESK</h1>
                  </div>
                  <form class="user" METHOD="post" action="login2.php">
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
					 <label style="text-align:center">Selecione a Empresa</label>
					 <SELECT NAME="EMPRESA" ID="EMPRESA" class="form-control form-control-auto" placeholder="Selecione a Empresa" REQUIRED style="border-radius:30px">
						<option selected value="">Selecione a Empresa</option>
						<option value="GA">GA</option>
						<option value="GA">LS</option>
						<option value="NAVEGANTES">HOSPITAL NAVEGANTES</option>
						<option value="HTO">HTO</option>
						<option value="CAMACARI">ISIBA</option>
					  </SELECT>
                    </div>
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" AUTOFOCUS id="EMAIL" value="<?php echo $EMAIL?>" name="EMAIL" aria-describedby="emailHelp" placeholder="Email..." REQUIRED>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="SENHA" value="<?php echo $SENHA?>" name="SENHA" placeholder="Senha**" REQUIRED>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
					<button type="submit" class="btn btn-danger btn-user btn-block" onclick="limpar()">
                      Limpar
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
