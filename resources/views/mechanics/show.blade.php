@extends('layouts.app')
@section('title', 'Detail Mechanic')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Detail Mechanic Data
    </h1>
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap p-0">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('mechanic.index') }}" class="text-muted">Mechanic Data &nbsp;</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('mechanic.show', $mechanic->id) }}" class="text-muted">Detail mechanic &nbsp;</a>
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
    <form action="{{route('mechanic.update', $mechanic->id)}}" method="post" enctype="multipart/form-data">
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
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Mechanic name</Label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="input mechanic name"
                            value="{{$mechanic->name}}" required disabled>
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Email</Label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-envelope-at" viewBox="0 0 16 16">
                                    <path
                                        d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z" />
                                    <path
                                        d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648Zm-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z" />
                                </svg>
                            </span>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Input email"
                                required aria-describedby="basic-addon3" value="{{$mechanic->email}}" disabled/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Expertise</Label>
                <textarea name="expertise" id="expertise" class="form-control" disabled required placeholder="Input mechanic expertise">{{{$mechanic->expertise}}}</textarea>
            </div>

            <div class="footer d-flex justify-content-end py-10">
                <div class="d-flex justify-content-end">
                    <button id="cancelButton" type="button"
                        class="btn btn-light btn-active-light-primary me-3">Batalkan</button>
                    <button id="save-mechanic" type="submit" class="btn btn-active-primary btn-primary"
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
        $('#name').attr('disabled', false);
        $('#email').attr('disabled', false);
        $('#expertise').attr('disabled', false);
        $('#cancelButton').show();
        $('#save-mechanic').show();
    }

    // function for disable edit form
    const disableForm = () => {
        $('#edit').show();
        $('#name').attr('disabled', true);
        $('#email').attr('disabled', true);
        $('#expertise').attr('disabled', true);
        $('#cancelButton').hide();
        $('#save-mechanic').hide();
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