@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">GA & Security</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">

                            <h4 class="box-title">List Visitor</h4>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="mb-4">
                        <div class="form-inline">
                            <div class="form-group">
                                <input type="date" class="form-control form-control-sm" name="t0" id="t0" value="{{ date('Y-m-d')}}">
                            </div>
                            <div class="form-group">
                                To
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control form-control-sm" name="t1" id="t1" value="{{ date('Y-m-d')}}">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="dataTable">
                            <thead>
                                <tr class="">
                                    <th class="">#</th>
                                    <th class="text-wrap">Date From</th>
                                    <th class="text-wrap">Time</th>
                                    <th class="text-wrap">Visitor Type</th>
                                    <th class="text-wrap">Visitor ID</th>
                                    <th class="text-wrap">Purpose</th>
                                    <th class="text-wrap">Status</th>
                                    <th class="text-wrap text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        $('#dataTable').DataTable({
            ajax: {
                url: "{{ route('ga.getList') }}",
                dataSrc: '',
                data: function(d){
                    d.t0= moment($('#t0').val()).format("YYYY-MM-DD"),
                    d.t1= moment($('#t1').val()).format("YYYY-MM-DD")
                },
                fnRowCallback: function (nRow, aData, iDisplayIndex) {
                    var info = $(this).DataTable().page.info();
                    $("td:nth-child(1)", nRow).html(info.start + iDisplayIndex + 1);
                    return nRow;
                },
            },
            columns: [
                {
                    data: 'id',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        let a=`
                            ${moment(row.date_start).format('MMM DD, Y')} - ${moment(row.date_end).format('MMM DD, Y')}
                        `
                        return a
                    }
                },
                {
                    render: function (data, type, row, meta) {
                        let a=`
                            ${moment(row.time_start).format('HH:mm')} - ${moment(row.time_end).format('HH:mm')}
                        `
                        return a
                    }
                },
                {
                    data: 'type',
                    render: function (data, type, row, meta) {
                        console.log(row)
                        if(row.type == 1){
                            return 'Normal Visitor'
                        } else if (row.type == 2){
                            return 'Vendor/Contractor'
                        } else if (row.type == 3) {
                            return 'Special Visitor'
                        } else {
                            return '-'
                        }
                    }
                },
                {
                    data: 'id_company',
                    render: function (data, type, row, meta) {
                        // console.log(row)
                        let x = ('0000' + data).slice(-4);
                        if (row.type.type == 1){
                            let a = `VSN${x}`
                            return a;
                        } else {
                            let a = `VS${x}`
                            return a;
                        }
                    },
                },
                {
                    data: 'purpose',
                },
                {
                    data: 'status',
                    render: function (data, type, row, meta) {
                        console.log(row)
                        if(row.status == 1){
                            return 'Fill Visitor Form'
                        } else if (row.status == 2){
                            return 'Fill NDA form,'
                        } else if (row.status == 3) {
                            return 'Waiting NDA Approval'
                        } else if (row.status == 4) {
                            return 'Waiting Factory Director Approval'
                        } else if (row.status == 5) {
                            return 'Waiting Safety Approval'
                        } else if (row.status == 6) {
                            return 'Approved'
                        }
                    }
                },
                {
                    orderable: false,
                    class : "text-center",
                    render: function (data, type, row, meta) {
                        let a=`
                            <a href="{{ url('ga-security/visitor-detail/${row.id}') }}" class="text-info mr-1"><span class="ti-eye"></span></a>
                        `
                        return a
                    }
                },
            ],
        })

        $('#t0,#t1').change(function() {
            $('#dataTable').DataTable().ajax.reload();
        })
    </script>
@endsection
