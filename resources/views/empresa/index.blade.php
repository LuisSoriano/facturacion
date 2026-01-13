@extends('layouts.app')

@section('title','Empresa')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">INSTITUCIÓN</h1>

    <x-breadcrumb.template>
        <x-breadcrumb.item :href="route('panel')" content="Inicio" />
        <x-breadcrumb.item active='true' content="Mi empresa" />
    </x-breadcrumb.template>

    <x-forms.template :action="route('empresa.update',['empresa' => $empresa])" method='post' patch='true'>

        <div class="row g-4">

            <div class="col-md-6">
                <x-forms.input id="nombre" required='true' :defaultValue='$empresa->nombre' />
            </div>

            <div class="col-md-6">
                <x-forms.input id="propietario" required='true' :defaultValue='$empresa->propietario' />
            </div>

            <div class="col-md-6">
                <x-forms.input id="ruc" required='true' :defaultValue='$empresa->ruc' />
            </div>

            <div class="col-md-6">
                <x-forms.input id="direccion" required='true' :defaultValue='$empresa->direccion' />
            </div>

            <div class="col-md-6">
                <x-forms.input id="porcentaje_impuesto" required='true' :defaultValue='$empresa->porcentaje_impuesto'
                    type='number' labelText='Porcentaje del impuesto (%)' />
            </div>

            <div class="col-md-6">
                <x-forms.input id="abreviatura_impuesto" required='true' :defaultValue='$empresa->abreviatura_impuesto'
                    labelText='Abreviatura del impuesto' />
            </div>

            <div class="col-md-4">
                <x-forms.input id="correo" :defaultValue='$empresa->correo' type='email' />
            </div>

            <div class="col-md-4">
                <x-forms.input id="telefono" :defaultValue='$empresa->telefono' />
            </div>

            <div class="col-md-4">
                <x-forms.input id="ubicacion" :defaultValue='$empresa->ubicacion' />
            </div>

            <div class="col-12">
                <label for="moneda_id" class="form-label">Moneda seleccionada:</label>
                <select name="moneda_id" id="moneda_id" class="form-select">
                    @foreach ($monedas as $moneda)
                    <option value="{{$moneda->id}}"
                        {{$empresa->moneda_id == $moneda->id || old('moneda_id') == $moneda->id  ? 'selected' : ''}}>
                        {{$moneda->nombre_completo}}
                    </option>
                    @endforeach
                </select>
                @error('moneda_id')
                <small class="text-danger">{{'* .$messsage'}}</small>
                @enderror
            </div>

        </div>

        @can('update-empresa')
        <x-slot name='footer'>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </x-slot>
        @endcan

    </x-forms.template>

    <hr class="my-5">

    <h2 class="mt-4 text-center">CONFIGURACIÓN SIA</h2>

    <x-forms.template :action="route('empresa.updateSiat',['empresa' => $empresa])" method='post' patch='true'>

        <div class="row g-4">

            <div class="col-md-6">
                <x-forms.input id="nit" required='true' :defaultValue='$empresa->configuracionSiat?->nit' />
            </div>

            <div class="col-md-6">
                <x-forms.input id="razon_social" required='true' :defaultValue='$empresa->configuracionSiat?->razon_social' />
            </div>

            <div class="col-md-6">
                <x-forms.input id="codigo_sistema" required='true' :defaultValue='$empresa->configuracionSiat?->codigo_sistema' />
            </div>

            <div class="col-md-6">
                <x-forms.input id="nombre_sistema" required='true' :defaultValue='$empresa->configuracionSiat?->nombre_sistema' />
            </div>

            <div class="col-md-6">
                <label for="codigo_ambiente" class="form-label">Código de Ambiente:</label>
                <select name="codigo_ambiente" id="codigo_ambiente" class="form-select">
                    <option value="1" {{ $empresa->configuracionSiat?->codigo_ambiente == 1 ? 'selected' : '' }}>Producción</option>
                    <option value="2" {{ $empresa->configuracionSiat?->codigo_ambiente == 2 ? 'selected' : '' }}>Pruebas</option>
                </select>
            </div>

            <div class="col-md-6">
                <label for="codigo_modalidad" class="form-label">Código de Modalidad:</label>
                <select name="codigo_modalidad" id="codigo_modalidad" class="form-select">
                    <option value="1" {{ $empresa->configuracionSiat?->codigo_modalidad == 1 ? 'selected' : '' }}>Electrónica en Línea</option>
                    <option value="2" {{ $empresa->configuracionSiat?->codigo_modalidad == 2 ? 'selected' : '' }}>Computarizada en Línea</option>
                </select>
            </div>

            <div class="col-md-6">
                <x-forms.input id="codigo_sucursal" required='true' :defaultValue='$empresa->configuracionSiat?->codigo_sucursal' type='number' />
            </div>

            <div class="col-md-6">
                <x-forms.input id="codigo_punto_venta" required='true' :defaultValue='$empresa->configuracionSiat?->codigo_punto_venta' type='number' />
            </div>

            <div class="col-md-6">
                <x-forms.input id="cuis" :defaultValue='$empresa->configuracionSiat?->cuis' />
            </div>

            <div class="col-md-6">
                <x-forms.input id="token_api" :defaultValue='$empresa->configuracionSiat?->token_api' />
            </div>

            <div class="col-md-12">
                <h5>URLs de Servicios SIA</h5>
            </div>

            <div class="col-md-6">
                <x-forms.input id="url_sincronizacion" :defaultValue='$empresa->configuracionSiat?->url_sincronizacion' labelText="URL Sincronización" />
            </div>

            <div class="col-md-6">
                <x-forms.input id="url_operaciones" :defaultValue='$empresa->configuracionSiat?->url_operaciones' labelText="URL Operaciones" />
            </div>

            <div class="col-md-6">
                <x-forms.input id="url_codigos" :defaultValue='$empresa->configuracionSiat?->url_codigos' labelText="URL Códigos" />
            </div>

            <div class="col-md-6">
                <x-forms.input id="url_facturacion" :defaultValue='$empresa->configuracionSiat?->url_facturacion' labelText="URL Facturación" />
            </div>

        </div>

        @can('update-empresa')
        <x-slot name='footer'>
            <button type="submit" class="btn btn-primary">Actualizar Configuración SIA</button>
            <button type="button" id="test-connection-btn" class="btn btn-secondary ms-2">Probar Conexión</button>
            <button type="button" id="get-cuis-btn" class="btn btn-info ms-2">Obtener CUIS</button>
        </x-slot>
        @endcan

    </x-forms.template>


