@extends('layouts.app')
@section('title', 'Detail Vehicle')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Detail Vehicle Data
    </h1>
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap p-0">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('customer.index') }}" class="text-muted">Customer Data &nbsp;</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('customer.show', $vehicle->customer_id) }}" class="text-muted">Detail Customer &nbsp;</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('vehicle.show', $vehicle->id) }}" class="text-muted">Detail Vehicle &nbsp;</a>
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
    <form action="{{route('vehicle.update', $vehicle->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body fs-6 text-gray-700">
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="mb-5">
                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Customer name</Label>
                <input type="text" class="form-control" name="name" id="name" placeholder="input customer name"
                    value="{{$vehicle->customer->name}}" disabled>
                <input type="hidden" name="customer_id" id="customer_id" value="{{$vehicle->customer_id}}">
            </div>

            <div class="mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Type</Label>
                        <select name="type" id="type" class="form-select" required data-control="select2" data-placeholder="Select an option" data-hide-search='true' disabled>
                            <option></option>
                            <option value="car" {{$vehicle->type=='car'?'selected':''}}>Car</option>
                            <option value="motorbike" {{$vehicle->type=='motorbike'?'selected':''}}>Motorbike</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Plat Number</Label>
                        <input type="text" class="form-control" name="plat_number" id="plat_number"
                            placeholder="Input plat number" value="{{$vehicle->plat_number}}" required disabled>
                        <!--begin::Hint-->
                        <div class="text-muted">
                            example : L 4321 AAF
                        </div>
                        <!--end::Hint-->
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Model Name</Label>
                        <input type="text" class="form-control" name="model" id="model" placeholder="Input model name"
                            value="{{$vehicle->model}}" required disabled>
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Color</Label>
                        <input type="text" class="form-control" name="color" id="color"
                            placeholder="Input color vehicle" value="{{$vehicle->color}}" required disabled>
                    </div>
                </div>
            </div>

            <div class="footer d-flex justify-content-end py-10">
                <div class="d-flex justify-content-end">
                    <button id="cancelButton"
                        class="btn btn-light btn-active-light-primary me-3">Batalkan</button>
                    <button id="save-vehicle" type="submit" class="btn btn-active-primary btn-primary"
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

    // function for enable edit form
    const enableForm = () => {
        $('#edit').hide();
        $('#type').attr('disabled', false);
        $('#plat_number').attr('disabled', false);
        $('#model').attr('disabled', false);
        $('#color').attr('disabled', false);
        $('#cancelButton').show();
        $('#save-vehicle').show();
    }

    // function for disable edit form
    const disableForm = () => {
        $('#edit').show();
        $('#type').attr('disabled', true);
        $('#plat_number').attr('disabled', true);
        $('#model').attr('disabled', true);
        $('#color').attr('disabled', true);
        $('#cancelButton').hide();
        $('#save-vehicle').hide();
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