<?php
/* Incluyendo el archivo connection.php e iniciando la sesión. */
include '../../connection.php';

session_start();

/* Comprobando si el usuario ha iniciado sesión. Si no, lo redirige a la página de inicio de sesión. */
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

        <title>Escuela - Carbajal</title>

        <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="../styles/css/main.css">
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <body>

        <header>
            <div class="logotype">
                <i class="fa-solid fa-copyright"></i>
            </div>
            <h2>Editar escuela</h2>
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
        <?php
        if (isset($_POST['edit-school'])) {
            $school_name = $mysqli->real_escape_string($_POST['school-name']);
            $turn = $mysqli->real_escape_string($_POST['turn']);
            $sector = $mysqli->real_escape_string($_POST['sector']);
            $zone = $mysqli->real_escape_string($_POST['zone']);
            $period = $mysqli->real_escape_string($_POST['period']);
            $organization = $mysqli->real_escape_string($_POST['organization']);
            $category = $mysqli->real_escape_string($_POST['category']);
            $phone = $mysqli->real_escape_string($_POST['phone']);
            $director = $mysqli->real_escape_string($_POST['director']);
            $supervisor = $mysqli->real_escape_string($_POST['supervisor']);
            $sector_boss = $mysqli->real_escape_string($_POST['sector-boss']);
            $address = $mysqli->real_escape_string($_POST['address']);
            $locality = $mysqli->real_escape_string($_POST['locality']);
            $municipality = $mysqli->real_escape_string($_POST['municipality']);
        
            if (isset($school_name, $turn, $sector, $zone, $period, $organization, $category, $phone, $director, $supervisor, $sector_boss, $address, $locality, $municipality)) {
                if (
                    empty($school_name) || empty($turn) || empty($sector) || empty($zone) || empty($period) || empty($organization) || empty($category) || empty($phone) || empty($director)
                    || empty($supervisor) || empty($sector_boss) || empty($address) || empty($locality) || empty($municipality)
                ) {
                    if (empty($school_name)) {
                        $caution_school_name[] = "Nombre de la escuela olvidado";
                    }
                    if (empty($turn)) {
                        $caution_turn[] = "Turno olvidado";
                    }
                    if (empty($sector)) {
                        $caution_sector[] = "Sector olvidado";
                    }
                    if (empty($zone)) {
                        $caution_zone[] = "Zona olvidado";
                    }
                    if (empty($period)) {
                        $caution_period[] = "Periodo olvidado";
                    }
                    if (empty($organization)) {
                        $caution_organization[] = "Organización olvidado";
                    }
                    if (empty($category)) {
                        $caution_category[] = "Categoria olvidado";
                    }
                    if (empty($phone)) {
                        $caution_phone[] = "Teléfono olvidado";
                    }
                    if (empty($director)) {
                        $caution_director[] = "Director olvidado";
                    }
                    if (empty($supervisor)) {
                        $caution_supervisor[] = "Supervisor olvidado";
                    }
                    if (empty($sector_boss)) {
                        $caution_sector_boss[] = "Jefe de sector olvidado";
                    }
                    if (empty($address)) {
                        $caution_address[] = "Dirección olvidado";
                    }
                    if (empty($locality)) {
                        $caution_locality[] = "Localidad olvidado";
                    }
                    if (empty($municipality)) {
                        $caution_municipality[] = "Municipio olvidado";
                    }
                } else {
                    $query_edit_school = $mysqli->query("UPDATE escuela SET nombre = '$school_name', turno = '$turn',
                    sector = '$sector', zona = '$zone', periodo = '$period', organizacion = '$organization', 
                    categoria = '$category', telefono = '$phone', director = '$director', supervisor = '$supervisor',
                    jefe_sector = '$sector_boss', direccion = '$address', localidad = '$locality', municipio = '$municipality' WHERE clave = '07DPR2256D'");
                    if (isset($query_edit_school)) {
                        header("Location: school.php");
                    }
                }
            }
        }
        
        $query_show_school = $mysqli->query("SELECT*FROM escuela WHERE clave = '07DPR2256D'");
        if (isset($query_show_school)) {
            $row_show_school = $query_show_school->num_rows;
            if ($row_show_school == 1) {
                $fetch_show_school = $query_show_school->fetch_assoc();
            }
        }
        ?>
        <section class="edit-school">
            <form action="" method="post">
                <div class="input-school">
                    <div class="school-data">
                        <h3>Datos escolares</h3>
                        <div class="school-name">
                            <label for="school-name">Nombre de la escuela</label>
                            <input type="text" placeholder="Maria Gut" name="school-name" id="school-name" value="<?php if (isset($fetch_show_school['nombre'])) {
                                                                                                                        echo $fetch_show_school['nombre'];
                                                                                                                    } ?>">
                            <?php
                            if (isset($caution_school_name)) {
                                foreach ($caution_school_name as $c) {
                                    echo '<div class="caution-school-name"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="turn">
                            <label for="turn">Turno</label>
                            <input type="text" placeholder="Matu" name="turn" id="turn" value="<?php if (isset($fetch_show_school['turno'])) {
                                                                                                    echo $fetch_show_school['turno'];
                                                                                                } ?>">
                            <?php
                            if (isset($caution_turn)) {
                                foreach ($caution_turn as $c) {
                                    echo '<div class="caution-turn"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="sector">
                            <label for="sector">Sector</label>
                            <input type="text" placeholder="XX" name="sector" id="sector" value="<?php if (isset($fetch_show_school['sector'])) {
                                                                                                        echo $fetch_show_school['sector'];
                                                                                                    } ?>">
                            <?php
                            if (isset($caution_sector)) {
                                foreach ($caution_sector as $c) {
                                    echo '<div class="caution-sector"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="zone">
                            <label for="zone">Zona</label>
                            <input type="text" placeholder="XXX" name="zone" id="zone" value="<?php if (isset($fetch_show_school['zona'])) {
                                                                                                    echo $fetch_show_school['zona'];
                                                                                                } ?>">
                            <?php
                            if (isset($caution_zone)) {
                                foreach ($caution_zone as $c) {
                                    echo '<div class="caution-zone"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="period">
                            <label for="period">Periodo</label>
                            <input type="text" placeholder="Enero - A" name="period" id="period" value="<?php if (isset($fetch_show_school['periodo'])) {
                                                                                                            echo $fetch_show_school['periodo'];
                                                                                                        } ?>">
                            <?php
                            if (isset($caution_period)) {
                                foreach ($caution_period as $c) {
                                    echo '<div class="caution-period"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="organization">
                            <label for="organization">Organización</label>
                            <input type="text" placeholder="Grado" name="organization" id="organization" value="<?php if (isset($fetch_show_school['organizacion'])) {
                                                                                                                    echo $fetch_show_school['organizacion'];
                                                                                                                } ?>">
                            <?php
                            if (isset($caution_organization)) {
                                foreach ($caution_organization as $c) {
                                    echo '<div class="caution-organization"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>

                        <div class="category">
                            <label for="category">Categoria</label>
                            <input type="text" placeholder="Rural" name="category" id="category" value="<?php if (isset($fetch_show_school['categoria'])) {
                                                                                                            echo $fetch_show_school['categoria'];
                                                                                                        } ?>">
                            <?php
                            if (isset($caution_category)) {
                                foreach ($caution_category as $c) {
                                    echo '<div class="caution-category"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="phone">
                            <label for="phone">Telefono</label>
                            <input type="text" placeholder="XXX-XXX-XX-XX" name="phone" id="phone" value="<?php if (isset($fetch_show_school['telefono'])) {
                                                                                                                echo $fetch_show_school['telefono'];
                                                                                                            } ?>">
                            <?php
                            if (isset($caution_phone)) {
                                foreach ($caution_phone as $c) {
                                    echo '<div class="caution-phone"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="staff">
                        <h3>Personal de trabajo</h3>
                        <div class="director">
                            <label for="director">Director</label>
                            <input type="text" placeholder="Carlos A" name="director" id="director" value="<?php if (isset($fetch_show_school['director'])) {
                                                                                                                echo $fetch_show_school['director'];
                                                                                                            } ?>">
                            <?php
                            if (isset($caution_director)) {
                                foreach ($caution_director as $c) {
                                    echo '<div class="caution-director"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="supervisor">
                            <label for="supervisor">Supervisor</label>
                            <input type="text" placeholder="Mario O" name="supervisor" id="supervisor" value="<?php if (isset($fetch_show_school['supervisor'])) {
                                                                                                                    echo $fetch_show_school['supervisor'];
                                                                                                                } ?>">
                            <?php
                            if (isset($caution_supervisor)) {
                                foreach ($caution_supervisor as $c) {
                                    echo '<div class="caution-supervisor"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="sector-boss">
                            <label for="sector-boss">Jefe de sector</label>
                            <input type="text" placeholder="Jose P" name="sector-boss" id="sector-boss" value="<?php if (isset($fetch_show_school['jefe_sector'])) {
                                                                                                                    echo $fetch_show_school['jefe_sector'];
                                                                                                                } ?>">
                            <?php
                            if (isset($caution_sector_boss)) {
                                foreach ($caution_sector_boss as $c) {
                                    echo '<div class="caution-sector-boss"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="location">
                        <h3>Ubicación</h3>
                        <div class="address">
                            <label for="address">Dirección</label>
                            <input type="text" placeholder="Calle X" name="address" id="address" value="<?php if (isset($fetch_show_school['direccion'])) {
                                                                                                            echo $fetch_show_school['direccion'];
                                                                                                        } ?>">
                            <?php
                            if (isset($caution_address)) {
                                foreach ($caution_address as $c) {
                                    echo '<div class="caution-address"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="locality">
                            <label for="locality">Localidad</label>
                            <input type="text" placeholder="Tuxt" name="locality" id="locality" value="<?php if (isset($fetch_show_school['localidad'])) {
                                                                                                            echo $fetch_show_school['localidad'];
                                                                                                        } ?>">
                            <?php
                            if (isset($caution_locality)) {
                                foreach ($caution_locality as $c) {
                                    echo '<div class="caution-locality"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="municipality">
                            <label for="municipality">Municipio</label>
                            <input type="text" placeholder="Tuxt" name="municipality" id="municipality" value="<?php if (isset($fetch_show_school['municipio'])) {
                                                                                                                    echo $fetch_show_school['municipio'];
                                                                                                                } ?>">
                            <?php
                            if (isset($caution_municipality)) {
                                foreach ($caution_municipality as $c) {
                                    echo '<div class="caution-municipality"><p>' . $c . '</p></div>';
                                }
                            }
                            ?>
                        </div>

                    </div>
                </div>
                <a href="school.php"><i class="fa-solid fa-arrow-left"></i></a>
                <button type="submit" name="edit-school" id="edit-school">Editar escuela</button>
            </form>
        </section>

        <script src="../scripts/school-warning.js"></script>
        <script src="../scripts/open-grid-and-profile.js"></script>
        <script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>
        <script src="https://kit.fontawesome.com/3f13eeb2ba.js" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
}
?>