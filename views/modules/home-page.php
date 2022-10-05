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

if (isset($_SESSION['grade'])) {
    unset($_SESSION['grade']);
}

if (isset($_SESSION['group'])) {
    unset($_SESSION['group']);
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

        <title>Inicio - Carbajal</title>

        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="../styles/css/main.css">
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <body>

        <header>
            <div class="logotype">
                <i class="fa-solid fa-copyright"></i>
            </div>
            <h2>Inicio</h2>
            <div class="navigation one">
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
        <section class="show-modules">
            <div class="module-school">
                <span>Escuela</span>
                <div class="information">
                    <?php
                    $query_school = $mysqli->query("SELECT*FROM escuela");
                    if (isset($query_school)) {
                        $fetch_school = $query_school->fetch_assoc();
                    }
                    ?>

                    <p><?php echo $fetch_school['clave']; ?></p>
                    <p><?php echo $fetch_school['nombre']; ?></p>
                    <p><?php echo $fetch_school['turno']; ?></p>
                    <p><?php echo $fetch_school['sector']; ?></p>
                    <p><?php echo $fetch_school['zona']; ?></p>

                </div>
                <span>Director</span>
                <div class="information">
                    <?php
                    $query_personal = $mysqli->query("SELECT*FROM personal");
                    if (isset($query_personal)) {
                        $fetch_personal = $query_personal->fetch_assoc();
                    }
                    ?>
                    <p><?php echo $fetch_personal['nombre_completo']; ?></p>
                </div>
            </div>
            <div class="module-personal">
                <span>Personal</span>
                <div class="information">
                    <?php
                    $query_personal_m = $mysqli->query("SELECT*FROM personal WHERE genero ='M'");
                    if (isset($query_personal_m)) {
                        $row_personal_m = $query_personal_m->num_rows;
                    }

                    $query_personal_f = $mysqli->query("SELECT*FROM personal WHERE genero ='F'");
                    if (isset($query_personal_f)) {
                        $row_personal_f = $query_personal_f->num_rows;
                    }

                    $query_personal = $mysqli->query("SELECT*FROM personal");
                    if (isset($query_personal)) {
                        $row_personal = $query_personal->num_rows;
                    }
                    ?>
                    <span>H</span>
                    <p><?php echo $row_personal_m; ?></p>
                    <span>M</span>
                    <p><?php echo $row_personal_f; ?></p>
                    <span>T</span>
                    <p><?php echo $row_personal; ?></p>

                </div>
            </div>

            <div class="module-teacher">
                <span>Docentes</span>
                <div class="information">
                    <?php
                    $query_teacher_m = $mysqli->query("SELECT*FROM personal WHERE genero ='M' and funcion ='Docente'");
                    if (isset($query_teacher_m)) {
                        $row_teacher_m = $query_teacher_m->num_rows;
                    }

                    $query_teacher_f = $mysqli->query("SELECT*FROM personal WHERE genero ='F' and funcion ='Docente'");
                    if (isset($query_teacher_f)) {
                        $row_teacher_f = $query_teacher_f->num_rows;
                    }

                    $query_teacher = $mysqli->query("SELECT*FROM personal WHERE funcion ='Docente'");
                    if (isset($query_teacher)) {
                        $row_teacher = $query_teacher->num_rows;
                    }
                    ?>
                    <span>H</span>
                    <p><?php echo $row_teacher_m; ?></p>
                    <span>M</span>
                    <p><?php echo $row_teacher_f; ?></p>
                    <span>T</span>
                    <p><?php echo $row_teacher; ?></p>
                </div>
            </div>
            <div class="module-student">
                <span>Alumnos</span>
                <div class="information">
                    <?php
                    $query_student_m = $mysqli->query("SELECT*FROM alumno WHERE genero ='M'");
                    if (isset($query_student_m)) {
                        $row_student_m = $query_student_m->num_rows;
                    }

                    $query_student_f = $mysqli->query("SELECT*FROM alumno WHERE genero ='F'");
                    if (isset($query_student_f)) {
                        $row_student_f = $query_student_f->num_rows;
                    }

                    $query_student = $mysqli->query("SELECT*FROM alumno");
                    if (isset($query_student)) {
                        $row_student = $query_student->num_rows;
                    }
                    ?>
                    <span>H</span>
                    <p><?php echo $row_student_m; ?></p>
                    <span>M</span>
                    <p><?php echo $row_student_f; ?></p>
                    <span>T</span>
                    <p><?php echo $row_student; ?></p>
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