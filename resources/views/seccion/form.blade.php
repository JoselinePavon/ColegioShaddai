<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="seccion" class="form-label">{{ __('Seccion') }}</label>
            <input type="text" name="seccion" class="form-control @error('seccion') is-invalid @enderror" value="{{ old('seccion', $seccion?->seccion) }}" id="seccion" placeholder="Seccion">
            {!! $errors->first('seccion', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>