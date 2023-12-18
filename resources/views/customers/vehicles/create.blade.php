@extends('layouts.app')
@section('title', 'Add Vehicle')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Add Vehicle Data
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
                        <a href="{{ route('customer.show', $customer->id) }}" class="text-muted">Detail Customer
                            &nbsp;</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('vehicle.create', ['customer_id'=>$customer->id]) }}" class="text-muted">Add
                            Vehicle &nbsp;</a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->
        <!--begin::Toolbar-->
    </div>
</div>
@endsection
@section('content')
<div class="card card-flush">
    <form action="{{route('vehicle.store')}}" method="post" enctype="multipart/form-data">
        @csrf
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
                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Customer name</Label>
                <input type="text" class="form-control" name="name" id="name" placeholder="input customer name"
                    value="{{$customer->name}}" disabled>
                <input type="hidden" name="customer_id" id="customer_id" value="{{$customer->id}}">
            </div>

            <div class="mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Type</Label>
                        <select name="type" id="type" class="form-select" required data-control="select2" data-placeholder="Select an option" data-hide-search='true'>
                            <option></option>
                            <option value="car">Car</option>
                            <option value="motorbike">Motorbike</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Plat Number</Label>
                        <input type="text" class="form-control" name="plat_number" id="plat_number"
                            placeholder="Input plat number" value="{{old('plat_number')}}" required>
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
                            value="{{old('model')}}" required>
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Color</Label>
                        <input type="text" class="form-control" name="color" id="color"
                            placeholder="Input color vehicle" value="{{old('color')}}" required>
                    </div>
                </div>
            </div>

            <div class="footer d-flex justify-content-end py-10">
                <div class="d-flex justify-content-end">
                    <a href="{{route('customer.show', $customer->id)}}" id="cancelButton"
                        class="btn btn-light btn-active-light-primary me-3">Batalkan</a>
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