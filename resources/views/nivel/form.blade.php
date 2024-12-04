<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="nivel" class="form-label">{{ __('Nivel') }}</label>
            <input type="text" name="nivel" class="form-control @error('nivel') is-invalid @enderror" value="{{ old('nivel', $nivel?->nivel) }}" id="nivel" placeholder="Nivel">
            {!! $errors->first('nivel', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>