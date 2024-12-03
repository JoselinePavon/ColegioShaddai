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
    <li>El uso de la presente agenda es obligatorio, para todos los estudiantes, en to dos los grados y niveles.</li>
    <li>La agenda debe llevarse al colegio todos los días de clase, para anotar, en las fechas correspondientes de trabajos, tareas, laboratorios, talleres o actividades a realizar y entregar.</li>
    <li>La agenda es el medio de comunicación entre el colegio y los padres de familia, quienes debe revisar y firmar semanalmente, en el espacio correspondiente.</li>
    <li>Las actitudes de indisciplina o incumplimiento de tareas u obligaciones, por parte del estudiante serán notificadas al padre de familia, a través de la presente agenda, firmando de enterado.</li>
    <li>El uso correcto y permanente de la presente agenda, ayudará al estudiante a ser más ordenado, organizado y responsable, y al padre de familia a tener información constante sobre el desempeño de su hijo (a).</li>
</ol>

<h6>DEL UNIFORME Y APARIENCIA PERSONAL:</h6>
<ol style="text-align: justify;">
    <li>Deberán traer el uniforme de diario completo todos los días y el de educación física cuando le corresponda dicha asignatura.</li>
    <li>Las alumnas deben presentase de la siguiente manera: Falda a la altura de la rodilla, blusa dentro de la falda, calceta y zapatos del uniforme (no tenis), sin ningún tipo de maquillaje, sin aretes exagerados y peinadas adecuadamente.</li>
    <li>Los alumnos deben presentarse de la siguiente forma: pantalón del uniforme (según diseño), camisa dentro del pantalón, cincho negro, calcetines blancos, zapatos del uniforme (no tenis), corte de cabello y peinado de hombre (no colas). Prohibido el uso de aretes, gorras, cejas depiladas.</li>
    <li>No se permitirá el ingreso de ningún estudiante que se haya realizado un tatuaje visible o una perforación tipo piercing.</li>
    <li>El uniforme de educación física comprende: El pants y playera del colegio, tenis (de cualquier color y marca).</li>
    <li>La apariencia personal ayuda a proyectar una buena imagen, por lo cual los alumnos deben asistir aseados, con el uniforme limpio y planchado y con los zapatos lustrados. (El pantalón de hombre debe de ser formal, no hacerlo pachuco)</li>
    <li>Presentarse a clases sin el uniforme completo será considerado como una falta leve.</li>
    <li>Al ingresar al establecimiento deben portar completo su uniforme del día (según calendario proporcionado por dirección) y portar su gafete o carné de forma visible.</li>
</ol>

<h6>DE LA ASISTENCIA Y PUNTUALIDAD:</h6>
<ol style="text-align: justify;">
    <li>Las asistencias es uno de los factores más importantes para un buen rendimiento en los estudios, por lo cual los padres deben preocuparse y velar porque sus hijos asistan con puntualidad y regularidad a clases.</li>
    <li>Cualquier inasistencia deberá ser justificada por escrito utilizando los formatos autorizados por el establecimiento, explicando las razones de la misma y con dos días de anticipación en el caso de las actividades planificadas, en caso de emergencia los alumnos tendrán hasta un día después de haber incurrido en la falta para entregar el debido permiso. La acumulación de tres faltas por el mismo motivo se considerará falta mayor y será sancionado por la dirección.</li>
    <li>Los estudiantes tienen la obligación de asistir a las diferentes actividades cívicas, sociales, religiosas que organice el colegio.</li>
    <li>Los alumnos de la jornada matutina que se presenten después de las 7:00 horas, permanecerán en el área de administración y podrán ingresar a las 7:40 horas (siguiente periodo), por lo tanto, la detención no amerita que el profesor este obligado a recibir tareas o trabajos.</li>
    <li>En la jornada vespertina no se permitirá el ingreso de ningún estudiante después de las 13:00 salvo casos de  fuerza mayor debidamente comprobados.</li>
    <li>La acumulación de tres llegadas tarde constituye una falta mayor y será sancionada por la Dirección.</li>
    <li>La hora de salida del colegio es la siguiente: para los alumnos de nivel pre-primario a las 11:30 horas; para los alumnos del nivel primario a las 12:00 horas; para alumnos del básico y diversificado a las 18:00 horas. Los estudiantes no pueden permanecer fuera del establecimiento después de finalizada la jornada. Después de las horas estipuladas el colegio NO se hace responsable de la seguridad de los estudiantes.</li>
</ol>

