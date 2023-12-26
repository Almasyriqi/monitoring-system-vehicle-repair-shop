@extends('layouts.app')
@section('title', 'Add Payment Repair')
@section('page-title')
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 w-100   ">
    <h1 class="page-heading d-flex text-dark fw-bold flex-column justify-content-center my-0">
        Add Payment Repair Data
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
                        <a href="{{ route('repair.show', $repair->id) }}" class="text-muted">Detail Repair &nbsp;</a>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('payment.create', ['repair_id'=>$repair->id]) }}" class="text-muted">Add
                            Payment &nbsp;</a>
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
    <form action="{{route('payment.store')}}" method="post" enctype="multipart/form-data">
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
                        <Label class="form-label fs-6 fw-bold mt-2 mb-3">Customer name</Label>
                        <input type="text" name="customer" id="customer" class="form-control"
                            value="{{$repair->vehicle->customer->name}}" disabled>
                        <input type="hidden" name="repair_id" id="repair_id" value="{{$repair->id}}">
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label fs-6 fw-bold mt-2 mb-3">Vehicle</Label>
                        <input type="text" name="vehicle" id="vehicle" class="form-control" value="{{$vehicle}}"
                            disabled>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <Label class="form-label fs-6 fw-bold mt-2 mb-3">Mechanic name</Label>
                        <input type="text" name="mechanic" id="mechanic" class="form-control"
                            value="{{$repair->mechanic->name}}" disabled>
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label fs-6 fw-bold mt-2 mb-3">Repair Date</Label>
                        <input type="text" name="repair_date" id="repair_date" class="form-control"
                            value="{{$repair->date_repair}}" disabled>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <Label class="form-label fs-6 fw-bold mt-2 mb-3">Issue</Label>
                <textarea name="issue" id="issue" class="form-control" placeholder="Input vehicle issue"
                    disabled>{{$repair->issue}}</textarea>
            </div>

            <hr>

            <div class="mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Start Time</Label>
                        <input type="text" name="start_time" id="start_time" class="form-control" required value="{{$repair->start_time}}">
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">End Time</Label>
                        <input type="text" name="end_time" id="end_time" class="form-control" required value="{{$repair->end_time}}">
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <div class="row">
                    <div class="col-md-6">
                        <Label class="form-label fs-6 fw-bold mt-2 mb-3">Total Payment</Label>
                        <input type="text" name="total_payment" id="total_payment" class="form-control"
                            placeholder="Total Payment" disabled>
                        <input type="hidden" name="total" id="total" value="0">
                    </div>
                    <div class="col-md-6">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Payment Date</Label>
                        <input type="date" name="payment_date" id="payment_date" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="mb-5">
                <div class="row">
                    <div class="col-md-4">
                        <Label class="form-label fs-6 fw-bold mt-2 mb-3">Service Charge</Label>
                        <input type="text" name="service" id="service" class="form-control" disabled
                            value="Service charge per hour">
                    </div>
                    <div class="col-md-4">
                        <Label class="form-label fs-6 fw-bold mt-2 mb-3">Process Time (hour)</Label>
                        <input type="number" name="process" id="process" class="form-control" disabled>
                        <input type="hidden" name="process_time" id="process_time" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <Label class="form-label required fs-6 fw-bold mt-2 mb-3">Amount</Label>
                        <input type="text" name="service_amount" id="service_amount" class="form-control" placeholder="Input amount" required>
                    </div>
                </div>
            </div>

            <hr class="mt-10 mb-5">
            <div class="mb-5">
                <div id="repeater">
                    <div class="form-group">
                        <div data-repeater-list="repeater">
                            <div data-repeater-item>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <Label class="form-label fs-6 fw-bold mt-2 mb-3">Spare Part</Label>
                                        <select name="part_id" class="form-control part" data-kt-repeater="select2"
                                            data-placeholder="Select spare part">
                                            <option></option>
                                            @foreach ($parts as $item)
                                            <option value="{{$item->id}}">{{$item->name}} (Stock : {{$item->stock}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <Label class="form-label fs-6 fw-bold mt-2 mb-3">Quantity</Label>
                                        <input type="number" class="form-control quantity" name="quantity"
                                            placeholder="Input quantity">
                                    </div>
                                    <div class="col-md-4">
                                        <Label class="form-label fs-6 fw-bold mt-2 mb-3">Amount</Label>
                                        <input type="text" class="form-control amount" name="amount"
                                            placeholder="Input amount">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-8">
                                        <Label class="form-label fs-6 fw-bold mt-2 mb-3">Note</Label>
                                        <textarea name="note" class="form-control note"
                                            placeholder="Input note"></textarea>
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
                    <a href="{{route('repair.show', $repair->id)}}" id="cancelButton"
                        class="btn btn-light btn-active-light-primary me-3">Batalkan</a>
                    <button id="save-payment" type="submit" class="btn btn-active-primary btn-primary"
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
    const calculateTime = () =>{
        var start = $('#start_time').val();
        var end = $('#end_time').val();
        var start_time = new Date(start);
        var end_time = new Date(end);

        var time_difference = end_time.getTime() - start_time.getTime();
        var hours_difference = time_difference / (1000 * 60 * 60);
        $('#process_time').val(hours_difference);
        $('#process').val(hours_difference);
    }

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
        calculateTime();
    });

    $('#end_time').on('change', function(){
        calculateTime();
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
        $('#total').hide();
        var total_payment = formatRupiah($('#total_payment').val(), 'Rp ');
        $('#total_payment').val(total_payment);
        var service_amount = formatRupiah($('#service_amount').val(), 'Rp ');
        $('#service_amount').val(service_amount);
        calculateTime();
    });

    convertRupiah('service_amount');

    $('#repeater').repeater({
        initEmpty: false,

        show: function () {
            $(this).slideDown();
            priceFormat();
            // Re-init select2
            $(this).find('[data-kt-repeater="select2"]').select2();
            $('.amount').on('keyup', function(){
                priceFormat();
            });
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