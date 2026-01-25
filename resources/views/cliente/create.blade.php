@extends('layouts.app')

@section('title','Crear cliente')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<style>
    .campo-oculto {
        display: none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Cliente</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('clientes.index')}}">Clientes</a></li>
        <li class="breadcrumb-item active">Crear cliente</li>
    </ol>

    <div class="card">
        <form action="{{ route('clientes.store') }}" method="post">
            @csrf
            <div class="card-body text-bg-light">

                <div class="row g-3">

                    <!----Tipo de persona----->
                    <div class="col-md-6">
                        <label for="tipo" class="form-label">Tipo de cliente:</label>
                        <select class="form-select" name="tipo" id="tipo">
                            <option value="" selected disabled>Seleccione una opción</option>
                            @foreach ($optionsTipoPersona as $item)
                            <option value="{{$item->value}}" {{ old('tipo') == $item->value ? 'selected' : '' }}>{{$item->name}}</option>
                            @endforeach
                        </select>
                        @error('tipo')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!-------Razón social------->
                    <div class="col-12 campo-oculto" id="box-razon-social">
                        <label id="label-natural" for="razon_social" class="form-label d-none">Nombres y apellidos:</label>
                        <label id="label-juridica" for="razon_social" class="form-label d-none">Nombre de la empresa:</label>

                        <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{old('razon_social')}}" placeholder="Ingrese el nombre" disabled>

                        @error('razon_social')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!------Dirección---->
                    <div class="col-12 campo-oculto" id="box-direccion">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" name="direccion" id="direccion" class="form-control" value="{{old('direccion')}}" disabled>
                        @error('direccion')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!------Email---->
                    <div class="col-md-6 campo-oculto" id="box-email">
                        <label for="email" class="form-label">Correo eléctronico:</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" disabled>
                        @error('email')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!------Telefono---->
                    <div class="col-md-6 campo-oculto" id="box-telefono">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="number" name="telefono" id="telefono" class="form-control" value="{{old('telefono')}}" disabled>
                        @error('telefono')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!--------------Documento------->
                    <div class="col-md-6 campo-oculto" id="box-documento">
                        <label for="documento_id" class="form-label">Tipo de documento:</label>
                        <select class="form-select" name="documento_id" id="documento_id" disabled>
                            <option value="" selected disabled>Seleccione una opción</option>
                            @foreach ($documentos as $item)
                            <option value="{{$item->id}}" {{ old('documento_id') == $item->id ? 'selected' : '' }}>{{$item->nombre}}</option>
                            @endforeach
                        </select>
                        <!-- Input hidden para enviar documento_id cuando está deshabilitado -->
                        <input type="hidden" name="documento_id" id="documento_id_hidden" value="">
                        @error('documento_id')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 campo-oculto" id="box-numero-documento">
                        <label for="numero_documento" class="form-label">Numero de documento:</label>
                        <div class="input-group">
                            <input type="text" name="numero_documento" id="numero_documento" class="form-control" value="{{old('numero_documento')}}" disabled>
                            <button type="button" class="btn btn-outline-secondary d-none" id="btn-verificar-nit">
                                <span class="spinner-border spinner-border-sm d-none me-2" id="spinner-verificacion" role="status" aria-hidden="true"></span>
                                Verificar NIT
                            </button>
                        </div>
                        <small class="text-muted d-none" id="msg-verificacion"></small>
                        @error('numero_documento')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary" id="btn-guardar" disabled>Guardar</button>
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>


