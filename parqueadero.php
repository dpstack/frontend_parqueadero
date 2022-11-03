<?php


session_start();
if (empty($_SESSION["usuario"])) {
    header("Location: index.php");
    exit();
} else {

    try {
        require_once('conexion.php');
        $conn = new PDO($hostPDO, $usuarioDB, $contraseyaDB);

        $parqueaderos = $conn->prepare('SELECT * FROM parqueaderos WHERE disponibilidad = 1');
        $parqueaderos->execute();
        $conn = null;
    } catch (PDOException $e) {
        echo "Conexión fallida: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parking Frontend - Javascript Edition</title>
    <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/1167/1167984.png" type="image/x-icon">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <form action="logout.php">
            <button id="bLogin" type="submit" class="btn btn-success mt-3">Logout</button>
        </form>

        <h1 class="mt-3 mb-4">Parking Information</h1>


        <div class="mb-3">
            <label for="name" class="form-label">Id lugar de parqueo</label>
            <input required type="number" class="form-control" id="idParqueo">
        </div>


        <div class="mb-3">
            <label for="id" class="form-label">Hora ingreso</label>
            <input required type="time" class="form-control" id="hora_ingreso">
        </div>
        <div class="mb-3">
            <label for="id" class="form-label">Hora Egreso</label>
            <input required type="time" class="form-control" id="hora_egreso">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Dia</label>
            <input required type="date" class="form-control" id="dia_vehiculo">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Tipo Vehiculo id</label>
            <!-- <input required type="text" class="form-control" id="Tipovehicle_id"> -->
            <select required type="text" class="form-control" id="Tipovehicle_id">
                <option value="1">Moto</option>
                <option value="2">Carro</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">User id</label>
            <input required type="text" class="form-control" id="user_id">
        </div>

        <button id="bAparcar" type="button" class="btn btn-primary">Aparcar</button>
        <button id="bDesaparcar" type="button" class="btn btn-danger">Desaparcar</button>
        <button id="bClear" type="button" class="btn btn-secondary">Clear</button>
        <!-- <button id="bReload" type="button" class="btn btn-info">Reload</button> -->

        <h1 class="mt-5 mb-4">Vehiculos Parqueados</h1>

        <table id="tickets-list" class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">LUGAR DE PARQUEO</th>
                    <th scope="col">HORA INGRESO</th>
                    <th scope="col">HORA EGRESO</th>
                    <th scope="col">DIA</th>
                    <th scope="col">TIPO VEHICULO</th>
                    <th scope="col">USER ID</th>
                </tr>
            </thead>
            <tbody>
                </tr>
                <?php foreach ($parqueaderos as $clave => $value) : ?>
                    <tr class="table-hover table-primary">
                        <thead class="text-center" style="background-color:#E8F6EF; text-transform: capitalize;">
                            <td><?= $value['lote'] ?></td>
                            <td><?= $value['hora_ingreso'] ?></td>
                            <td><?= $value['hora_egreso'] ?></td>
                            <td><?= $value['dia'] ?></td>
                            <td><?= $value['tipoVehiculo_id'] == 1 ? "Moto" : "Carro" ?></td>
                            <td><?= $value['user_id'] ?></td>
                            <td>
                                <!-- <td>
                                <a href="update.php?cod_parqueaderos=<?= $value['cod_parqueaderos'] ?>">
                                    <button type="button" class="btn btn-info">
                                        Modificar
                                    </button>
                                </a>
                            </td>
                            <td><a href="delete.php?cod_parqueaderos=<?= $value['cod_parqueaderos'] ?>"><button type="button" class="btn btn-danger">Eliminar</button></a></td> -->
                            <?php endforeach; ?>
                        </thead>
                    </tr>
            </tbody>
        </table>
    </div>

    <!-- Login modal dialog -->

    <div id="login-dialog" class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">User Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="login_email" class="form-label">Email</label>
                        <input type="text" value="valetina@gmail.com" class="form-control" id="login_email">
                    </div>
                    <div class="mb-3">
                        <label for="login_password" class="form-label">Password</label>
                        <input type="password" value="hola123" class="form-control" id="login_password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="blogin-accept" type="button" class="btn btn-primary">Accept</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <script src="app.js"></script>
</body>

</html>