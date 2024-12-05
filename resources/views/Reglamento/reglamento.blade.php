@extends('layouts.app')

@section('template_title')
    Reglamento Interno
@endsection

@section('content')
    <title>Reglamento del Colegio Particular Mixto "Shaddai"</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1;
            color: #333;
            max-width: 1500px;
            margin: 0 auto;
            padding: 5px;
        }
        h6, h5 {
            color: #2c3e50;
        }
        h6 {
            text-align: center;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
        }
        h6 {
            margin-top: 30px;
            background-color: #f2f2f2;
            padding: 10px;
            border-radius: 5px;
        }
        .student-info {
            background-color: #e6f3ff;
            padding: 5px;  /* Reducción de padding */
            border-radius: 5px;
            margin-bottom: 5px;  /* Reducción de margen inferior */
        }
        ul, ol {
            padding-left: 15px;
        }
        li {
            margin-bottom: 10px;
        }

    </style>

    <div class="contract-container">
        <div class="student-info" style="line-height: 1.2; font-size: 13px; margin-bottom: 4px;"> <!-- Reducir interlineado y fuente general -->
            <form method="POST" action="{{ route('buscarreglamento.alumno') }}">
                @csrf
                <div class="form-group" style="display: flex; align-items: center; width: 100%; margin-bottom: 4px;"> <!-- Reducir margen -->
                    <label for="codigo-correlativo" style="margin-right: 6px; white-space: nowrap; font-weight: bold; width: 140px; font-size: 12px;">CORRELATIVO ALUMNO:</label>
                    <input
                        type="text"
                        id="codigo-correlativo"
                        name="codigo_correlativo"
                        value="{{ old('codigo_correlativo', $codigoCorrelativo ?? '') }}"
                        required
                        style="flex-grow: 1; padding: 2px 6px; height: 24px; border: none; border-bottom: 1px solid #ccc; background-color: transparent; font-size: 12px;">
                    <button
                        type="submit"
                        class="btn btn-primary"
                        style="padding: 0 10px; height: 24px; border: none; background-color: #007bff; color: white; cursor: pointer; margin-left: 6px; font-size: 12px;">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </form>

            <!-- Alumno(a) Info -->
            <div style="display: flex; align-items: center; margin-bottom: 4px;"> <!-- Reducir margen -->
                <p style="margin-right: 6px; font-weight: bold; width: 140px; font-size: 12px;">ALUMNO(A):</p>
                <input type="text" value="{{ old('nombre_educando', $nombreEducando ?? '') }}" style="flex-grow: 1; padding: 2px 6px; height: 24px; border: none; border-bottom: 1px solid #ccc; background-color: transparent; font-size: 12px;">
            </div>

            <!-- Grado Info -->
            <div style="display: flex; align-items: center; margin-bottom: 4px;">
                <p style="margin-right: 6px; font-weight: bold; width: 140px; font-size: 12px;">GRADO:</p>
                <input type="text" value="{{ old('grado_nivel', $gradoNivel ?? '') }}" style="flex-grow: 1; padding: 2px 6px; height: 24px; border: none; border-bottom: 1px solid #ccc; background-color: transparent; font-size: 12px;">
            </div>

            <div style="display: flex; align-items: center; margin-bottom: 4px;">
                <p style="margin-right: 6px; font-weight: bold; width: 140px; font-size: 12px;">JORNADA:</p>
                <input type="text" value="{{ old('jornada', $jornada ?? '') }}" style="flex-grow: 1; padding: 2px 6px; height: 24px; border: none; border-bottom: 1px solid #ccc; background-color: transparent; font-size: 12px;">
            </div>

            <!-- Padre, Madre o Encargado Info -->
            <div style="display: flex; align-items: center; margin-bottom: 4px;">
                <p style="margin-right: 6px; font-weight: bold; width: 140px; font-size: 12px;">PADRE, MADRE O ENCARGADO:</p>
                <input type="text" value="{{ old('nombre_completo', $nombreCompleto ?? '') }}" style="flex-grow: 1; padding: 2px 6px; height: 24px; border: none; border-bottom: 1px solid #ccc; background-color: transparent; font-size: 12px;">
            </div>

            <!-- DPI Padre, Madre o Encargado Info -->
            <div style="display: flex; align-items: center; margin-bottom: 4px;">
                <p style="margin-right: 6px; font-weight: bold; width: 140px; font-size: 12px;">DPI PADRE, MADRE O ENCARGADO:</p>
                <input type="text" value="{{ old('identificacion', $identificacion ?? '') }}" style="flex-grow: 1; padding: 2px 6px; height: 24px; border: none; border-bottom: 1px solid #ccc; background-color: transparent; font-size: 12px;">
            </div>
        </div>

        <div style="font-size: 12px;">
            <h6>REGLAMENTO DEL COLEGIO PARTICULAR MIXTO "SHADDAI"</h6>
            <p style="text-align: center">De conformidad con el Acuerdo Ministerial 01 - 2011</p>

            <h6>DE LA AGENDA ESCOLAR:</h6>
            <ol style="text-align: justify;">
                <li>El uso de la presente agenda es obligatorio, para todos los estudiantes, en todos los grados y niveles.</li>
                <li>La agenda debe llevarse al colegio todos los días de clase, para anotar, en las fechas correspondientes de trabajos, tareas, laboratorios, talleres o actividades a realizar y entregar.</li>
                <li>La agenda es el medio de comunicación entre el colegio y los padres de familia, quienes debe revisar y firmar cuando se le sea requerido, en el espacio correspondiente.</li>
                <li>El uso correcto y permanente de la presente agenda, ayudará al estudiante a ser más ordenado, organizado y responsable, y al padre de familia a tener información constante sobre el desempeño de su hijo (a).</li>
            </ol>

            <h6>DEL UNIFORME Y APARIENCIA PERSONAL:</h6>
            <ol style="text-align: justify;">
                <li>Deberán traer el uniforme de diario completo todos los días y el de educación física cuando le corresponda dicha asignatura.</li>
                <li>Las alumnas del nivel preprimario, primario, básico deben presentase así: Falda a la altura de la rodilla, blusa dentro de la falda, calceta y zapatos del uniforme (no tenis), sin ningún tipo de maquillaje, sin aretes exagerados y peinadas adecuadamente.</li>
                <li>Las alumnas del nivel diversificado deben presentase así: pantalón de vestir (según el diseño autorizado), blusa dentro del pantalón, calceta negra tipo piecito y zapatos negros del uniforme (no tenis), maquillaje sutil o natural, sin aretes exagerados y peinadas adecuadamente.</li>
                <li>Los alumnos deben presentarse así: pantalón del uniforme (según diseño), camisa dentro del pantalón, cincho negro, calcetines blancos, zapatos del uniforme (no tenis), corte de cabello y peinado de hombre (no colas, ni líneas). Prohibido el uso de aretes, gorras, cejas depiladas.</li>
                <li>No se permitirá el ingreso de ningún estudiante que se haya realizado un tatuaje visible o una perforación tipo piercing.</li>
                <li>El uniforme de educación física comprende: El pants y playera del colegio, tenis (de cualquier color y marca).</li>
                <li>La apariencia personal ayuda a proyectar una buena imagen, por lo cual los alumnos deben asistir aseados, con el uniforme limpio y planchado y con los zapatos lustrados. (El pantalón de hombre debe de ser formal, no hacerlo pachuco)</li>
                <li>Presentarse a clases sin el uniforme completo será considerado como una falta leve.</li>
                <li>Al ingresar al establecimiento deben portar completo su uniforme del día, su gafete, agenda y su biblia versión reina Valera del 60.</li>
            </ol>

            <h6>DE LA ASISTENCIA Y PUNTUALIDAD:</h6>
            <ol style="text-align: justify;">
                <li>La asistencia es uno de los factores más importantes para un buen rendimiento en los estudios, por lo cual los padres deben preocuparse y velar porque sus hijos asistan con puntualidad y regularidad a clases.</li>
                <li>Cualquier inasistencia deberá ser justificada por escrito utilizando los formatos autorizados por el establecimiento, explicando las razones de la misma. La acumulación de tres faltas por el mismo motivo se considerará falta mayor y será sancionado por la dirección.</li>
                <li>Los estudiantes tienen la obligación de asistir a las diferentes actividades cívicas, sociales, religiosas que organice el colegio.</li>
                <li>Los alumnos de la jornada matutina que se presenten después de las 7:00 horas, permanecerán en el área de administración y podrán ingresar a las 7:40 horas (siguiente periodo), por lo tanto, la detención no amerita que el profesor este obligado a recibir tareas o trabajos.</li>
                <li>En la jornada vespertina no se permitirá el ingreso de ningún estudiante después de las 13:00 salvo casos de fuerza mayor debidamente comprobados.</li>
                <li>La acumulación de tres llegadas tarde constituye una falta mayor y será sancionada por la Dirección.</li>
                <li>La hora de salida del colegio es la siguiente: para los alumnos de nivel preprimario a las 11:30 horas; para los alumnos del nivel primario a las 11:45 horas; para alumnos del básico JM 12:00 horas y para los alumnos de básico JV y diversificado a las 18:00 horas. Los estudiantes no pueden permanecer fuera del establecimiento después de finalizada la jornada. Después de las horas estipuladas el colegio NO se hace responsable de la seguridad de los estudiantes.</li>
            </ol>

            <h6>DEL COMPORTAMIENTO EN EL AULA:</h6>
            <ol style="text-align: justify;">
                <li>Esperar en silencio y en orden, al profesor (a) o cualquier persona que le corresponda atenderlos en el periodo de clase.</li>
                <li>Poner la mayor atención posible a las explicaciones que realiza el profesor (a).</li>
                <li>No distraer la atención de sus compañeros de clase, con pláticas, aparatos, juguetes y otros objetos.</li>
                <li>No interrumpir la clase con actitudes de indisciplina, desordenes, o comentarios que no tienen relación con las asignaturas.</li>
                <li>Se prohíbe terminantemente jugar dentro del salón de clases.</li>
                <li>No está permitido rayar, manchar o pintar su escritorio, las paredes o cualquier parte de las instalaciones del colegio.</li>
                <li>Mantener su aula limpia, lo cual es parte de su aprendizaje de la cultura de limpieza.</li>
                <li>Se prohíbe comer, beber, o masticar chicle, comer paleta en el salón de clases.</li>
                <li>No está permitido que los estudiantes se ausenten del salón de clases sin el debido permiso de su docente, caso contrario será una falta leve.</li>
                <li>Realizar tareas, ejercicio o actividades que el profesor indique.</li>
                <li>No están permitidas las malas expresiones o palabras antisonantes dentro del centro educativo y/o salón de clases, el incumplimiento de esta norma ameritara una falta.</li>
            </ol>

            <h6>DE LAS OBLIGACIONES Y DEL COMPORTAMIENTO GENERAL DEL ESTUDIANTE:</h6>
            <ol style="text-align: justify;">
                <li>Respetar a los maestros autoridades educativas, estudiantes y a todas las personas que trabajan en el establecimiento.</li>
                <li>Asistir puntual y regularmente a todas las actividades escolares.</li>
                <li>Respetar las leyes, reglamentos normas y disposiciones del establecimiento.</li>
                <li>Dedicarse con entusiasmo y esmero al estudio buscando su propia superación.</li>
                <li>No agredir física ni verbalmente a ningún compañero, profesor (a), autoridad o persona que labore en el establecimiento.</li>
                <li>Contribuir a mantener limpio el establecimiento votando la basura en los depósitos provistos para el efecto. Tirar basura fuera de los depósitos correspondientes se considera una falta leve. La acumulación de tres faltas por la misma circunstancia será considerada una falta mayor, y será sancionada por la Dirección.</li>
                <li>Mantener una conducta intachable dentro y fuera del establecimiento, para honra de sus padres, así como para su propio prestigio y del establecimiento.</li>
                <li>Es responsabilidad de cada estudiante traer diariamente su carné, la agenda escolar, libros, cuadernos, trabajos, útiles y materiales de trabajo que vaya a necesitar. No se permite que los padres de familia lleven o envíen al establecimiento trabajos, tareas o materiales que el alumno olvido en casa, una vez ingresen al establecimiento (no nos hacemos responsables por objetos extraviados u olvidados).</li>
                <li>El estudiante debe asistir diariamente con el uniforme correspondiente según el calendario escolar proporcionado por dirección y con corte de cabello según los parámetros establecidos por la presente normativa.</li>
                <li>Respetar y obedecer los horarios y toques del timbre y no quedarse en los corredores o en otro salón que no le corresponda después del toque de entrada.</li>
            </ol>

            <h6>DE LAS PROHIBICIONES GENERALES DENTRO DEL ESTABLECIMIENTO:</h6>
            <ol style="text-align: justify;">
                <li>El uso de teléfonos celulares está prohibido dentro del establecimiento, en caso de emergencia comunicarse a Dirección. En caso de descubrir a un estudiante empleando su teléfono celular: llamando, contestando llamadas, enviando/revisando mensajes de texto, etc. el mismo será retenido en la Dirección y será entregado únicamente al padre de familia, al finalizar el bimestre. La reincidencia será considerada como una falta mayor y será sancionada por la Dirección.</li>
                <li>La portación de navajas, cuchillos, objetos punzo cortantes, y todo tipo de arma de fuego, ingreso o consumo de cigarros, bebidas alcohólicas, estimulantes, drogas o cualquier otra sustancia de efecto psicodélico. El incumplimiento de esta norma será considerado una falta grave y será notificado a las autoridades competentes, está falta tendrá como consecuencia la expulsión del estudiante o la disposición que dirección considere pertinente.</li>
                <li>La portación de medicamentos en los bolsones escolares. Excepcionalmente cuando el estudiante necesite tomar un medicamento específico para completar un tratamiento médico, bajo la responsabilidad y habiendo sido notificado por escrito por los padres.</li>
                <li>Periódicamente se realizarán revisiones de bolsones, para constatar que ningún objeto o sustancias ilícitas sean ingresadas al establecimiento y así velar por el resguardo de todo el estudiantado.</li>
                <li>No se permite que el estudiante reciba encomiendas de: dinero, comida, regalos u otros, salvo casos especiales autorizados por la Dirección.</li>
                <li>El causar daño a las instalaciones, mobiliario y equipo del establecimiento, cuyo caso el padre de familia deberá resarcir el daño causado por el estudiante.</li>
                <li>Ocasionar daños a, útiles, uniforme, o cualquier pertenencia de sus compañeros, de incurrir en esta falta, los padres de familia deberán hacerse responsables de lo dañado.</li>
                <li>El uso de vocabulario inapropiado, palabras disonantes, lenguaje de señas. El incumplimiento de dicha norma será considerado como falta grave y será sancionada por la Dirección, con la debida notificación al padre de familia.</li>
                <li>No se permiten manifestaciones de noviazgos dentro del establecimiento. Aplica también fuera del establecimiento, siempre y cuando lleven el uniforme del colegio, ya que afecta el prestigio.</li>
                <li>El ingreso de todo tipo de mascotas, salvo casos autorizados con fines educativos.</li>
                <li>La Dirección no se hará responsable por la pérdida de joyas u otros artículos de valor que el alumno(a) ingrese al establecimiento.</li>
            </ol>

            <h6>CÓMO PARTICIPAN LOS PADRES DE FAMILIA EN EL PROCESO EDUCATIVO</h6>
            <ol style="text-align: justify;">
                <li>Asistiendo a las reuniones programadas por el establecimiento (generales o individuales).</li>
                <li>Informándose continuamente del comportamiento y rendimiento de sus hijos.</li>
                <li>Revisando los cuadernos periódicamente y comprobando que estén al día, ordenados y limpios.</li>
                <li>Revisando tareas y preguntando lecciones diariamente para formar en sus hijos hábitos de estudio.</li>
                <li>Asegurándose de la asistencia regular y puntual de sus hijos.</li>
                <li>Verificando que en caso de inasistencia tenga la responsabilidad de ponerse al día inmediatamente.</li>
                <li>Recoger a sus hijos con puntualidad a la hora de salida, velar que llegue a tiempo a casa.</li>
                <li>Cancelando puntualmente las mensualidades o servicios educativos.</li>
                <li>Cancelar el valor de algún material u objeto del colegio o de otro alumno, si lo llegara a destruir.</li>
                <li>Conversando con sus hijos sobre los diferentes problemas que puedan tener dentro y fuera del colegio.</li>
                <li>Programándole a su hijo periodos para la lectura con temas de interés para su edad, fomentando así el amor a la lectura y mejorando su ortografía.</li>
                <li>Limitando el tiempo que dedican a ver el teléfono/televisión, revisar que vean programas adecuados a su edad.</li>
                <li>Velar porque su hijo (a) cumpla su horario de estudio y recreación.</li>
                <li>Preocupándose por las actividades que realizan en su tiempo libre.</li>
                <li>Estimulando los aciertos de su hijo (a) y no consintiéndole actitudes que lo conduzcan al ocio, la indiferencia o la irresponsabilidad en sus deberes y tareas escolares.</li>
                <li>Mantenerse en comunicación directa con el establecimiento para estar enterado del comportamiento y rendimiento de su hijo (a).</li>
                <li>Reforzando los principios y valores morales que su hijo (a) recibe en el colegio, para que su formación sea integral.</li>
            </ol>

            <h6>EL PERSONAL ADMINISTRATIVO DEL COLEGIO PARTICULAR MIXTO SHADDAI SE RESERVA EL DERECHO DE:</h6>
            <ol type="a" style="text-align: justify;">
                <li>Admisión de alumnos y alumnas.</li>
                <li>Sanciones a alumnos que participen y organicen desordenes dentro o fuera del plantel, o falten el respeto a las autoridades administrativas, coordinación, personal docente y compañeros de estudio.</li>
                <li>Autorizar permisos cuando no haya razón justificada.</li>
                <li>Autorizar más permisos de los indicados en un bimestre.</li>
                <li>Considerar los asuntos no previstos en el presente reglamento, quien está facultado para tomar las determinaciones que ayuden a solucionar situaciones dadas.</li>
            </ol>
        </div><br><br><br>

        <div class="signatures" style="display: flex; justify-content: center; align-items: center; gap: 5cm; text-align: center;">
            <div>
                <div class="signature-line" style="text-align: center; border-bottom: 1px solid rgba(0,0,0,0); width: 100%; position: relative; padding-bottom: 10px;">
                    Herlindo Artiga Marroquín<br>Propietario
                </div>
            </div>
            <div>
                <center><div class="signature-line" style="border-bottom: 1px solid rgba(0,0,0,0); width: 50%;"></center>
                <input type="text" id="nombre-completo" name="nombre_completo"
                       value="{{ old('nombre_completo', $nombreCompleto ?? '') }}"
                       style="border: none; outline: none; background-color: transparent; width: auto; padding: 2px; min-width: 48ch; text-align: center;"
                       oninput="this.style.width = (this.value.length + 1) + 'ch';">
                <br>Padre, Madre o Encargado
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
<div class="no-print">
    <button id="printButton" class="print-button">Descargar Contrato</button>