</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Variables globales para validación NIT
        let nitVerificado = false;

        // Inicializar estado del formulario
        manejarTipoCliente();

        // Manejar cambio de tipo cliente
        $('#tipo').on('change', function() {
            manejarTipoCliente();
            nitVerificado = false; // Reset verificación al cambiar tipo
        });

        // Manejar cambios en campos para validar formulario
        $('.form-control, .form-select').not('#tipo').on('change input', function() {
            if ($(this).attr('id') === 'numero_documento') {
                nitVerificado = false; // Reset verificación al cambiar NIT
                actualizarBotonesVerificacion();
            }
            // Sincronizar documento_id con el input hidden si cambió
            if ($(this).attr('id') === 'documento_id') {
                $('#documento_id_hidden').val($(this).val());
            }
            validarFormulario();
        });

        // Manejar click en botón verificar NIT
        $('#btn-verificar-nit').on('click', function() {
            verificarNitSiat();
        });

        function manejarTipoCliente() {
            let tipo = $('#tipo').val();

            if (!tipo) {
                // Si no hay tipo seleccionado, ocultar todos los campos
                ocultarTodosCampos();
                $('#btn-guardar').prop('disabled', true);
            } else if (tipo === 'NATURAL') {
                // Cliente Natural
                mostrarTodosCampos();
                $('#label-natural').removeClass('d-none').show();
                $('#label-juridica').addClass('d-none').hide();
                $('#documento_id').prop('disabled', false);
                $('#btn-verificar-nit').addClass('d-none'); // Ocultar botón verificar
                nitVerificado = true; // No necesita verificación
            } else if (tipo === 'JURIDICA') {
                // Cliente Jurídico
                mostrarTodosCampos();
                $('#label-juridica').removeClass('d-none').show();
                $('#label-natural').addClass('d-none').hide();
                
                // Preseleccionar NIT (id = 5) y deshabilitar
                $('#documento_id').val(5).prop('disabled', true);
                // Sincronizar el input hidden para que se envíe al servidor
                $('#documento_id_hidden').val(5);
                nitVerificado = false; // Necesita verificación
                actualizarBotonesVerificacion();
            }

            validarFormulario();
        }

        function ocultarTodosCampos() {
            // Ocultar todos los campos excepto tipo
            $('#box-razon-social, #box-direccion, #box-email, #box-telefono, #box-documento, #box-numero-documento')
                .addClass('campo-oculto')
                .hide();
            
            // Deshabilitar todos los inputs
            $('input[name="razon_social"], input[name="direccion"], input[name="email"], input[name="telefono"], input[name="numero_documento"], select[name="documento_id"]')
                .prop('disabled', true)
                .val('');
            
            // Limpiar input hidden
            $('#documento_id_hidden').val('');
        }

        function mostrarTodosCampos() {
            // Mostrar todos los campos
            $('#box-razon-social, #box-direccion, #box-email, #box-telefono, #box-documento, #box-numero-documento')
                .removeClass('campo-oculto')
                .show();

            // Habilitar todos los inputs
            $('input[name="razon_social"], input[name="direccion"], input[name="email"], input[name="telefono"], input[name="numero_documento"]')
                .prop('disabled', false);
        }

        function actualizarBotonesVerificacion() {
            let tipo = $('#tipo').val();
            let numeroDocumento = $('#numero_documento').val().trim();

            if (tipo === 'JURIDICA' && numeroDocumento) {
                $('#btn-verificar-nit').removeClass('d-none');
            } else {
                $('#btn-verificar-nit').addClass('d-none');
            }
        }

        function verificarNitSiat() {
            let numeroDocumento = $('#numero_documento').val().trim();

            if (!numeroDocumento) {
                alert('Por favor ingrese el NIT');
                return;
            }

            // Deshabilitar botón y mostrar spinner
            $('#btn-verificar-nit').prop('disabled', true);
            $('#spinner-verificacion').removeClass('d-none');
            $('#msg-verificacion').addClass('d-none').html('');

            $.ajax({
                url: '/api/clientes/verificar-nit',
                type: 'POST',
                data: {
                    nit: numeroDocumento,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#spinner-verificacion').addClass('d-none');
                    $('#msg-verificacion').removeClass('d-none');

                    if (response.valido) {
                        // NIT válido
                        $('#numero_documento').addClass('is-valid').removeClass('is-invalid');
                        $('#msg-verificacion').html('✓ ' + response.descripcion).addClass('text-success').removeClass('text-danger');
                        nitVerificado = true;
                        $('#btn-verificar-nit').prop('disabled', false);
                        validarFormulario();
                    } else {
                        // NIT inválido
                        $('#numero_documento').addClass('is-invalid').removeClass('is-valid');
                        $('#msg-verificacion').html('✗ ' + response.descripcion).addClass('text-danger').removeClass('text-success');
                        nitVerificado = false;
                        $('#btn-verificar-nit').prop('disabled', false);
                        validarFormulario();
                    }
                },
                error: function(xhr) {
                    $('#spinner-verificacion').addClass('d-none');
                    $('#msg-verificacion').removeClass('d-none');
                    $('#numero_documento').addClass('is-invalid').removeClass('is-valid');
                    $('#msg-verificacion').html('✗ Error al verificar NIT').addClass('text-danger').removeClass('text-success');
                    nitVerificado = false;
                    $('#btn-verificar-nit').prop('disabled', false);
                    validarFormulario();
                }
            });
        }

        function validarFormulario() {
            let tipo = $('#tipo').val();
            let razonSocial = $('#razon_social').val().trim();
            let documento = $('#documento_id').val();
            let numeroDocumento = $('#numero_documento').val().trim();

            let valido = tipo && razonSocial && documento && numeroDocumento;

            // Para jurídicas, además debe estar verificado el NIT
            if (tipo === 'JURIDICA') {
                valido = valido && nitVerificado;
            }

            $('#btn-guardar').prop('disabled', !valido);
        }
    });
</script>
@endpush