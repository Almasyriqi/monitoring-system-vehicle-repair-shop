@extends('layouts.app')
@section('title', 'Add Repair')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Add Repair Data
    </h1>
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap p-0">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('repair.index') }}" class="text-muted">Repair Data &nbsp;</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('repair.create') }}" class="text-muted">Add repair &nbsp;</a>
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
    <form action="{{route('repair.store')}}" method="post" enctype="multipart/form-data">
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
                <div class="row">
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Customer name</Label>
                        <select name="customer_id" id="customer_id" class="form-control" required data-control="select2"
                            data-placeholder="Select customer">
                            <option></option>
                            @foreach ($customers as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Vehicle</Label>
                        <select name="vehicle_id" id="vehicle_id" class="form-control" required>
                            <option></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Mechanic name</Label>
                        <select name="mechanic_id" id="mechanic_id" class="form-control" required data-control="select2"
                            data-placeholder="Select mechanic">
                            <option></option>
                            @foreach ($mechanics as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Repair Date</Label>
                        <input type="date" name="repair_date" id="repair_date" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Issue</Label>
                <textarea name="issue" id="issue" class="form-control" required placeholder="Input vehicle issue"></textarea>
            </div>

            <div class="footer d-flex justify-content-end py-10">
                <div class="d-flex justify-content-end">
                    <a href="{{route('repair.index')}}" id="cancelButton"
                        class="btn btn-light btn-active-light-primary me-3">Batalkan</a>
                    <button id="save-repair" type="submit" class="btn btn-active-primary btn-primary"
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
    // function get data when select2 changes
    function onChangeSelect(customer_id) {
        $('#vehicle_id').select2({
            ajax: {
                url: "{{route('vehicles')}}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: 'public',
                        customer_id: customer_id
                    }
        
                    return query;
                },
            },
            placeholder: "Select vehicle",
        });
    }

    $('#customer_id').on('change', function(){
        onChangeSelect($(this).val());
    });
</script>
@endpush