@extends('layouts.app')

@section('title','Editar Servicio')

@push('css')
<style>
    #descripcion {
        resize: none;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Servicio</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('servicios.index')}}">Servicios</a></li>
        <li class="breadcrumb-item active">Editar servicio</li>
    </ol>

    <div class="card text-bg-light">
        <form action="{{route('servicios.update',['servicio'=>$servicio])}}" method="post" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="card-body">

                <div class="row g-4">

                    <!----Codigo---->
                    <div class="col-md-6">
                        <label for="codigo" class="form-label">Código:</label>
                        <input type="text" name="codigo" id="codigo"
                            class="form-control"
                            value="{{old('codigo',$servicio->codigo)}}">
                        @error('codigo')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <p class="form-label">Código de barras</p>

                        <?php
                        require base_path('vendor/autoload.php');
                        $codigo = $servicio->codigo;
                        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();

                        try {
                            echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($codigo, $generator::TYPE_EAN_13)) . '">';
                        } catch (Exception $e) {
                            echo "Formato no compatible";
                        }
                        ?>
                    </div>

                    <!---Nombre---->
                    <div class="col-12">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text"
                            name="nombre"
                            id="nombre"
                            class="form-control"
                            value="{{old('nombre',$servicio->nombre)}}">
                        @error('nombre')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!---Codigosin---->
                    <div class="col-12">
                        <label for="codigosin" class="form-label">Código SIN:</label>
                        <input type="text" name="codigosin" id="codigosin" class="form-control" value="{{old('codigosin',$servicio->codigosin)}}">
                        @error('codigosin')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                    <!---Descripción---->
                    <div class="col-12">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea
                            name="descripcion"
                            id="descripcion"
                            rows="3"
                            class="form-control">{{old('descripcion',$servicio->descripcion)}}</textarea>
                        @error('descripcion')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>

                </div>

                <br>

                <div class="row g-4">

                    <div class="col-md-12">

                        <div class="row g-4">
                            <!---Nombre---->
                        <div class="col-6">
                            <label for="precio" class="form-label">Precio:</label>
                            <input type="number"
                                step="0.01"
                                name="precio"
                                id="precio"
                                class="form-control"
                                value="{{old('precio',$servicio->precio)}}">
                            @error('precio')
                            <small class="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                          <!---Presentaciones---->
                            <div class="col-6 d-none">
                                <label for="presentacione_id" class="form-label">Presentación:</label>
                                <select data-size="4"
                                    title="Seleccione una presentación"
                                    data-live-search="true"
                                    name="presentacione_id"
                                    id="presentacione_id"
                                    class="form-control selectpicker show-tick">
                                    <option value="1" selected>
                                        Unidad Servicio
                                    </option>
                                </select>
                                @error('presentacione_id')
                                <small class="text-danger">{{'*'.$message}}</small>
                                @enderror
                            </div>

                            <!---Categoría---->
                            <div class="col-6">
                                <label for="categoria_id" class="form-label">Categoría:</label>
                                <select data-size="4"
                                    title="Seleccione la categoría"
                                    data-live-search="true"
                                    name="categoria_id"
                                    id="categoria_id"
                                    class="form-control selectpicker show-tick">
                                    <option value="">No tiene categoría</option>
                                    @foreach ($categorias as $item)
                                    <option value="{{$item->id}}"
                                        {{ $servicio->categoria_id == $item->id || old('categoria_id') == $item->id ? 'selected' : '' }}>
                                        {{$item->nombre}}
                                    </option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                <small class="text-danger">{{'*'.$message}}</small>
                                @enderror
                            </div>
                        </div>

                    </div>

                </div>

            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="reset" class="btn btn-secondary">Reiniciar</button>
            </div>
        </form>
    </div>



</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
    const inputImagen = document.getElementById('img_path');
    const imagenPreview = document.getElementById('img-preview');
    const imagenDefault = document.getElementById('img-default');

    inputImagen.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                imagenPreview.src = e.target.result;
                imagenPreview.style.display = 'block';
                imagenDefault.style.display = 'none';
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
@endpush