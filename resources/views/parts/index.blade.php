@extends('layouts.app')
@section('title', 'Spare Part Data')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Spare Part Data
    </h1>
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap p-0">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('part.index')}}" class="text-muted">Spare Part Data &nbsp;</a>
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
<hr class="mt-0">
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card card-flush">
            <div class="card-header">
                <div class="card-toolbar flex-row-fluid justify-content-start gap-5">
                    <a href="{{route('part.create')}}" id="addButton"
                        class="btn btn-active-primary btn-primary ms-2 mt-5">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1"
                                    transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                            </svg></span>
                        Add spare part
                    </a>
                </div>
            </div>
            <div class="card-body fs-6 text-gray-700">
                <table id="table" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <th>Name</th>
                            <th>Type</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold fs-7 text-gray-600">
                        @foreach ($parts as $item)
                        <tr class="text-start">
                            <td>{{$item->name}}</td>
                            <td>{{$item->type}}</td>
                            <td>{{$item->stock}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{route('part.show', $item->id)}}" class="dropdown-item px-3">
                                                Detail part
                                            </a></li>
                                        <li><form action="{{route('part.destroy', $item->id)}}" method="post"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            {{-- <button type="submit" class="menu-link px-3">Delete</button> --}}
                                            <a class="dropdown-item px-3 delete" href="#">
                                                Delete
                                            </a>
                                        </form></li>
                                    </ul>
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
    const onClickDelete = () =>{
        $('.delete').on('click', function(event){
            event.preventDefault();
            console.log('trigger click');

            Swal.fire({
                customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-light'
                    },
                    title: "spare part will be deleted",
                    text: "Are you sure you want to delete the selected spare part? Data that has been deleted cannot be recovered.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $(this).closest('form').submit();
                }
            });
        });
    }

    onClickDelete();

    // datatable
    $("#table").DataTable({
        "searching": true,
        "ordering": true,
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "drawCallback": function( settings ) {
            onClickDelete();
        }
    });
</script>
@endpush