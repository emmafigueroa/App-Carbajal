<?php
/* Incluyendo el archivo connection.php e iniciando la sesión. */
include '../../connection.php';

session_start();

/* Comprobando si el usuario ha iniciado sesión. Si no, redirige a la página de inicio de sesión. */
if (!isset($_SESSION['user-is']))  header("Location: ../../index.php");

if (isset($_SESSION['id-personal'])) {
    unset($_SESSION['id-personal']);
}

if (isset($_SESSION['id-teacher'])) {
    unset($_SESSION['id-teacher']);
}

if (isset($_SESSION['id-student'])) {
    unset($_SESSION['id-student']);
}

if (isset($_SESSION['id-qualification'])) {
    unset($_SESSION['id-qualification']);
}

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
            <h2>Estadisticas alumnos</h2>
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
                <a href="statistics.php" class="one-columns"><i class="fa-solid fa-arrow-left"></i></a>
                <a href="classroom-statistics.php" class="two-columns"><i class="bx bxs-group"></i>Salones</a>
            </div>


            <?php
            $query_age5_m = $mysqli->query("SELECT*FROM alumno WHERE genero ='M' and edad='5'");
            if (isset($query_age5_m)) {
                $row_age5_m = $query_age5_m->num_rows;
            }

            $query_age5_f = $mysqli->query("SELECT*FROM alumno WHERE genero ='F' and edad='5'");
            if (isset($query_age5_f)) {
                $row_age5_f = $query_age5_f->num_rows;
            }

            $query_age5 = $mysqli->query("SELECT*FROM alumno WHERE edad='5'");
            if (isset($query_age5)) {
                $row_age5 = $query_age5->num_rows;
            }

            $query_age6_m = $mysqli->query("SELECT*FROM alumno WHERE genero ='M' and edad='6'");
            if (isset($query_age6_m)) {
                $row_age6_m = $query_age6_m->num_rows;
            }

            $query_age6_f = $mysqli->query("SELECT*FROM alumno WHERE genero ='F' and edad='6'");
            if (isset($query_age6_f)) {
                $row_age6_f = $query_age6_f->num_rows;
            }

            $query_age6 = $mysqli->query("SELECT*FROM alumno WHERE edad='6'");
            if (isset($query_age6)) {
                $row_age6 = $query_age6->num_rows;
            }

            $query_age7_m = $mysqli->query("SELECT*FROM alumno WHERE genero ='M' and edad='7'");
            if (isset($query_age7_m)) {
                $row_age7_m = $query_age7_m->num_rows;
            }

            $query_age7_f = $mysqli->query("SELECT*FROM alumno WHERE genero ='F' and edad='7'");
            if (isset($query_age7_f)) {
                $row_age7_f = $query_age7_f->num_rows;
            }

            $query_age7 = $mysqli->query("SELECT*FROM alumno WHERE edad='7'");
            if (isset($query_age7)) {
                $row_age7 = $query_age7->num_rows;
            }

            $query_age8_m = $mysqli->query("SELECT*FROM alumno WHERE genero ='M' and edad='8'");
            if (isset($query_age8_m)) {
                $row_age8_m = $query_age8_m->num_rows;
            }

            $query_age8_f = $mysqli->query("SELECT*FROM alumno WHERE genero ='F' and edad='8'");
            if (isset($query_age8_f)) {
                $row_age8_f = $query_age8_f->num_rows;
            }

            $query_age8 = $mysqli->query("SELECT*FROM alumno WHERE edad='8'");
            if (isset($query_age8)) {
                $row_age8 = $query_age8->num_rows;
            }

            $query_age9_m = $mysqli->query("SELECT*FROM alumno WHERE genero ='M' and edad='9'");
            if (isset($query_age9_m)) {
                $row_age9_m = $query_age9_m->num_rows;
            }

            $query_age9_f = $mysqli->query("SELECT*FROM alumno WHERE genero ='F' and edad='9'");
            if (isset($query_age9_f)) {
                $row_age9_f = $query_age9_f->num_rows;
            }

            $query_age9 = $mysqli->query("SELECT*FROM alumno WHERE edad='9'");
            if (isset($query_age9)) {
                $row_age9 = $query_age9->num_rows;
            }

            $query_age10_m = $mysqli->query("SELECT*FROM alumno WHERE genero ='M' and edad='10'");
            if (isset($query_age10_m)) {
                $row_age10_m = $query_age10_m->num_rows;
            }

            $query_age10_f = $mysqli->query("SELECT*FROM alumno WHERE genero ='F' and edad='10'");
            if (isset($query_age10_f)) {
                $row_age10_f = $query_age10_f->num_rows;
            }

            $query_age10 = $mysqli->query("SELECT*FROM alumno WHERE edad='10'");
            if (isset($query_age10)) {
                $row_age10 = $query_age10->num_rows;
            }

            $query_age11_m = $mysqli->query("SELECT*FROM alumno WHERE genero ='M' and edad='11'");
            if (isset($query_age11_m)) {
                $row_age11_m = $query_age11_m->num_rows;
            }

            $query_age11_f = $mysqli->query("SELECT*FROM alumno WHERE genero ='F' and edad='11'");
            if (isset($query_age11_f)) {
                $row_age11_f = $query_age11_f->num_rows;
            }

            $query_age11 = $mysqli->query("SELECT*FROM alumno WHERE edad='11'");
            if (isset($query_age11)) {
                $row_age11 = $query_age11->num_rows;
            }

            $query_age12_m = $mysqli->query("SELECT*FROM alumno WHERE genero ='M' and edad='12'");
            if (isset($query_age12_m)) {
                $row_age12_m = $query_age12_m->num_rows;
            }

            $query_age12_f = $mysqli->query("SELECT*FROM alumno WHERE genero ='F' and edad='12'");
            if (isset($query_age12_f)) {
                $row_age12_f = $query_age12_f->num_rows;
            }

            $query_age12 = $mysqli->query("SELECT*FROM alumno WHERE edad='12'");
            if (isset($query_age12)) {
                $row_age12 = $query_age12->num_rows;
            }

            $query_age13_m = $mysqli->query("SELECT*FROM alumno WHERE genero ='M' and edad='13'");
            if (isset($query_age13_m)) {
                $row_age13_m = $query_age13_m->num_rows;
            }

            $query_age13_f = $mysqli->query("SELECT*FROM alumno WHERE genero ='F' and edad='13'");
            if (isset($query_age13_f)) {
                $row_age13_f = $query_age13_f->num_rows;
            }

            $query_age13 = $mysqli->query("SELECT*FROM alumno WHERE edad='13'");
            if (isset($query_age13)) {
                $row_age13 = $query_age13->num_rows;
            }
            ?>

            <div class="module-student">
                <span>5 años</span>
                <div class="information">
                    <span>H</span>
                    <p><?php if (isset($row_age5_m)) echo $row_age5_m; ?></p>
                    <span>M</span>
                    <p><?php if (isset($row_age5_f)) echo $row_age5_f; ?></p>
                    <span>T</span>
                    <p><?php if (isset($row_age5)) echo $row_age5; ?></p>
                </div>
            </div>
            <div class="module-student">
                <span>6 años</span>
                <div class="information">
                    <span>H</span>
                    <p><?php if (isset($row_age6_m)) echo $row_age6_m; ?></p>
                    <span>M</span>
                    <p><?php if (isset($row_age6_f)) echo $row_age6_f; ?></p>
                    <span>T</span>
                    <p><?php if (isset($row_age6)) echo $row_age6; ?></p>
                </div>
            </div>
            <div class="module-student">
                <span>7 años</span>
                <div class="information">
                    <span>H</span>
                    <p><?php if (isset($row_age7_m)) echo $row_age7_m; ?></p>
                    <span>M</span>
                    <p><?php if (isset($row_age7_f)) echo $row_age7_f; ?></p>
                    <span>T</span>
                    <p><?php if (isset($row_age7)) echo $row_age7; ?></p>
                </div>
            </div>
            <div class="module-student">
                <span>8 años</span>
                <div class="information">
                    <span>H</span>
                    <p><?php if (isset($row_age8_m)) echo $row_age8_m; ?></p>
                    <span>M</span>
                    <p><?php if (isset($row_age8_f)) echo $row_age8_f; ?></p>
                    <span>T</span>
                    <p><?php if (isset($row_age8)) echo $row_age8; ?></p>
                </div>
            </div>
            <div class="module-student">
                <span>9 años</span>
                <div class="information">
                    <span>H</span>
                    <p><?php if (isset($row_age9_m)) echo $row_age9_m; ?></p>
                    <span>M</span>
                    <p><?php if (isset($row_age9_f)) echo $row_age9_f; ?></p>
                    <span>T</span>
                    <p><?php if (isset($row_age9)) echo $row_age9; ?></p>
                </div>
            </div>
            <div class="module-student">
                <span>10 años</span>
                <div class="information">
                    <span>H</span>
                    <p><?php if (isset($row_age10_m)) echo $row_age10_m; ?></p>
                    <span>M</span>
                    <p><?php if (isset($row_age10_f)) echo $row_age10_f; ?></p>
                    <span>T</span>
                    <p><?php if (isset($row_age10)) echo $row_age10; ?></p>
                </div>
            </div>
            <div class="module-student">
                <span>11 años</span>
                <div class="information">
                    <span>H</span>
                    <p><?php if (isset($row_age11_m)) echo $row_age11_m; ?></p>
                    <span>M</span>
                    <p><?php if (isset($row_age11_f)) echo $row_age11_f; ?></p>
                    <span>T</span>
                    <p><?php if (isset($row_age11)) echo $row_age11; ?></p>
                </div>
            </div>
            <div class="module-student">
                <span>12 años</span>
                <div class="information">
                    <span>H</span>
                    <p><?php if (isset($row_age12_m)) echo $row_age12_m; ?></p>
                    <span>M</span>
                    <p><?php if (isset($row_age12_f)) echo $row_age12_f; ?></p>
                    <span>T</span>
                    <p><?php if (isset($row_age12)) echo $row_age12; ?></p>
                </div>
            </div>
            <div class="module-student">
                <span>13 años</span>
                <div class="information">
                    <span>H</span>
                    <p><?php if (isset($row_age13_m)) echo $row_age13_m; ?></p>
                    <span>M</span>
                    <p><?php if (isset($row_age13_f)) echo $row_age13_f; ?></p>
                    <span>T</span>
                    <p><?php if (isset($row_age13)) echo $row_age13; ?></p>
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