</div>

    <style>
        @media screen {
            .contract-container {
                max-width: 1300px;
                margin: 0 auto;
                padding: 20px;
                font-family: Arial, sans-serif;
                line-height: 1; /* Interlineado de 1 */
                color: #333;
            }
            /* Aplica el interlineado en otros elementos de texto */
            .contract-container p, .contract-container span, .contract-container h1, .contract-container h2, .contract-container h3, .contract-container h4, .contract-container h5, .contract-container h6 {
                line-height: 1.2; /* Interlineado de 1.2 */
            }
        }

        @media print {
            /* Asegura márgenes adecuados */
            @page {
                margin: 1cm;
            }
            body {
                counter-reset: page;
            }
            .btn i {
                display: none;
            }

            .contract-container {
                visibility: visible;
                margin: 0;
                padding: 0;
                line-height: 1.2; /* Interlineado de 1.2 en impresión */
            }

            .contract-container p, .contract-container span, .contract-container h1, .contract-container h2, .contract-container h3, .contract-container h4, .contract-container h5, .contract-container h6 {
                line-height: 1.2; /* Interlineado de 1.2 en impresión */
            }

            .no-print {
                display: none;
            }
        }

        .contract-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .contract-body {
            text-align: justify;
        }
        .clause {
            margin-bottom: 20px;
        }
        h6 {
            color: #2c3e50;
            font-weight: bold;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .form-grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .signatures {
            display: flex;
            justify-content: space-between;
            font-size: 12px; /* Reduce font size for signatures */
            margin-top: 10px; /* Reduce top margin */
        }

        .signature-line {
            width: 80%; /* Reduce width of signature line */
            margin-top: 10px; /* Reduce top margin of signature line */
            border-top: 1px solid #333;
            text-align: center;
        }

        .signature-line input {
            width: 100%; /* Asegura que el input ocupe todo el ancho disponible dentro de su contenedor */
            border: none;
            border-bottom: 1px solid transparent;
            background-color: transparent;
            padding: 2px;
            font-size: 20px;
        }

        /* Estilo para el botón de impresión */
        .print-button {
            background-color: #EAB308;
            color: white;
            font-weight: bold;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            border: none;
            cursor: pointer;
        }
        .print-button:hover {
            background-color: #CA8A04;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
<script>
    document.getElementById('printButton').addEventListener('click', function() {
        this.textContent = 'Imprimiendo...';
        window.print();
        this.textContent = 'Descargar Contrato';
    });

</script>
@endsection
