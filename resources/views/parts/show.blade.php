@extends('layouts.app')
@section('title', 'Detail Spare Part')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Detail Spare Part Data
    </h1>
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap p-0">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('part.index') }}" class="text-muted">Spare Part Data &nbsp;</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('part.show', $part->id) }}" class="text-muted">Detail Spare Part &nbsp;</a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <button type="button" class="btn btn-sm btn-primary" id="edit">
                <i class="bi bi-pencil-fill"></i> Edit
            </button>
        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
    </div>
</div>
@endsection
@section('content')
<div class="card card-flush">
    <form action="{{route('part.update', $part->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body fs-6 text-gray-700">
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There are some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Part name</Label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="input part name"
                            value="{{$part->name}}" required>
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Type</Label>
                        <select name="type" id="type" class="form-select" required data-control="select2" data-placeholder="Select an option" data-hide-search='true'>
                            <option></option>
                            <option value="car" {{$part->type == 'car' ? 'selected' : ''}}>Car</option>
                            <option value="motorbike" {{$part->type == 'motorbike' ? 'selected' : ''}}>Motorbike</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Stock</Label>
                        <input type="number" class="form-control" name="stock" id="stock" placeholder="Input stock spare part"
                            value="{{$part->stock}}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required fs-6 fw-bold mt-2 mb-3">Price (per stock)</label>
                        <input type="text" class="form-control" name="price"
                            id="price" placeholder="Input price per stock" value="{{$part->price}}">
                        <!--begin::Hint-->
                        <div class="text-muted">
                            contoh : Rp 25.000
                        </div>
                        <!--end::Hint-->
                    </div>
                </div>
            </div>

            <div class="footer d-flex justify-content-end py-10">
                <div class="d-flex justify-content-end">
                    <button id="cancelButton" type="button"
                        class="btn btn-light btn-active-light-primary me-3">Batalkan</button>
                    <button id="save-part" type="submit" class="btn btn-active-primary btn-primary"
                        data-kt-indicator="off">
                        <span class="indicator-label">
                            Save
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){
        var price = formatRupiah($('#price').val(), 'Rp ');
        $('#price').val(price);
    });
    convertRupiah('price');
    // function for enable edit form
    const enableForm = () => {
        $('#edit').hide();
        $('#name').attr('disabled', false);
        $('#type').attr('disabled', false);
        $('#stock').attr('disabled', false);
        $('#price').attr('disabled', false);
        $('#cancelButton').show();
        $('#save-part').show();
    }

    // function for disable edit form
    const disableForm = () => {
        $('#edit').show();
        $('#name').attr('disabled', true);
        $('#type').attr('disabled', true);
        $('#stock').attr('disabled', true);
        $('#price').attr('disabled', true);
        $('#cancelButton').hide();
        $('#save-part').hide();
    }

    $(document).ready(function(){
        disableForm();
    });

    $('#edit').on('click', function(){
        enableForm();
    });

    $('#cancelButton').on('click', function(){
        disableForm();
    });
</script>
@endpush