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
            <h2>Estadisticas salones</h2>
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
                <a href="student-statistics.php" class="two-columns"><i class="bx bxs-user"></i>Alumnos</a>

                <form action="" method="post">
                    <select name="classroom">
                        <option value="<?php
                                        if (isset($_POST['classroom'])) {
                                            echo $_POST['classroom'];
                                        }
                                        ?>">
                            <?php
                            if (isset($_POST['classroom'])) {
                                echo $_POST['classroom'][0] . "° " . $_POST['classroom'][2];
                            } else {
                                echo "Seleccione un salón";
                            }
                            ?>
                        </option>
                        <?php
                        $query_teacher = $mysqli->query("SELECT*FROM docente");

                        if (isset($query_teacher)) {
                            while ($fetch_teacher = $query_teacher->fetch_assoc()) {
                        ?>
                                <option value="<?php echo $fetch_teacher['grado'] . " " . $fetch_teacher['grupo']; ?>">
                                    <?php echo $fetch_teacher['grado'] . "° " . $fetch_teacher['grupo']; ?>
                                </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                    <button type="submit" name="search-classroom"><i class="bx bx-search"></i></button>
                </form>

            </div>

            <?php
            if (isset($_POST['search-classroom'])) {
                if (isset($_POST['classroom'])) {
                    $_SESSION['grade'] = $_POST['classroom'][0];
                    $grade = $_SESSION['grade'];
                    $_SESSION['group'] = $_POST['classroom'][2];
                    $group = $_SESSION['group'];

                    $query_inscription_m = $mysqli->query("SELECT*FROM alta WHERE genero ='M' and grado ='$grade' and grupo ='$group' and fecha  BETWEEN '2022-02-01' and '2022-02-15'");
                    if (isset($query_inscription_m)) {
                        $row_inscription_m = $query_inscription_m->num_rows;
                    }

                    $query_inscription_f = $mysqli->query("SELECT*FROM alta WHERE genero ='F' and grado ='$grade' and grupo ='$group' and fecha  BETWEEN '2022-02-01' and '2022-02-15'");
                    if (isset($query_inscription_f)) {
                        $row_inscription_f = $query_inscription_f->num_rows;
                    }

                    $query_inscription = $mysqli->query("SELECT*FROM alta WHERE grado ='$grade' and grupo ='$group' and fecha  BETWEEN '2022-02-01' and '2022-02-15'");
                    if (isset($query_inscription)) {
                        $row_inscription = $query_inscription->num_rows;
                    }

                    $query_alta_m = $mysqli->query("SELECT*FROM alta WHERE genero ='M' and grado ='$grade' and grupo ='$group' and fecha  BETWEEN '2022-02-16' and '2022-12-31'");
                    if (isset($query_alta_m)) {
                        $row_alta_m = $query_alta_m->num_rows;
                    }

                    $query_alta_f = $mysqli->query("SELECT*FROM alta WHERE genero ='F' and grado ='$grade' and grupo ='$group' and fecha  BETWEEN '2022-02-16' and '2022-12-31'");
                    if (isset($query_alta_f)) {
                        $row_alta_f = $query_alta_f->num_rows;
                    }

                    $query_alta = $mysqli->query("SELECT*FROM alta WHERE grado ='$grade' and grupo ='$group' and fecha  BETWEEN '2022-02-16' and '2022-12-31'");
                    if (isset($query_alta)) {
                        $row_alta = $query_alta->num_rows;
                    }

                    $query_baja_m = $mysqli->query("SELECT*FROM baja WHERE genero ='M' and grado ='$grade' and grupo ='$group'");
                    if (isset($query_baja_m)) {
                        $row_baja_m = $query_baja_m->num_rows;
                    }

                    $query_baja_f = $mysqli->query("SELECT*FROM baja WHERE genero ='F' and grado ='$grade' and grupo ='$group'");
                    if (isset($query_baja_f)) {
                        $row_baja_f = $query_baja_f->num_rows;
                    }

                    $query_baja = $mysqli->query("SELECT*FROM baja WHERE grado ='$grade' and grupo ='$group'");
                    if (isset($query_baja)) {
                        $row_baja = $query_baja->num_rows;
                    }

                    $query_exists_m = $mysqli->query("SELECT*FROM alumno WHERE genero ='M' and grado ='$grade' and grupo ='$group'");
                    if (isset($query_exists_m)) {
                        $row_exists_m = $query_exists_m->num_rows;
                    }

                    $query_exists_f = $mysqli->query("SELECT*FROM alumno WHERE genero ='F' and grado ='$grade' and grupo ='$group'");
                    if (isset($query_exists_f)) {
                        $row_exists_f = $query_exists_f->num_rows;
                    }

                    $query_exists = $mysqli->query("SELECT*FROM alumno WHERE grado ='$grade' and grupo ='$group'");
                    if (isset($query_exists)) {
                        $row_exists = $query_exists->num_rows;
                    }

                    $query_name_matter = $mysqli->query("SELECT*FROM materia WHERE grado ='$grade'");
                }
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
            <div class="module-student">
                <span>Materias</span>
                <div class="information">
                    <?php
                    if (isset($_SESSION['grade'])) $grade = $_SESSION['grade'];
                    if (isset($_SESSION['group'])) $group = $_SESSION['group'];

                    if (isset($query_name_matter)) {
                        while ($fetch_name_matter = $query_name_matter->fetch_assoc()) {
                            if (isset($fetch_name_matter['id_materia'])) $id_matter = $fetch_name_matter['id_materia'];

                            $query_average = $mysqli->query("SELECT SUM(promedio), COUNT(promedio) FROM calificacion WHERE id_materia ='$id_matter' and grado ='$grade' and grupo ='$group'");
                            if (isset($query_average)) {
                                $fetch_average = $query_average->fetch_assoc();

                                if (isset($fetch_average['SUM(promedio)'])) $sum_average = $fetch_average['SUM(promedio)'];
                                if (isset($fetch_average['COUNT(promedio)'])) $count_average = $fetch_average['COUNT(promedio)'];

                                if ($count_average == 0) {
                                    $sum_average = 0;
                                } else {
                                    $sum_average = ($sum_average / $count_average);
                                }
                            }
                    ?>
                            <span><?php if (isset($fetch_name_matter['nombre'])) echo $name = substr($fetch_name_matter['nombre'], 0, 3); ?></span>
                            <p><?php echo round($sum_average, 1); ?></p>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
                    <?php 
                    $query_count_qualification = $mysqli->query("SELECT COUNT(promedio) FROM calificacion WHERE grado ='$grade' and grupo ='$group'");
                    if(isset($query_count_qualification)){
                        $fetch_count_qualification = $query_count_qualification->fetch_assoc();

                        if(isset($fetch_count_qualification['COUNT(promedio)'])) $count_qualification = $fetch_count_qualification['COUNT(promedio)'];
                    }

                    $query_count_approved = $mysqli->query("SELECT COUNT(promedio) FROM calificacion WHERE promedio >= '6' and  grado ='$grade' and grupo ='$group'");
                    if(isset($query_count_approved)){
                        $fetch_count_approved = $query_count_approved->fetch_assoc();

                        if(isset($fetch_count_approved['COUNT(promedio)'])) {
                            $count_approved = $fetch_count_approved['COUNT(promedio)'];

                            if($count_approved == 0){
                                $percentage_approved = 0;
                            }else{
                                $percentage_approved = ($count_approved * 100) / $count_qualification;
                            }
                        }


                    }

                    $query_count_failed = $mysqli->query("SELECT COUNT(promedio) FROM calificacion WHERE promedio <= '5.99' and  grado ='$grade' and grupo ='$group'");
                    if(isset($query_count_failed)){
                        $fetch_count_failed = $query_count_failed->fetch_assoc();

                        if(isset($fetch_count_failed['COUNT(promedio)'])) {
                            $count_failed = $fetch_count_failed['COUNT(promedio)'];
                        
                            if($count_failed == 0){
                                $percentage_failed = 0;
                            }else{
                                $percentage_failed = ($count_failed * 100) / $count_qualification;
                            }
                        }
                    }

                    
                    ?>
            <div class="module-student">
                <span>Aprobados</span>
                <div class="information">
                    <p><?php if (isset($percentage_approved)) echo $percentage_approved; ?> %</p>
                </div>
            </div>
            <div class="module-student">
                <span>Reprobados</span>
                <div class="information">
                    <p><?php if (isset($percentage_failed)) echo $percentage_failed; ?> %</p>
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