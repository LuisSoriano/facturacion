@extends('layouts.app')

@section('title','Editar cliente')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Cliente</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('clientes.index')}}">Clientes</a></li>
        <li class="breadcrumb-item active">Editar cliente</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{ route('clientes.update',['cliente'=>$cliente]) }}" method="post">
            @method('PATCH')
            @csrf
            <div class="card-header">
                <p>Tipo de cliente: <span class="fw-bold">
                        {{ strtoupper($cliente->persona->tipo->value)}}
                    </span></p>
            </div>
            <div class="card-body">

                <div class="row g-3">

                    <!-------Razón social------->
                    <div class="col-12">
                        <label id="label-razon-social" for="razon_social" class="form-label">
                            {{ $cliente->persona->tipo->value == 'NATURAL' ? 'Nombres y apellidos:' : 'Nombre de la empresa:'}}
                        </label>
                        <input type="text"
                            name="razon_social"
                            id="razon_social"
                            class="form-control"
                            value="{{old('razon_social',$cliente->persona->razon_social)}}">
                        @error('razon_social')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!------Dirección---->
                    <div class="col-12">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text"
                            name="direccion"
                            id="direccion"
                            class="form-control"
                            value="{{old('direccion',$cliente->persona->direccion)}}">
                        @error('direccion')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!------Email---->
                    <div class="col-md-6">
                        <label for="email" class="form-label">Correo eléctronico:</label>
                        <input type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            value="{{old('email',$cliente->persona->email)}}">
                        @error('email')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!------Telefono---->
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="number"
                            name="telefono"
                            id="telefono"
                            class="form-control"
                            value="{{old('telefono',$cliente->persona->telefono)}}">
                        @error('telefono')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!--------------Documento------->
                    <div class="col-md-6">
                        <label for="documento_id" class="form-label">
                            Tipo de documento:</label>
                        <select class="form-select" name="documento_id" id="documento_id" @if($cliente->persona->tipo->value == 'JURIDICA') disabled @endif>
                            @foreach ($documentos as $item)
                            <option value="{{ $item->id }}"
                                {{ old('documento_id', $cliente->persona->documento_id) == $item->id ? 'selected' : '' }}>
                                {{ $item->nombre }}
                            </option>
                            @endforeach
                        </select>
                        <!-- Input hidden para enviar documento_id cuando está deshabilitado -->
                        @if($cliente->persona->tipo->value == 'JURIDICA')
                            <input type="hidden" name="documento_id" value="{{ $cliente->persona->documento_id }}">
                            <small class="text-muted">El tipo de documento para clientes jurídicos es NIT (fijo)</small>
                        @endif
                        @error('documento_id')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="numero_documento" class="form-label">Número de documento:</label>
                        <input type="text"
                            name="numero_documento"
                            id="numero_documento"
                            class="form-control"
                            value="{{old('numero_documento',$cliente->persona->numero_documento)}}"
                            @if($cliente->persona->tipo->value == 'JURIDICA') disabled readonly @endif>
                        @if($cliente->persona->tipo->value == 'JURIDICA')
                            <input type="hidden" name="numero_documento" value="{{ $cliente->persona->numero_documento }}">
                            <small class="text-muted">El NIT para clientes jurídicos no se puede modificar</small>
                        @endif
                        @error('numero_documento')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                </div>

            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Actualizar label de razón social según tipo
        let tipoCliente = '{{ $cliente->persona->tipo->value }}';
        actualizarLabelRazonSocial(tipoCliente);

        function actualizarLabelRazonSocial(tipo) {
            if (tipo === 'NATURAL') {
                $('#label-razon-social').text('Nombres y apellidos:');
            } else if (tipo === 'JURIDICA') {
                $('#label-razon-social').text('Nombre de la empresa:');
            }
        }
    });
</script>
@endpush