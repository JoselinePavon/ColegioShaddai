<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="mes" class="form-label">{{ __('Mes') }}</label>
            <input type="text" name="mes" class="form-control @error('mes') is-invalid @enderror" value="{{ old('mes', $me?->mes) }}" id="mes" placeholder="Mes">
            {!! $errors->first('mes', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>