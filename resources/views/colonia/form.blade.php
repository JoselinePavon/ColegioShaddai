<div class="row padding-1 p-1">
    <div class="col-md-12">

        <!-- Campo de Nombre de Colonia -->
        <div class="form-group mb-2 mb20">
            <label for="nombre" class="form-label">{{ __('Nombre') }}</label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre', $colonia?->nombre) }}" id="nombre" placeholder="Nombre">
            {!! $errors->first('nombre', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <!-- Selector de Lugar -->
        <div class="form-group mb-2 mb20">
            <label for="lugars_id" class="form-label">{{ __('Lugar') }}</label>
            <select name="lugars_id" id="lugars_id" class="form-control @error('lugars_id') is-invalid @enderror">
                <option value="">Seleccione un lugar</option>
                @foreach($lugares as $lugar)
                    <option value="{{ $lugar->id }}" {{ old('lugars_id', $colonia?->lugars_id) == $lugar->id ? 'selected' : '' }}>
                        {{ $lugar->lugar }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('lugars_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
    </div>

    <!-- Botón de Envío -->
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
