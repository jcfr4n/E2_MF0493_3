<!DOCTYPE HTML>
<html>

<head>
    <style>
        .error {
            color: #FF0000;
        }
    </style>
</head>

<body>


    <?php
    //Datos de conexión a la base de datos.
    $db = [
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'db' => 'email' //Cambiar al nombre de tu base de datos
    ];

    //Abrir conexion a la base de datos
    function connect($db)
    {
        try {
            $conn = new PDO("mysql:host={$db['host']};dbname={$db['db']};charset=utf8", $db['username'], $db['password']);

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;
        } catch (PDOException $exception) {
            exit($exception->getMessage());
        }
    }


    // define e inicializa variables
    $emailErr = "";
    $email = "";
    $msg = "";

    // Hace una depuración de los datos eliminando espacios en blanco, barras,
    //caracteres especiales.

    function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Comprobamos que el email  esté informado y correctamente formado

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            } else {

                // Si todas las condiciones son válidas abrimos 
                // la conexión y hacemos la consulta.

                $dbConn = connect($db);
                $sql = "INSERT INTO email
                        (idEmail, email)
                        VALUES
                        (null,:email)";
                $statement = $dbConn->prepare($sql);
                $statement->bindValue(':email', $email);

                // Capturamos cualquier error
                try {
                    $statement->execute();
                } catch (\Throwable $th) {
                    $error = $th;
                }

                // Recoge el valor del último registro
                $postId = $dbConn->lastInsertId();
                $dbConn = "";

                // Definimos el mensaje de resultado

                if ($postId) {
                    $msg = "Email registrado exitosamente con id: {$postId}";
                } else {
                    $msg = "Lo siento, pero su email no ha podido ser registrado debido a: {$error}";
                }
            }
        }
    }
    ?>
    <!-- Este es el Html de la aplicación -->
    <h2>Registro y validación de emails</h2>
    <p><span class="error">* required field</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        E-mail: <input type="text" name="email" value="<?php echo $email; ?>">
        <span class="error">* <?php echo $emailErr; ?></span>
        <br><br>

        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    // Emitimos mensaje de confirmación

    echo "<h2>Your Input:</h2>";

    echo $msg;
    echo "<br>";

    ?>

</body>

</html>