<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-2 mb20">
            <label for="tipo_pago" class="form-label">{{ __('Tipo Pago') }}</label>
            <input type="text" name="tipo_pago" class="form-control @error('tipo_pago') is-invalid @enderror" value="{{ old('tipo_pago', $tipopago?->tipo_pago) }}" id="tipo_pago" placeholder="Tipo Pago">
            {!! $errors->first('tipo_pago', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="monto" class="form-label">{{ __('Monto') }}</label>
            <input type="text" name="monto" class="form-control @error('monto') is-invalid @enderror" value="{{ old('monto', $tipopago?->monto) }}" id="monto" placeholder="Monto">
            {!! $errors->first('monto', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>

</div>