</div>
@endsection

@push('js')
<script>
document.getElementById('test-connection-btn').addEventListener('click', function() {
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Probando...';

    fetch('{{ route("empresa.testSiatConnection", $empresa) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Conectado',
                text: data.message,
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Desconectado',
                text: data.message,
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al probar la conexión: ' + error.message,
        });
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = 'Probar Conexión';
    });
});

document.getElementById('get-cuis-btn').addEventListener('click', function() {
    const btn = this;
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Obteniendo CUIS...';

    fetch('{{ route("empresa.getCuis", $empresa) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const cuisInput = document.getElementById('cuis');
            const currentCuis = cuisInput.value;

            if (data.match) {
                Swal.fire({
                    icon: 'info',
                    title: 'CUIS Vigente',
                    text: `El CUIS actual (${data.cuis}) está vigente hasta ${data.fechaVigencia}`,
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'CUIS Obtenido',
                    text: `Nuevo CUIS: ${data.cuis}${data.fechaVigencia ? ` (Vigente hasta: ${data.fechaVigencia})` : ''}`,
                    showCancelButton: true,
                    confirmButtonText: 'Actualizar CUIS',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        cuisInput.value = data.cuis;
                        // Aquí podrías agregar lógica para guardar automáticamente
                        Swal.fire('Actualizado', 'El CUIS ha sido actualizado en el formulario.', 'success');
                    }
                });
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error al obtener CUIS',
                text: data.message,
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al obtener CUIS: ' + error.message,
        });
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = 'Obtener CUIS';
    });
});
</script>
@endpush