<h6>DEL COMPORTAMIENTO EN EL AULA:</h6>
<ol style="text-align: justify;">
    <li>Esperar en silencio y en orden, al profesor (a) o cualquier persona que le corresponda atenderlos en el periodo de clase.</li>
    <li>No distraer la atención de sus compañeros de clase, con pláticas, lecturas aparatos, juguetes y otros objetos.</li>
    <li>Se prohíbe terminantemente jugar dentro del salón de clases.</li>
    <li>No está permitido rayar, manchar o pintar su escritorio, las paredes o cualquier parte de las instalaciones del colegio.</li>
    <li>Mantener y dejar limpia su   aula, y al finalizar la jornada, lo cual es parte de su aprendizaje de la cultura de limpieza.</li>
    <li>Poner la mayor atención posible a las explicaciones que realiza el profesor (a).</li>
    <li>Se prohíbe comer, beber, o masticar chicle en el salón de clases.</li>
    <li>Debe contar con el permiso del profesor (a) para poder salir del aula, caso contrario será una falta leve.</li>
    <li>Realizar tareas, ejercicio o actividades que el profesor indique.</li>
    <li>No interrumpir la clase con actitudes de indisciplina, desordenes, o comentarios que no tienen relación con las asignaturas.</li>
    <li>No están permitidas las malas expresiones o palabras antisonantes dentro del centro educativo y/o salón de clases.</li>
    <li>No está permitido que los estudiantes se ausenten del salón de clases sin el debido permiso de su docente, ni de forma injustificada.</li>
</ol>

<h6>DE LAS OBLIGACIONES Y DEL COMPORTAMIENTO GENERAL DEL ESTUDIANTE:</h6>
<ol style="text-align: justify;">
    <li>Ser cortés y atento con todas las personas y compañeros.</li>
    <li>Respetar a los maestros autoridades educativas, estudiantes y a todas las personas que trabajan en el establecimiento.</li>
    <li>Asistir puntual y regularmente a todas las actividades escolares.</li>
    <li>Respetar las leyes, reglamentos normas y disposiciones del establecimiento.</li>
    <li>Dedicarse con entusiasmo y esmero al estudio buscando su propia superación.</li>
    <li>No agredir física ni verbalmente a ningún compañero, profesor (a), autoridad o persona que labore en el establecimiento.</li>
    <li>Contribuir a mantener limpio el establecimiento votando la basura en los depósitos provistos para el efecto. Tirar basura fuera de los depósitos correspondientes se considera una falta leve. La acumulación de tres faltas por la misma circunstancia será considerada una falta mayor, y será sancionada por la Dirección.</li>
    <li>Mantener una conducta intachable dentro y fuera del establecimiento, para honra de sus padres, así como para su propio prestigio y del establecimiento.</li>
    <li>Es responsabilidad de cada estudiante traer diariamente la agenda escolar, libros, cuadernos, trabajos, útiles y materiales de trabajo que vaya a necesitar. No se permite que los padres de familia lleven o envíen al establecimiento trabajos que deba presentar, tareas o materiales que el alumno olvido en casa, una vez ingresen al establecimiento.</li>
    <li>El estudiante debe asistir diariamente con el uniforme correspondiente según el calendario escolar proporcionado por dirección y con corte de cabello según los parámetros establecidos por la presente normativa.</li>
    <li>Respetar y obedecer los horarios y toques del timbre y no quedarse en el patio o en otro salón que no le corresponda después del toque de entrada.</li>
</ol>

