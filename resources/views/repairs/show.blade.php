@extends('layouts.app')
@section('title', 'Detail Repair')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Detail Repair Data
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
                        <a href="{{ route('repair.show', $repair->id) }}" class="text-muted">Detail repair &nbsp;</a>
                    </li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            @if ($repair->payment == null)
            <a href="{{route('payment.create')}}" class="btn btn-sm btn-primary"><i class="bi bi-credit-card"></i> Payment</a>
            @endif
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
    <form action="{{route('repair.update', $repair->id)}}" method="post" enctype="multipart/form-data">
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
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Customer name</Label>
                        <select name="customer_id" id="customer_id" class="form-control" required data-control="select2"
                            disabled data-placeholder="Select customer">
                            <option></option>
                            @foreach ($customers as $item)
                            <option value="{{$item->id}}" {{$item->id == $repair->vehicle->customer_id ? 'selected' :
                                ''}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Vehicle</Label>
                        <select name="vehicle_id" id="vehicle_id" class="form-control" required disabled>
                            <option value="{{$repair->vehicle_id}}">{{$repair->vehicle->model}}
                                ({{$repair->vehicle->type_text}})</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Mechanic name</Label>
                        <select name="mechanic_id" id="mechanic_id" class="form-control" required data-control="select2"
                            disabled data-placeholder="Select mechanic">
                            <option></option>
                            @foreach ($mechanics as $item)
                            <option value="{{$item->id}}" {{$item->id == $repair->mechanic_id ? 'selected' :
                                ''}}>{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Repair Date</Label>
                        <input type="date" name="repair_date" id="repair_date" class="form-control" required disabled
                            value="{{$repair->repair_date}}">
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <div class="row">
                    <div class="col-md-4">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Start Time</Label>
                        <input type="text" name="start_time" id="start_time" class="form-control" required disabled
                            value="{{$repair->start_time}}">
                    </div>
                    <div class="col-md-4">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">End Time</Label>
                        <input type="text" name="end_time" id="end_time" class="form-control" required disabled
                            value="{{$repair->end_time}}">
                    </div>
                    <div class="col-md-4">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Status</Label>
                        <select name="status" id="status" class="form-control" disabled required data-control="select2"
                            data-placeholder="Select an option" data-hide-search='true'>
                            <option></option>
                            <option value="1" {{$repair->status == 1 ? 'selected' : ''}}>In Progress</option>
                            <option value="2" {{$repair->status == 2 ? 'selected' : ''}}>Complete</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Issue</Label>
                <textarea name="issue" id="issue" class="form-control" required disabled
                    placeholder="Input vehicle issue">{{$repair->issue}}</textarea>
            </div>

            <div class="footer d-flex justify-content-end py-10">
                <div class="d-flex justify-content-end">
                    <button id="cancelButton" type="button"
                        class="btn btn-light btn-active-light-primary me-3">Batalkan</button>
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

@if ($repair->payment)
<div class="row justify-content-center mt-5">
    <div class="col-md-12">
        <div class="card card-flush">
            <div class="card-header">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative">
                        <h2>Payment Data</h2>
                    </div>
                </div>
            </div>
            <hr>
            <div class="card-body fs-6 text-gray-700">
                <form action="{{route('payment.update', $repair->payment->id)}}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

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
                                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Total Payment</Label>
                                <input type="text" name="total_payment" id="total_payment" class="form-control" disabled
                                    value="{{$repair->payment->total}}">
                                <input type="hidden" name="total" id="total" value="{{$repair->payment->total}}">
                            </div>
                            <div class="col-md-6">
                                <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Payment Date</Label>
                                <input type="date" name="payment_date" id="payment_date" class="form-control" required
                                    value="{{$payment_date}}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <div class="row">
                            <div class="col-md-4">
                                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Service Charge</Label>
                                <input type="text" name="service" id="service" class="form-control" disabled
                                    value="Service charge per hour">
                                <input type="hidden" name="service_detail_id" value="{{$repair->payment->paymentDetails->first()->id ?? null}}">
                            </div>
                            <div class="col-md-4">
                                <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Process Time (hour)</Label>
                                <input type="number" name="process_time" id="process_time" class="form-control" required
                                    value="{{$repair->payment->paymentDetails->first()->quantity ?? 0}}">
                            </div>
                            <div class="col-md-4">
                                <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Amount</Label>
                                <input type="text" name="service_amount" id="service_amount" class="form-control"
                                    required value="{{$repair->payment->paymentDetails->first()->amount ?? '0'}}">
                            </div>
                        </div>
                    </div>

                    <hr class="mt-10 mb-5">
                    <div class="mb-5">
                        <div id="repeater">
                            <div class="form-group">
                                <div data-repeater-list="repeater">
                                    @foreach ($repair->payment->paymentDetails as $detail)
                                    @if ($loop->index != 0)
                                    <div data-repeater-item>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <input type="hidden" name="detail_id" value="{{$detail->id}}">
                                                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Spare Part</Label>
                                                <select name="part_id" class="form-control part"
                                                    data-kt-repeater="select2" data-placeholder="Select spare part">
                                                    <option></option>
                                                    @foreach ($parts as $item)
                                                    <option value="{{$item->id}}" {{$item->id == $detail->part_id ?
                                                        'selected' :
                                                        ''}}>{{$item->name}} (Stock : {{$item->stock}})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Quantity</Label>
                                                <input type="number" class="form-control quantity" name="quantity"
                                                    placeholder="Input quantity" value="{{$detail->quantity}}" disabled>
                                            </div>
                                            <div class="col-md-4">
                                                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Amount</Label>
                                                <input type="text" class="form-control amount" name="amount"
                                                    placeholder="Input amount" value="{{$detail->amount}}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-8">
                                                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Note</Label>
                                                <textarea name="note" class="form-control note" disabled
                                                    placeholder="Input note">{{$detail->note}}</textarea>
                                            </div>
                                            <div class="col-md-4 btn_delete">
                                                <Label class="form-label fs-6 fw-bold mt-2 mb-3"></Label>
                                                <a href="javascript:;" data-repeater-delete
                                                    class="btn btn-sm btn-light-danger mt-3 mt-md-12">
                                                    <i class="bi bi-trash"></i>
                                                    Hapus barang
                                                </a>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group mt-5" id="btn_add">
                                <a href="javascript:;" data-repeater-create class="btn btn-primary">
                                    <i class="bi bi-plus-lg"></i>
                                    Tambah barang
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="footer d-flex justify-content-end py-10">
                        <div class="d-flex justify-content-end">
                            <button id="cancelButtonPayment" type="button"
                                class="btn btn-light btn-active-light-primary me-3">Batalkan</button>
                            <button id="save-payment" type="submit" class="btn btn-active-primary btn-primary"
                                data-kt-indicator="off">
                                <span class="indicator-label">
                                    Save
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    $("#start_time").daterangepicker({
        timePicker: true,
        singleDatePicker: true,
        timePicker24Hour: true,
        minDate: "{{$constraint_min_date}}",
        locale: {
            format: "Y-M-D H:mm",
        }
    });

    $("#end_time").daterangepicker({
        timePicker: true,
        singleDatePicker: true,
        timePicker24Hour: true,
        minDate: $("#start_time").val(),
        locale: {
            format: "Y-M-D H:mm",
        }
    });

    $(document).on("change", "#start_time", function() {
        $("#end_time").daterangepicker({
            timePicker: true,
            singleDatePicker: true,
            timePicker24Hour: true,
            minDate: $("#start_time").val(),
            locale: {
                format: "Y-M-D H:mm",
            }
        });
        fillPeriod();
    });

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

    // function format input to rupiah
    const priceFormat = () =>{
        $('.amount').each(function(){
            var amount_format = $(this).val();
            $(this).val(formatRupiah(amount_format, 'Rp '));
        });
    }

    priceFormat();

    $(document).ready(function(){
        var total_payment = formatRupiah($('#total_payment').val(), 'Rp ');
        $('#total_payment').val(total_payment);
        var service_amount = formatRupiah($('#service_amount').val(), 'Rp ');
        $('#service_amount').val(service_amount);
    });

    convertRupiah('service_amount');

    // function for enable edit form
    const enableForm = () => {
        $('#edit').hide();
        $('#customer_id').attr('disabled', false);
        $('#vehicle_id').attr('disabled', false);
        $('#mechanic_id').attr('disabled', false);
        $('#repair_date').attr('disabled', false);
        $('#start_time').attr('disabled', false);
        $('#end_time').attr('disabled', false);
        $('#status').attr('disabled', false);
        $('#issue').attr('disabled', false);

        $('#payment_date').attr('disabled', false);
        $('#process_time').attr('disabled', false);
        $('#service_amount').attr('disabled', false);
        $('.part').attr('disabled', false);
        $('.quantity').attr('disabled', false);
        $('.amount').attr('disabled', false);
        $('.note').attr('disabled', false);

        $('#cancelButton').show();
        $('#save-repair').show();
        $('#cancelButtonPayment').show();
        $('#save-payment').show();
        $('.btn_delete').show();
        $('#btn_add').show();
    }

    // function for disable edit form
    const disableForm = () => {
        $('#edit').show();
        $('#customer_id').attr('disabled', true);
        $('#vehicle_id').attr('disabled', true);
        $('#mechanic_id').attr('disabled', true);
        $('#repair_date').attr('disabled', true);
        $('#start_time').attr('disabled', true);
        $('#end_time').attr('disabled', true);
        $('#status').attr('disabled', true);
        $('#issue').attr('disabled', true);

        $('#payment_date').attr('disabled', true);
        $('#process_time').attr('disabled', true);
        $('#service_amount').attr('disabled', true);
        $('.part').attr('disabled', true);
        $('.quantity').attr('disabled', true);
        $('.amount').attr('disabled', true);
        $('.note').attr('disabled', true);

        $('#cancelButton').hide();
        $('#save-repair').hide();
        $('#cancelButtonPayment').hide();
        $('#save-payment').hide();
        $('.btn_delete').hide();
        $('#btn_add').hide();
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

    $('#cancelButtonPayment').on('click', function(){
        disableForm();
    });

    $('#repeater').repeater({
        initEmpty: false,

        show: function () {
            $(this).slideDown();
            priceFormat();
            enableForm();
            // Re-init select2
            $(this).find('[data-kt-repeater="select2"]').select2();
        },

        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        },

        ready: function(){
            // Init select2
            $('[data-kt-repeater="select2"]').select2();
        }
    });

    // function for calculate subtotal
    const calculateTotal = () => {
        var total = 0;
        var price_service = $('#service_amount').val();
        price_service = price_service.replace("Rp ", "");
        price_service = price_service.replace(".","");
        price_service = parseInt(price_service);
        total += price_service;
        $('.amount').each(function(){
            var price_format = $(this).val();
            price_format = price_format.replace("Rp ", "");
            price_format = price_format.replace(".","");
            price_format = parseInt(price_format);
            total += price_format;
        });
        $('#total').val(total);
        total = total.toString();
        $('#total_payment').val(formatRupiah(total, 'Rp '));
    }

    // always calculate subtotal when mouse move on card
    $('.card').on('mousemove', function(){
        calculateTotal();        
    });

    $('.amount').on('keyup', function(){
        priceFormat();
    });
</script>
@endpush