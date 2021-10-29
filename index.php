<?php
include('eventos.php');
$eventos = $cn->query("SELECT * FROM eventos");
$profesores = $cn->query("SELECT * FROM adminuser where tipo = 2");
$alumnos = $cn->query("SELECT * FROM adminuser where tipo = 4");


// echo json_encode($eventos);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='lib/main.css' rel='stylesheet' />
    <script src='lib/main.js'></script>
    <script src='lib/locales/es.js'></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha256-7dA7lq5P94hkBsWdff7qobYkp9ope/L5LQy2t/ljPLo=" crossorigin="anonymous"></script>
    <!-- select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js" integrity="sha256-AFAYEOkzB6iIKnTYZOdUf9FFje6lOTYdwRJKwTN5mks=" crossorigin="anonymous"></script>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" integrity="sha256-FdatTf20PQr/rWg+cAKfl6j4/IY3oohFAJ7gVC3M34E=" crossorigin="anonymous">

    <!-- select2-bootstrap4-theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css"> <!-- for live demo page -->

</head>
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
        font-size: 14px;
    }

    #script-warning {
        display: none;
        background: #eee;
        border-bottom: 1px solid #ddd;
        padding: 0 10px;
        line-height: 40px;
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        color: red;
    }

    #loading {
        display: none;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    #calendar {
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 10px;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {

            headerToolbar: {
                left: 'prev,next today Miboton',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },

            // Añadir color al evento

            events: [{ // this object will be "parsed" into an Event Object
                    title: 'Evento 1',
                    descripcion: 'esto es una prueba para el evento 1',
                    start: '2021-10-25T10:30:00',
                    end: '2021-10-25T11:30:00',
                    // extendedProps: {
                    //     department: 'BioChemistry'
                    // },
                    color: 'yellow', // an option!
                    textColor: 'black', // an option!
                },
                <?php
                foreach ($eventos as $show) {
                ?> {
                        id: '<?php echo $show["id"]; ?>',
                        title: '<?php echo $show["title"]; ?>',
                        descripcion: '<?php echo $show["nota"]; ?>',
                        profesor: '<?php echo $show["id_profe"]; ?>',
                        alumno: '<?php echo $show["id_alumno"]; ?>',
                        color: '<?php echo $show["color"]; ?>',
                        textColor: '<?php echo $show["textColor"]; ?>',
                        start: '<?php echo $show["fecha_start"]; ?>',
                        end: '<?php echo $show["fecha_end"]; ?>',

                    },
                <?php } ?>
            ],

            eventClick: function(info) {
                // info.jsEvent.preventDefault(); // don't let the browser navigate

                console.log();
                // if (info.event.url) {
                // window.open(info.event.url);
                $('#tituloEvento').html(info.event.title);
                $('#descripcionEvento').html(info.event.extendedProps.descripcion);
                $('#eventoDetalle').modal('toggle');
                // }
            },
            customButtons: {
                Miboton: {
                    text: "Botón 1",
                    click: function() {
                        alert("accion del bonto");
                    }
                }
            },
            // PARA DAR FUNCIONALIDAD A TODO EL DIA DEL CALENDARIO
            dateClick: function(info) {
                $('#FechaDia').html(info.dateStr);
                info.dayEl.style.backgroundColor = '#cccccc';
                $('#eventosDia').modal('toggle');
            },

            // -------------------------------------------------------

            // PARA DAR FUNCIONALIDA AL EVENTO CON URL


        });
        calendar.setOption('locale', 'Es');
        calendar.render();
    });
</script>
<script type="text/javascript">
    $(function() {
        $('#eventosDia').on('hidden.bs.modal', function(e) {
            console.log("Modal hidden");
            // $("#placeholder-div1").html("");
            // $('#eventosDia').removeData("modal");
            $('#titulo').val('');
        });
    });
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>

<body>
    <div class="modal fade" id="eventoDetalle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloEvento">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 id="descripcionEvento"></h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Agregar</button>
                    <button type="button" class="btn btn-info">Modificar</button>
                    <button type="button" class="btn btn-danger">Borrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Clases del día - <h6 class="modal-title" id="FechaDia"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Titulo</label>
                            <input type="text" class="form-control" id="titulo" aria-describedby="emailHelp" value="">
                        </div>
                        <label for="exampleDataList" class="form-label">Datalist example</label>
                        <select class="js-example-basic-single">
                            <option value="AL">Alabama</option>
                            ...
                            <option value="WY">Wyoming</option>
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Agregar Clase</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="eventosDia">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crear Clase </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Profesor</label>
                            <select class="js-example-basic-single form-control">
                                <?php
                                foreach ($profesores as $prof) {
                                ?>
                                    <option value="<?php echo $prof['id'] ?>"><?php echo $prof['nombres'], ' ', $prof['apellidos'] ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Alumno</label>
                            <select class="js-example-basic-single form-control">
                                <?php
                                foreach ($alumnos as $alum) {
                                ?>
                                    <option value="<?php echo $alum['id'] ?>"><?php echo $alum['nombres'], ' ', $alum['apellidos'] ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Curso</label>
                            <input type="text" class="form-control" placeholder="Piano de 18 +" aria-describedby="emailHelp" disabled>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Fecha Inicio</label>
                                    <input type="datetime-local" class="form-control" id="fecha_start">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Fecha Inicio</label>
                                    <input type="datetime-local" class="form-control" id="fecha_end">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Zoom</label>
                                    <button type="submit" class="btn btn-primary mb-2">Generar link Zoom</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="https://zoom.us/j/97666123210?pwd=SUlVRjV6VTZHdTZOYiszRE84NDZGdz09" aria-describedby="emailHelp" disabled>
                        </div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <div id='calendar'></div>

    <script>
        function select2(size) {
            $("select").each(function() {
                $(this).select2({
                    theme: "bootstrap-4",
                    width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
                    placeholder: $(this).data("placeholder"),
                    allowClear: Boolean($(this).data("allow-clear")),
                    closeOnSelect: !$(this).attr("multiple"),
                    containerCssClass: size == "small" || size == "large" ? "select2--" + size : "",
                    selectionCssClass: size == "small" || size == "large" ? "select2--" + size : "",
                    dropdownCssClass: size == "small" || size == "large" ? "select2--" + size : "",
                });
            });
        }

        select2()

        var buttons = document.querySelectorAll(".select2-size")

        buttons.forEach(function(button) {
            var id = button.id
            button.addEventListener("click", function(e) {
                e.preventDefault()
                select2(id)
                document.querySelectorAll(".select2-size").forEach(function(item) {
                    item.classList.remove("active")
                })

                this.classList.add("active")
            })
        })
    </script>
</body>

</html>