<h6>DE LAS PROHIBICIONES GENERALES DENTRO DEL ESTABLECIMIENTO:</h6>
<ol style="text-align: justify;">
    <li>El uso de teléfonos celulares está prohibido dentro del establecimiento, en caso de emergencia comunicarse a Dirección. En caso de descubrir a un estudiante empleando su teléfono celular: llamando, contestando llamadas, enviando/revisando mensajes de texto, etc. el mismo será retenido en la Dirección y será entregado únicamente al padre de familia, al finalizar el bimestre. La reincidencia será considerada como una falta mayor y será sancionada por la Dirección.</li>
    <li>El ingreso de radios, ipod's, iphone's,  MP3, grabadoras, reproductores de CD's, equipos de sonido, televisores, juegos mecánicos o electrónicos y cualquier otro distractor, salvo con la autorización específica de la Dirección cuando las circunstancias lo ameriten. En caso de descubrir a un estudiante empleando alguno de estos aparatos, el mismo será retenido en la Dirección y devuelto únicamente a los padres. La reincidencia de esta situación será considerada una falta mayor y será sancionada por la dirección.</li>
    <li>La portación de navajas, cuchillos, objetos punzo cortantes, y todo tipo de arma de fuego o mecánica. El incumplimiento de esta norma será considerado por la Dirección.</li>
    <li>El ingreso o consumo de cigarros, bebidas alcohólicas, estimulantes, drogas o cualquier otra sustancia de efecto psicodélico. El incumplimiento de esta norma será considerado falta grave y será sancionada por la Dirección.</li>
    <li>La portación de medicamentos en los bolsones escolares. Excepcionalmente cuando el estudiante necesite tomar un medicamento específico para completar un tratamiento médico, bajo la responsabilidad notificada por escrito de los padres, se procederá a dar al estudiante el medicamento indicado.</li>
    <li>Periódicamente se harán revisiones para constatar que ningún objeto o sustancias ilícitas sean ingresadas al establecimiento y así velar por el resguardo de todo el estudiantado.</li>
    <li>El ingreso de comidas de restaurantes, salvo casos especiales autorizados por la Dirección.</li>
    <li>El causar daño a las instalaciones, mobiliario y equipo del establecimiento, cuyo caso el padre de familia deberá resarcir el daño causado por el estudiante.</li>
    <li>El uso de vocabulario inapropiado, palabras disonantes, lenguaje de señas. El incumplimiento de dicha norma será considerado como falta grave y será sancionada por la Dirección, con la debida notificación al padre de familia.</li>
    <li>La relación entre estudiantes debe ser con respeto, pureza y moralidad.</li>
    <li>No se permiten manifestaciones de noviazgos dentro del establecimiento. Aplica también fuera del establecimiento, siempre y cuando lleven el uniforme del colegio, ya que afecta el prestigio del mismo.</li>
    <li>El ingreso de todo tipo de mascotas, salvo casos autorizados con fines educativos.</li>
    <li>La Dirección no se hará responsable por la pérdida de joyas u otros artículos de valor que el alumno(a) ingrese al establecimiento.</li>
</ol>

<h6>DE LAS FALTAS, SANCIONES Y AMONESTACIONES:</h6>
<p style="text-align: justify"> Las faltas se consideran en leves (menores), graves y gravísimas además de las enumeradas y normadas en incisos anteriores.</p>
    <p style="font-weight: bold; text-align: justify">Se consideran faltas menores las siguientes:</p>

<ol style="text-align: justify;">
    <li>Llegadas tarde al centro educativo o periodos de clases sin una excusa debidamente comprobada.</li>
    <li>No traer sus libros o materiales el día que le corresponde.</li>
    <li>No realizar tareas asignadas.</li>
    <li>No entregar el folder escolar (trabajos y actividades).</li>
    <li>Platicar constantemente en clase, distraer continuamente a sus compañeros, no poner atención.</li>
    <li>Ingresar y consumir bebidas y comida, masticar chicle en clase.</li>
    <li>Levantarse sin permiso de su lugar.</li>
    <li>No obedecer las disposiciones del profesor (a).</li>
    <li>No llevar su agenda.</li>
    <li>No portar su Biblia.</li>
    <li>El uso incorrecto del uniforme.</li>
    <li>Tirar basura fuera de los depósitos correspondientes.</li>
    <li>Manchar áreas comunes, paredes, baños, mobiliario, ventanas y otros.</li>
    <li>Interrumpir el desarrollo normal de la clase con preguntas inapropiadas al tema.</li>
    <li>Utilizar lenguaje soez, bromas, apodos, chistes.</li>
    <li>Utilizar objetos personales inapropiados dentro del establecimiento.</li>
    <li>Salir del aula o centro educativo sin la autorización del establecimiento.</li>
    <li>Organizar actividades sin previa autorización correspondiente.</li>
    <li>No devolver firmados los avisos y notificaciones, enviados a sus padres o encargados.</li>
    <li>Recaudar fondos sin la autorización correspondiente.</li>
    <li>Usar teléfono celular y otros equipos electrónicos.</li>
    <li>No entrar a clases al toque del timbre.</li>
    <li>Presentarse una vez en el bimestre sin el uniforme completo, sin ninguna causa justificada.</li>
    <li>El ingreso de mascotas sin autorización.</li>
    <li>Realizar cualquier forma de discriminación a cualquier miembro de la comunidad educativa.</li>
    <li>No devolver firmados los avisos o reportes enviados por el personal docente, coordinación académica o dirección.</li>
    <li>Las relaciones de noviazgo o muestras de ello, dentro del centro educativo y/o salones de clases.</li>
    <li>No utilizar su carné de identificación.</li>
    <li>Y otras faltas leves consideradas como tales.</li>
