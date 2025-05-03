
    <div class="container mt-4">
        <div class="row">
            <div class="card mb-5">
                <div class="card-body">
                        <!-- Row for student and guardian sections side by side -->
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3 text-center"><i class="bi bi-person-fill"></i> Datos del Alumno</h6></center>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="codigo_personal" class="form-label"><i class="bi bi-person-fill"></i> Código Personal</label>
                                    <input type="text" name="codigo_personal" class="form-control @error('codigo_personal') is-invalid @enderror"
                                           value="{{ old('codigo_personal', $registroAlumno?->codigo_personal) }}" id="codigo_personal" placeholder="123456789">
                                    @error('codigo_personal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nombres" class="form-label"><i class="bi bi-person-fill"></i> Nombres</label>
                                    <input type="text" name="nombres" class="form-control @error('nombres') is-invalid @enderror" value="{{ old('nombres', $registroAlumno?->nombres) }}" id="nombres" placeholder="Nombres">
                                    @error('nombres') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="apellidos" class="form-label"><i class="bi bi-person-fill"></i> Apellidos</label>
                                    <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos', $registroAlumno?->apellidos) }}" id="apellidos" placeholder="Apellidos">
                                    @error('apellidos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="genero" class="form-label"><i class="bi bi-people-fill"></i> Género</label>
                                    <select name="genero" class="form-control @error('genero') is-invalid @enderror" id="genero">
                                        <option value="">Selecciona género</option>
                                        <option value="Masculino" {{ old('genero', $registroAlumno?->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="Femenino" {{ old('genero', $registroAlumno?->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                    </select>
                                    @error('genero') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edad" class="form-label"><i class="bi bi-calendar-date"></i> Edad</label>
                                    <input type="number" name="edad" class="form-control @error('edad') is-invalid @enderror" value="{{ old('edad', $registroAlumno?->edad) }}" id="edad" placeholder="Edad">
                                    @error('edad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_nacimiento" class="form-label"><i class="bi bi-calendar-date"></i> Fecha de nacimiento</label>
                                    <input type="date" name="fecha_nacimiento" class="form-control @error('fecha_nacimiento') is-invalid @enderror" value="{{ old('fecha_nacimiento', $registroAlumno?->fecha_nacimiento) }}" id="fecha_nacimiento">
                                    @error('fecha_nacimiento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>



                        <!-- Datos del Encargado -->

                            <div class="col-md-6">
                                <h6 class="text-primary mb-3 text-center"><i class="bi bi-person-check-fill"></i> Datos del Encargado</h6>
                                <div class="row row-cols-3 g-3">
                                    <div class="col">
                                        <label for="nombre_encargado" class="form-label"><i class="bi bi-person-fill"></i> Nombre completo</label>
                                        <input type="text" name="nombre_encargado" class="form-control @error('nombre_encargado') is-invalid @enderror" value="{{ old('nombre_encargado', $encargado?->nombre_encargado) }}" id="nombre_encargado" placeholder="Nombre del Encargado">
                                    </div>
                                    <div class="col">
                                        <label for="edad_encargado" class="form-label"><i class="bi bi-person-fill"></i> Edad</label>
                                        <input type="number" name="edad_encargado" class="form-control @error('edad_encargado') is-invalid @enderror" value="{{ old('edad_encargado', $encargado?->edad_encargado) }}" id="edad_encargado" placeholder="Edad">
                                        @error('edad_encargado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col">
                                        <label for="estado_civil" class="form-label"><i class="bi bi-person-fill"></i> Estado Civil</label>
                                        <select name="estado_civil" class="form-select @error('estado_civil') is-invalid @enderror" id="estado_civil">
                                            <option value="">Seleccione</option>
                                            <option value="Casado(a)" {{ old('estado_civil', $encargado?->estado_civil) == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                            <option value="Soltero(a)" {{ old('estado_civil', $encargado?->estado_civil) == 'Soltero(a)' ? 'selected' : '' }}>Soltero(a)</option>
                                        </select>
                                        @error('estado_civil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col">
                                        <label for="parentesco" class="form-label"><i class="bi bi-people-fill"></i> Parentesco</label>
                                        <select name="parentesco" class="form-select @error('parentesco') is-invalid @enderror" id="parentesco">
                                            <option value="">Seleccione</option>
                                            <option value="Padre" {{ old('parentesco', $encargado->parentesco ?? '') == 'Padre' ? 'selected' : '' }}>Padre</option>
                                            <option value="Madre" {{ old('parentesco', $encargado->parentesco ?? '') == 'Madre' ? 'selected' : '' }}>Madre</option>
                                            <option value="Tío(a)" {{ old('parentesco', $encargado->parentesco ?? '') == 'Tío(a)' ? 'selected' : '' }}>Tío(a)</option>
                                            <option value="Abuelo(a)" {{ old('parentesco', $encargado->parentesco ?? '') == 'Abuelo(a)' ? 'selected' : '' }}>Abuelo(a)</option>
                                            <option value="Hermano(a)" {{ old('parentesco', $encargado->parentesco ?? '') == 'Hermano(a)' ? 'selected' : '' }}>Hermano(a)</option>
                                            <option value="Primo(a)" {{ old('parentesco', $encargado->parentesco ?? '') == 'Primo(a)' ? 'selected' : '' }}>Primo(a)</option>
                                            <option value="Tutor Legal" {{ old('parentesco', $encargado->parentesco ?? '') == 'Tutor Legal' ? 'selected' : '' }}>Tutor Legal</option>
                                            <option value="Padrastro" {{ old('parentesco', $encargado->parentesco ?? '') == 'Padrastro' ? 'selected' : '' }}>Padrastro</option>
                                            <option value="Madrastra" {{ old('parentesco', $encargado->parentesco ?? '') == 'Madrastra' ? 'selected' : '' }}>Madrastra</option>
                                            <option value="Otro" {{ old('parentesco', $encargado->parentesco ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>


                                        </select>
                                        @error('parentesco') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col">
                                        <label for="oficio" class="form-label"><i class="fas fa-briefcase"></i> Oficio</label>
                                        <input type="text" name="oficio" class="form-control @error('oficio') is-invalid @enderror" value="{{ old('oficio', $encargado?->oficio) }}" id="oficio" placeholder="Oficio">
                                        @error('oficio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col">
                                        <label for="dpi" class="form-label"><i class="bi bi-house-door-fill"></i> DPI</label>
                                        <input type="text" name="dpi" class="form-control @error('dpi') is-invalid @enderror" value="{{ old('dpi', $encargado?->dpi) }}" id="dpi" placeholder="DPI">
                                        @error('dpi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col">
                                        <label for="lugars_id" class="form-label"><i class="bi bi-geo-alt-fill"></i> Lugar</label>
                                        <select name="lugars_id" id="lugars_id" class="form-select @error('lugars_id') is-invalid @enderror">
                                            <option value="">Seleccione un lugar</option>
                                            @foreach($lugares as $lugar)
                                                <option value="{{ $lugar->id }}" {{ old('lugars_id', $encargado?->lugars_id) == $lugar->id ? 'selected' : '' }}>
                                                    {{ $lugar->lugar }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('lugars_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col">
                                        <label for="colonias_id" class="form-label"><i class="bi bi-map-fill"></i> Colonia</label>
                                        <select name="colonias_id" id="colonias_id" class="form-select @error('colonias_id') is-invalid @enderror" {{ old('colonias_id', $encargado?->colonias_id) ? '' : 'disabled' }}>
                                            <option value="">Seleccione una colonia</option>
                                            @if (old('colonias_id', $encargado?->colonias_id))
                                                @foreach($colonias->where('lugars_id', old('lugars_id', $encargado?->lugars_id)) as $colonia)
                                                    <option value="{{ $colonia->id }}" {{ old('colonias_id', $encargado?->colonias_id) == $colonia->id ? 'selected' : '' }}>
                                                        {{ $colonia->nombre }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('colonias_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col">
                                        <label for="telefono" class="form-label"><i class="bi bi-telephone-fill"></i> Teléfono</label>
                                        <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono', $encargado?->telefono) }}" id="telefono" placeholder="Teléfono">
                                        @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col">
                                        <label for="persona_emergencia" class="form-label"><i class="bi bi-telephone-fill"></i> Teléfono</label>
                                        <input type="text" name="persona_emergencia" class="form-control @error('persona_emergencia') is-invalid @enderror" value="{{ old('telefono', $encargado?->persona_emergencia) }}" id="persona_emergencia" placeholder="persona_emergencia">
                                        @error('persona_emergencia') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                </div>
                            </div>
                        <h6 class="text-primary mb-3 mt-4 text-center"><i class="bi bi-card-list"></i> Datos de Inscripción</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="codigo_correlativo" class="form-label"> {{ __('Codigo Correlativo') }}</label>
                                <input type="text" name="codigo_correlativo" class="form-control @error('codigo_correlativo') is-invalid @enderror"
                                       value="{{ old('codigo_correlativo', $inscripcion?->codigo_correlativo) }}" id="codigo_correlativo" placeholder="Escribe el nombre del grado">
                                @error('codigo_correlativo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="grados_id" class="form-label">{{ __('Grado') }}</label>
                                <select name="grados_id" class="form-select @error('grados_id') is-invalid @enderror" id="grados_id">
                                    <option value="">Seleccione un grado</option>
                                    @foreach($grado as $id => $nombre_grado)
                                        <option value="{{ $id }}" {{ old('grados_id', $inscripcion->grados_id ?? '') == $id ? 'selected' : '' }}>
                                            {{ $nombre_grado }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('grados_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jornada" class="form-label">Jornada</label>
                                <select name="jornada" class="form-select @error('jornada') is-invalid @enderror" id="jornada">
                                    <option value="">Selecciona Jornada</option>
                                    <option value="Matutina" {{ old('jornada', $inscripcion?->jornada) == 'Matutina' ? 'selected' : '' }}>Matutina</option>
                                    <option value="Vespertina" {{ old('jornada', $inscripcion?->jornada) == 'Vespertina' ? 'selected' : '' }}>Vespertina</option>
                                </select>
                                @error('jornada') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="seccions_id" class="form-label">{{ __('Sección') }}</label>
                                <select name="seccions_id" class="form-select @error('seccions_id') is-invalid @enderror" id="seccions_id">
                                    <option value="">Seleccione una sección</option>
                                    @foreach($seccion as $id => $nombre_seccion)
                                        <option value="{{ $id }}" {{ old('seccions_id', $inscripcion->seccions_id ?? '') == $id ? 'selected' : '' }}>
                                            {{ $nombre_seccion }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('seccions_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-mb-16">
                                <label for="anio_escolar_id" class="form-label">{{ __('Año Escolar') }}</label>
                                <select name="anio_escolar_id" class="form-select @error('anio_escolar_id') is-invalid @enderror" id="anio_escolar_id">
                                    <option value="">Seleccione el ciclo escolar</option>
                                    @foreach($anioEscolar as $id => $nombre)
                                        <option value="{{ $id }}" {{ old('anio_escolar_id', $inscripcion->anio_escolar_id ?? '') == $id ? 'selected' : '' }}>
                                            {{ $nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('anio_escolar_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        </div>

                        <!-- Botón de Validación -->
                    <div class="text-center mt-3">
                        <button type="submit" class="btn btn-dark"><i class="fas fa-save"></i> Actualizar </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lugarSelect = document.getElementById('lugars_id');
            const coloniaSelect = document.getElementById('colonias_id');
            const coloniasPorLugar = @json($lugares->mapWithKeys(fn($lugar) => [$lugar->id => $colonias->where('lugars_id', $lugar->id)->pluck('nombre', 'id')]));

            lugarSelect.addEventListener('change', () => {
                const lugarId = lugarSelect.value;
                coloniaSelect.innerHTML = '<option value="">Seleccione una colonia</option>';
                coloniaSelect.disabled = true;

                if (coloniasPorLugar[lugarId]) {
                    for (const [id, nombre] of Object.entries(coloniasPorLugar[lugarId])) {
                        const option = new Option(nombre, id);
                        coloniaSelect.add(option);
                    }
                    coloniaSelect.disabled = false;
                }
            });

            // Si ya hay un lugar seleccionado, cargar las colonias automáticamente
            if (lugarSelect.value) {
                const lugarId = lugarSelect.value;
                if (coloniasPorLugar[lugarId]) {
                    for (const [id, nombre] of Object.entries(coloniasPorLugar[lugarId])) {
                        const option = new Option(nombre, id, id == "{{ old('colonias_id', $encargado?->colonias_id) }}");
                        coloniaSelect.add(option);
                    }
                    coloniaSelect.disabled = false;
                }
            }
        });
    </script>

    <script>
        // Función para formatear números con guiones cada 4 dígitos
        const formatWithHyphen = (input) => {
            let value = input.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
            if (value.length > 8) {
                value = value.slice(0, 8); // Limitar a 8 dígitos
            }
            value = value.match(/.{1,4}/g)?.join('-') || ''; // Agrupar cada 4 caracteres y unir con guiones
            input.value = value;
        };

        const telefonoInput = document.getElementById('telefono');
        const emergenciaInput = document.getElementById('persona_emergencia');

        // Aplicar la función en cada evento de entrada
        telefonoInput.addEventListener('input', () => formatWithHyphen(telefonoInput));
        emergenciaInput.addEventListener('input', () => formatWithHyphen(emergenciaInput));

        // Validación al enviar el formulario (opcional, para asegurar que no tenga menos de 8 números)
        document.querySelector('form').addEventListener('submit', (event) => {
            const telefonoRaw = telefonoInput.value.replace(/[-\s]/g, '');
            const emergenciaRaw = emergenciaInput.value.replace(/[-\s]/g, '');

            if (telefonoRaw.length !== 8) {
                event.preventDefault();
                alert('El número de teléfono debe tener exactamente 8 dígitos.');
                telefonoInput.focus();
                return;
            }
        });
    </script>
