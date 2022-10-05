<?php
/* Incluyendo el archivo connection.php e iniciando la sesión. */
include '../../connection.php';

session_start();

/* Comprobando si el usuario ha iniciado sesión. Si no, redirige a la página de inicio de sesión. */
if (!isset($_SESSION['user-is']))  header("Location: ../../index.php");

if (isset($_SESSION['user-is'])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Emmanuel Paniagua Figueroa">
        <meta name="description" content="Control Carbajal es una aplicación desarrollada para la gestion del control escolar de la Primaria 
        Maria Gutierrez Carbajal mediante tecnologias como PHP, HTML, CSS y JS.">

        <title>Estadisticas - Carbajal</title>

        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="../styles/css/main.css">
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <body>

        <header>
            <div class="logotype">
                <i class="fa-solid fa-copyright"></i>
            </div>
            <h2>Estadisticas general</h2>
            <div class="navigation">
                <a href="home-page.php"><i class="bx bxs-home"></i> </a>
                <i class='bx bxs-grid-alt' id="bxs-grid-alt" tabindex="0"></i>
            </div>
        </header>

        <section class="menu" id="menu">
            <p>Menu</p>
            <div class="sub-menu">
                <a href="school.php"><i class="bx bxs-graduation"></i>
                    <p>Escuela</p>
                </a>
                <a href="personal.php"><i class="bx bxs-user"></i>
                    <p>Personal</p>
                </a>
                <a href="teacher.php"><i class="bx bxs-chalkboard"></i>
                    <p>Docente</p>
                </a>
                <a href="student.php"><i class="bx bxs-group"></i>
                    <p>Alumnos</p>
                </a>
                <a href="statistics.php"><i class="bx bxs-bar-chart-alt-2"></i>
                    <p>Estadisticas</p>
                </a>
                <a href="log-out.php" class="log-out"><i class='bx bxs-x-circle'></i>
                    <p>Cerrar sesión</p>
                </a>
            </div>
        </section>

        <section class="show-statistics">

            <div class="navigation">
                <a href="student-statistics.php" class="two-columns"><i class="bx bxs-user"></i>Alumnos</a>
                <a href="classroom-statistics.php" class="two-columns"><i class="bx bxs-group"></i>Salones</a>
            </div>

            <?php
            $query_inscription_m = $mysqli->query("SELECT*FROM alta WHERE genero ='M' and fecha  BETWEEN '2022-02-01' and '2022-02-15'");
            if (isset($query_inscription_m)) {
                $row_inscription_m = $query_inscription_m->num_rows;
            }

            $query_inscription_f = $mysqli->query("SELECT*FROM alta WHERE genero ='F' and fecha  BETWEEN '2022-02-01' and '2022-02-15'");
            if (isset($query_inscription_f)) {
                $row_inscription_f = $query_inscription_f->num_rows;
            }

            $query_inscription = $mysqli->query("SELECT*FROM alta WHERE fecha  BETWEEN '2022-02-01' and '2022-02-15'");
            if (isset($query_inscription)) {
                $row_inscription = $query_inscription->num_rows;
            }

            $query_alta_m = $mysqli->query("SELECT*FROM alta WHERE genero ='M' and fecha  BETWEEN '2022-02-16' and '2022-12-31'");
            if (isset($query_alta_m)) {
                $row_alta_m = $query_alta_m->num_rows;
            }

            $query_alta_f = $mysqli->query("SELECT*FROM alta WHERE genero ='F' and fecha  BETWEEN '2022-02-16' and '2022-12-31'");
            if (isset($query_alta_f)) {
                $row_alta_f = $query_alta_f->num_rows;
            }

            $query_alta = $mysqli->query("SELECT*FROM alta WHERE fecha  BETWEEN '2022-02-16' and '2022-12-31'");
            if (isset($query_alta)) {
                $row_alta = $query_alta->num_rows;
            }

            $query_baja_m = $mysqli->query("SELECT*FROM baja WHERE genero ='M'");
            if (isset($query_baja_m)) {
                $row_baja_m = $query_baja_m->num_rows;
            }

            $query_baja_f = $mysqli->query("SELECT*FROM baja WHERE genero ='F'");
            if (isset($query_baja_f)) {
                $row_baja_f = $query_baja_f->num_rows;
            }

            $query_baja = $mysqli->query("SELECT*FROM baja");
            if (isset($query_baja)) {
                $row_baja = $query_baja->num_rows;
            }

            $query_exists_m = $mysqli->query("SELECT*FROM alumno WHERE genero ='M'");
            if (isset($query_exists_m)) {
                $row_exists_m = $query_exists_m->num_rows;
            }

            $query_exists_f = $mysqli->query("SELECT*FROM alumno WHERE genero ='F'");
            if (isset($query_exists_f)) {
                $row_exists_f = $query_exists_f->num_rows;
            }

            $query_exists = $mysqli->query("SELECT*FROM alumno");
            if (isset($query_exists)) {
                $row_exists = $query_exists->num_rows;
            }

            ?>
            <div class="module-personal">
                <span>Inscripción inicial</span>
                <div class="information">
                    <span>H</span>
                    <p><?php if (isset($row_inscription_m)) echo $row_inscription_m; ?></p>
                    <span>M</span>
                    <p><?php if (isset($row_inscription_f)) echo $row_inscription_f; ?></p>
                    <span>T</span>
                    <p><?php if (isset($row_inscription)) echo $row_inscription; ?></p>
                </div>
            </div>

            <div class="module-teacher">
                <span>Altas</span>
                <div class="information">
                    <span>H</span>
                    <p><?php if (isset($row_alta_m)) echo $row_alta_m; ?></p>
                    <span>M</span>
                    <p><?php if (isset($row_alta_f)) echo $row_alta_f; ?></p>
                    <span>T</span>
                    <p><?php if (isset($row_alta)) echo $row_alta; ?></p>
                </div>
            </div>
            <div class="module-student">
                <span>Bajas</span>
                <div class="information">
                    <span>H</span>
                    <p><?php if (isset($row_baja_m)) echo $row_baja_m; ?></p>
                    <span>M</span>
                    <p><?php if (isset($row_baja_f)) echo $row_baja_f; ?></p>
                    <span>T</span>
                    <p><?php if (isset($row_baja)) echo $row_baja; ?></p>
                </div>
            </div>
            <div class="module-student">
                <span>Existentes</span>
                <div class="information">
                    <span>H</span>
                    <p><?php if (isset($row_exists_m)) echo $row_exists_m; ?></p>
                    <span>M</span>
                    <p><?php if (isset($row_exists_f)) echo $row_exists_f; ?></p>
                    <span>T</span>
                    <p><?php if (isset($row_exists)) echo $row_exists; ?></p>
                </div>
            </div>
        </section>

        <script src="../scripts/open-grid-and-profile.js"></script>
        <script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>
        <script src="https://kit.fontawesome.com/3f13eeb2ba.js" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
}
?>