</ol>
<p>Las faltas menores serán tratadas por el profesor (a) o por alguna autoridad educativa del plantel, en cuyo caso no se llamará al padre de familia y únicamente se anotará la falta en la Tarjeta de Méritos y Desméritos que se le lleva a cada estudiante y se le amonestará verbalmente.</p>
<p>El cometer tres faltas menores, por la misma circunstancia, constituye una falta mayor y será tratada y sancionada como tal por la Dirección.</p>

<p style="font-weight: bold;">Se consideran faltas mayores las siguientes:</p>
<ol style="text-align: justify;">
    <li>Acumulación de tres faltas menores.</li>
    <li>Causar daños al mobiliario, equipo e instalaciones educativas.</li>
    <li>Organizar, apoyar y/o participar en inasistencias colectivas.</li>
    <li>Manifestar conducta inadecuada dentro y fuera del establecimiento en actos académicos, morales y deportivos.</li>
    <li>Portar o utilizar material impreso digital que incite a la violencia que contenga pornografía y que desprestigie la imagen de cualquier miembro de la comunidad educativa (boletines o páginas de internet).</li>
    <li>Copiar en las pruebas de evaluación o utilizar medios prohibidos para obtener las respuestas de los exámenes.</li>
    <li>El uso de vocabulario inapropiado, palabras disonantes, lenguaje de señas.</li>
    <li>Incitar o provocar riñas o desordenes dentro del establecimiento, o fuera de él, vistiéndose el uniforme del colegio.</li>
    <li>Las faltas mayores serán tratadas por la Dirección y su sanción se hará de acuerdo a la frecuencia, reincidencia y gravedad de la misma. Serán anotadas en la Tarjeta de Méritos y Desméritos del estudiante, y se hará del conocimiento del padre de familia.</li>
</ol>

