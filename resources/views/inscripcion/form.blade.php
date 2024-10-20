
                            <!-- Select para Registro Alumnos -->
                            <div class="form-group mb-2 mb20">
                                <label for="registro_alumnos_id" class="form-label">{{ __('Registro Alumnos') }}</label>
                                <select name="registro_alumnos_id" class="form-control @error('registro_alumnos_id') is-invalid @enderror" id="registro_alumnos_id">
                                    <option value="">Seleccione un alumno</option>
                                    @foreach($registro_alumno as $id => $nombre)
                                        <option value="{{ $id }}" {{ old('registro_alumnos_id', $inscripcion->registro_alumnos_id) == $id ? 'selected' : '' }}>
                                            {{ $nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                {!! $errors->first('registro_alumnos_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <!-- Select para Grados -->
                            <div class="form-group mb-2 mb20">
                                <label for="grados_id" class="form-label">{{ __('Grado') }}</label>
                                <select name="grados_id" class="form-control @error('grados_id') is-invalid @enderror" id="grados_id">
                                    <option value="">Seleccione un grado</option>
                                    @foreach($grado as $id => $nombre_grado)
                                        <option value="{{ $id }}" {{ old('grados_id', $inscripcion->grados_id) == $id ? 'selected' : '' }}>
                                            {{ $nombre_grado }}
                                        </option>
                                    @endforeach
                                </select>
                                {!! $errors->first('grados_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <!-- Select para Secciones -->
                            <div class="form-group mb-2 mb20">
                                <label for="seccions_id" class="form-label">{{ __('Sección') }}</label>
                                <select name="seccions_id" class="form-control @error('seccions_id') is-invalid @enderror" id="seccions_id">
                                    <option value="">Seleccione una sección</option>
                                    @foreach($seccion as $id => $nombre_seccion)
                                        <option value="{{ $id }}" {{ old('seccions_id', $inscripcion->seccions_id) == $id ? 'selected' : '' }}>
                                            {{ $nombre_seccion }}
                                        </option>
                                    @endforeach
                                </select>
                                {!! $errors->first('seccions_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
                            </div>

                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-primary me-2">{{ __('Guardar') }}</button>
                                <a href="{{ route('inscripcions.index') }}" class="btn btn-danger">{{ __('Cancelar') }}</a>
                            </div>

