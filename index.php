<?php

try {
  require_once('conexion.php');
  $conn = new PDO($hostPDO, $usuarioDB, $contraseyaDB);
  session_start();
  // echo $_SESSION['cliente'];
  if (isset($_REQUEST['send'])) {

    $usuario = $conn->prepare('SELECT * FROM users WHERE email=:email AND password=:password;');
    $email = htmlentities(addslashes($_POST['email']));
    $password = htmlentities(addslashes($_POST['password']));
    $usuario->bindValue(":email", $email);
    $usuario->bindValue(":password", $password);
    // $roles = $conn->prepare("SELECT * FROM users INNER JOIN rol ON rol_cod  = cod_rol WHERE email='$email';");
    $usuario->execute();
    // $roles->execute();

    $registros = $usuario->rowCount();

    if ($registros != 0) {
      session_start();
      $_SESSION["usuario"] = $email;
      header("Location: parqueadero.php");
    } else {
      echo '<div class="alert alert-danger" role="alert">
              El Usuario Ingresado no Existe!
            </div>';
    }

    $conn = null;
  }
} catch (PDOException $e) {
  echo "Conexión fallida: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Parking Frontend</title>
  <link rel="stylesheet" href="main.css">
  <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/1167/1167984.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

  <section class="vh-100">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6 text-black">

          <div class="px-5 ms-xl-4">
            <i class="fas fa-crow fa-2x me-3 pt-5 mt-xl-4" style="color: #709085;"></i>
          </div>

          <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

            <form method="post" style="width: 23rem;">

              <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Ingreso de Usuarios</h3>

              <div class="form-outline mb-4">
                <input name="email" type="email" id="form2Example18" class="form-control form-control-lg" />
                <label class="form-label" for="form2Example18">Correo Electrónico</label>
              </div>

              <div class="form-outline mb-4">
                <input name="password" type="password" id="form2Example28" class="form-control form-control-lg" />
                <label class="form-label" for="form2Example28">Contraseña</label>
              </div>

              <div class="pt-1 mb-4">
                <button name="send" class="btn btn-info btn-lg btn-block" type="submit">Ingresar</button>
              </div>

              <!-- <p class="small mb-5 pb-lg-2"><a class="text-muted" href="#!">¿Olvidaste tu contraseña?</a></p>
                  <p>¿No tienes una cuenta? <a href="#!" class="link-info">Regístrate Aquí</a></p> -->

            </form>

          </div>

        </div>
        <div class="col-sm-6 px-0 d-none d-sm-block">
          <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/img3.webp" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
        </div>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  <script src="app.js"></script>

</body>

</html>