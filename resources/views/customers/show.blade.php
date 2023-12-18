@extends('layouts.app')
@section('title', 'Detail Customer')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Detail Customer Data
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
                        <a href="{{ route('customer.show', $customer->id) }}" class="text-muted">Detail Customer &nbsp;</a>
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
    <form action="{{route('customer.update', $customer->id)}}" method="post" enctype="multipart/form-data">
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
                <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Customer name</Label>
                <input type="text" class="form-control" name="name" id="name" placeholder="input customer name"
                    value="{{$customer->name}}" required disabled>
            </div>

            <div class="mb-5">
                <div class="row">
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
                                required aria-describedby="basic-addon3" value="{{$customer->email}}" disabled />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Phonenumber</Label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-whatsapp" viewBox="0 0 16 16">
                                    <path
                                        d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                </svg>
                            </span>
                            <input type="text" class="form-control" name="phone_number" id="phone_number"
                                placeholder="Input phonenumber" value="{{$customer->phone_number}}" required disabled>
                        </div>
                        <!--begin::Hint-->
                        <div class="text-muted">
                            example : +6282233445566
                        </div>
                        <!--end::Hint-->
                    </div>
                </div>
            </div>

            <div class="footer d-flex justify-content-end py-10">
                <div class="d-flex justify-content-end">
                    <button id="cancelButton" type="button"
                        class="btn btn-light btn-active-light-primary me-3">Batalkan</button>
                    <button id="save-customer" type="submit" class="btn btn-active-primary btn-primary"
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
<div class="row justify-content-center mt-5">
    <div class="col-md-12">
        <div class="card card-flush">
            <div class="card-header">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <h2>User Vehicle Data</h2>
                    </div>
                </div>
                <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                    <a href="{{route('vehicle.create', ['customer_id' => $customer->id])}}" id="addButton" class="btn btn-active-primary btn-primary ms-2 mt-5">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                            </svg></span>
                        Add Vehicle
                    </a>
                </div>
            </div>
            <hr>
            <div class="card-body fs-6 text-gray-700">
                <table id="table" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>Model</th>
                            <th>Color</th>
                            <th>Type</th>
                            <th>Plat Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold fs-7 text-gray-600">
                        @foreach ($vehicles as $item)
                        <tr class="text-start">
                            <td>{{$item->model}}</td>
                            <td>{{$item->color}}</td>
                            <td>{{$item->type_text}}</td>
                            <td>{{$item->plat_number}}</td>
                            <td>
                                <div class="dropdown text-start">
                                    <button type="button"
                                        class="btn btn-secondary btn-sm btn-active-light-primary rotate opacity-50"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                                        Actions
                                        <span class="svg-icon svg-icon-3 rotate-180 ms-3 me-0">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                    fill="currentColor"></path>
                                            </svg>
                                        </span>
                                    </button>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px"
                                        data-kt-menu="true">

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="{{route('vehicle.show', $item->id)}}" class="menu-link px-3">
                                                Detail Vehicle
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator mb-3 opacity-75"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <form action="{{route('vehicle.destroy', $item->id)}}" method="post" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                {{-- <button type="submit" class="menu-link px-3">Delete</button> --}}
                                                <a class="menu-link px-3 delete">
                                                    Delete
                                                </a>
                                            </form>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $("#table").DataTable({
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
    });

    // function for enable edit form
    const enableForm = () => {
        $('#edit').hide();
        $('#name').attr('disabled', false);
        $('#email').attr('disabled', false);
        $('#phone_number').attr('disabled', false);
        $('#cancelButton').show();
        $('#save-customer').show();
    }

    // function for disable edit form
    const disableForm = () => {
        $('#edit').show();
        $('#name').attr('disabled', true);
        $('#email').attr('disabled', true);
        $('#phone_number').attr('disabled', true);
        $('#cancelButton').hide();
        $('#save-customer').hide();
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

    $('.delete').on('click', function(event){
        event.preventDefault();

        Swal.fire({
            customClass: {
                    confirmButton: 'btn btn-danger',
                    cancelButton: 'btn btn-light'
                },
                title: "Customer will be deleted",
                text: "Are you sure you want to delete the selected vehicle? Data that has been deleted cannot be recovered.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
        }).then((result) => {
            if (result.isConfirmed) {
                $(this).closest('form').submit();
            }
        });
    });
</script>
@endpush