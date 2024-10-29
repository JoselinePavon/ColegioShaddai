<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="nombre_encargado" class="form-label">{{ __('Nombre Encargado') }}</label>
            <input type="text" name="nombre_encargado" class="form-control @error('nombre_encargado') is-invalid @enderror" value="{{ old('nombre_encargado', $encargado?->nombre_encargado) }}" id="nombre_encargado" placeholder="Nombre Encargado">
            {!! $errors->first('nombre_encargado', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="direccion" class="form-label">{{ __('Direccion') }}</label>
            <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion', $encargado?->direccion) }}" id="direccion" placeholder="Direccion">
            {!! $errors->first('direccion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="num_encargado1" class="form-label">{{ __('Num Encargado1') }}</label>
            <input type="text" name="num_encargado1" class="form-control @error('num_encargado1') is-invalid @enderror" value="{{ old('num_encargado1', $encargado?->num_encargado1) }}" id="num_encargado1" placeholder="Num Encargado1">
            {!! $errors->first('num_encargado1', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="num_encargado2" class="form-label">{{ __('Num Encargado2') }}</label>
            <input type="text" name="num_encargado2" class="form-control @error('num_encargado2') is-invalid @enderror" value="{{ old('num_encargado2', $encargado?->num_encargado2) }}" id="num_encargado2" placeholder="Num Encargado2">
            {!! $errors->first('num_encargado2', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="persona_emergencia" class="form-label">{{ __('Persona Emergencia') }}</label>
            <input type="text" name="persona_emergencia" class="form-control @error('persona_emergencia') is-invalid @enderror" value="{{ old('persona_emergencia', $encargado?->persona_emergencia) }}" id="persona_emergencia" placeholder="Persona Emergencia">
            {!! $errors->first('persona_emergencia', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>