<p style="font-weight: bold;">Se consideran faltas gravísimas:</p>
<ol style="text-align: justify;">
    <li>Faltarle el respeto a cualquier profesor (a) o autoridad del plantel. (Incluye Director General)</li>
    <li>Agredir física o verbalmente a cualquier persona de la comunidad escolar.</li>
    <li>Insultar, calumniar, difamar, amenazar o agredir a las autoridades del establecimiento educativo, catedráticos(a) personal técnico.</li>
    <li>Sustraer, alterar u obtener en forma fraudulenta pruebas de evaluación.</li>
    <li>Tomar o apropiarse de dinero y objetos que no le pertenecen dentro y fuera del establecimiento haciendo uso del uniforme.</li>
    <li>Retirarse del establecimiento sin permiso escrito de sus padres o encargado.</li>
    <li>Portar armas de fuego, punzo cortantes u otros objetos que pueden ser utilizados como tal dentro y fuera del establecimiento, instalaciones externas y en actividades escolares del mismo.</li>
    <li>Falsificar o alterar firmas de una autoridad del establecimiento, padre de familia o encargado(a).</li>
    <li>No ingresar al toque del timbre al establecimiento cuando ya se encuentran uniformados (fugarse).</li>
    <li>Los actos de violencia física, verbal, emocional o sexual a cualquier miembro de la comunidad educativa. (de conformidad con el artículo 31 del Acuerdo Ministerial 01 – 2011.</li>
    <li>Realizar actos deshonestos o en contra de la moral y otras faltas que, a juicio de la Dirección sean consideradas como mayores.</li>
    <li>No se permiten estudiantes en estado de gestación. Si una estudiante resultase embarazada durante el ciclo escolar deberá retirarse del establecimiento.</li>
</ol>

<h6>SANCIONES:</h6>
<p>Se establece el siguiente régimen de sanciones disciplinarias, el que será aplicado atendiendo las faltas cometidas.</p>
<ol style="text-align: justify;">
    <li>Amonestación verbal con registro por escrito.</li>
    <li>Amonestación por escrito.</li>
    <li>Asignación de alguna tarea disciplinaria dentro del establecimiento, como barrer algún salón, quitar del piso o de objetos, goma de mascar etc.</li>
    <li>Suspensión parcial de clases de dos a cinco días hábiles, sin derecho a presentar trabajos o tareas o sustentar las pruebas durante el tiempo que dure la suspensión, con la debida notificación al padre de familia.</li>
    <li>Suspensión temporal de sus derechos de estudiante.</li>
    <li>Las faltas graves ya descritas en las Prohibiciones Generales de esta agenda, y otras no contempladas en la misma, pero que a juicio de la Dirección sean consideradas como tales (gravísimas) serán sancionadas por la dirección.</li>
</ol>

<h6>Cómo participan los Padres de Familia en el Proceso Educativo</h6>
<ol style="text-align: justify;">
    <li>Asistiendo a las reuniones programadas por el establecimiento (generales o individuales).</li>
    <li>Informándose continuamente del comportamiento y rendimiento de sus hijos.</li>
    <li>Revisando agenda escolar.</li>
    <li>Revisando los cuadernos periódicamente y comprobando que estén al día, ordenados y limpios.</li>
    <li>Revisando tareas y preguntando lecciones diariamente para formar en sus hijos hábitos de estudio.</li>
    <li>Asegurándose de la asistencia regular y puntual de sus hijos.</li>
    <li>Verificando que en caso de inasistencia tenga la responsabilidad de ponerse al día inmediatamente.</li>
    <li>Recoger a sus hijos con puntualidad a la hora de salida, velar que llegue a tiempo a casa.</li>
    <li>Cancelando puntualmente las mensualidades o servicios educativos.</li>
    <li>Cancelar el valor de algún material u objeto del colegio o de otro alumno, si lo llegara a destruir.</li>
    <li>Conversando con sus hijos sobre los diferentes problemas que puedan tener dentro y fuera del colegio.</li>
    <li>Programándole a su hijo periodos para la lectura con temas de interés para su edad, fomentando así el amor a la lectura y mejorando su ortografía.</li>
    <li>Limitando el tiempo que dedican a ver televisión y que vean programas adecuados a su edad.</li>
    <li>Velar porque su hijo (a) cumpla su horario de estudio y recreación.</li>
    <li>Preocupándose por las actividades que realizan en su tiempo libre, así como de las amistades que tienen.</li>
    <li>Estimulando los aciertos de su hijo (a) y no consintiéndole actitudes que lo conduzcan al ocio, la indiferencia o la irresponsabilidad en sus deberes y tareas escolares.</li>
    <li>Mantenerse en comunicación directa con los profesores para estar enterado del comportamiento de su hijo (a) en el colegio.</li>
    <li>Reforzando los principios y valores morales que su hijo (a) recibe en el colegio, para que su formación sea integral.</li>
</ol>

<h6>EL PERSONAL ADMINISTRATIVO DEL COLEGIO PARTICULAR MIXTO SHADDAI SE RESERVA EL DERECHO DE:</h6>
<ol type="a" style="text-align: justify;">
    <li>Admisión de alumnos y alumnas.</li>
    <li>Sanciones a alumnos y alumnas que participen y organicen desordenes dentro o fuera del plantel, o falten el respeto a las autoridades Directivas, Administrativas y Docentes.</li>
    <li>Autorizar permisos cuando no haya razón justificada.</li>
    <li>Autorizar más permisos de los indicados en un bimestre.</li>
    <li>Considerar los asuntos no previstos en el presente reglamento, quien está facultado para tomar las determinaciones que ayuden a solucionar situaciones dadas.</li>
</ol>

            <div class="signatures" style="display: flex; justify-content: space-around; align-items: center; margin-bottom: 20px;">
                <div class="signature">
                    <div class="signature-line">
                        <input type="text" value="{{ old('nombre_completo', $nombreCompleto ?? '') }}"
                               style="border: none; border-bottom: 1px solid transparent; background-color: transparent; width: 100%; text-align: center; padding: 2px;">
                        <br>Padre, Madre o Encargado
                    </div>
                </div>
                <div class="signature">
                    <div class="signature-line">
                        <input type="text" value="{{ old('nombre_educando', $nombreEducando ?? '') }}"
                               style="border: none; border-bottom: 1px solid transparent; background-color: transparent; width: 100%; text-align: center; padding: 2px;">
                        <br>Estudiante
                    </div>
                </div>
            </div>
            <div class="signatures" style="display: flex; justify-content: center; align-items: center;">
                <div class="signature">
                    <div class="signature-line" style="text-align: center;">
                        Herlindo Artiga Marroquín<br>Director Administrativo
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
            margin-top: 40px;
        }

        .signature-line {
            width: 110%;
            border-top: 1px solid #333;
            margin-top: 20px;
            text-align: center;
        }

        .signature-line input {
            width: 100%; /* Asegura que el input ocupe todo el ancho disponible dentro de su contenedor */
            border: none;
            border-bottom: 1px solid transparent;
            background-color: transparent;
            padding: 2px;
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
