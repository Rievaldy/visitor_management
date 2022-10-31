@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Purpose Device</h3>
    </div>
@endsection

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="flexbox flex-justified text-center mb-30 bg-primary">
                <div class="no-shrink py-30">
                    <span class="ti-tablet font-size-50"></span>
                </div>
                <div class="py-30 bg-white text-dark">
                    <div class="font-size-30">
                        <?php
                            $count = DB::table('m_device_purpose')->count();
                            echo $count;
                        ?>
                    </div>
                    <span>Puropose Device</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-6 text-left">
                            <h4 class="box-title">Purpose device List</h4>
                        </div>
                        <div class="col-6 text-right">
                            {{-- <a href="{{ route('toolAdd') }}" class="btn btn-bold btn-pure btn-info">Add</a> --}}
                            <a href="#" class="btn btn-bold btn-pure btn-info">Add New</a>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="flash-message"></div>
                    <div class="table-responsie">
                        <table id="dataTables" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-left w--25">Name</th>
                                    <th class="text-left w--50">Description</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
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
        $(document).ready(function(){
            var i = 1;
            $('#dataTables').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('getList')}}",
                columns: [
                    {
                        data: 'id',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'name' },
                    {
                        data: 'desc',
                        render: function (data, type, full, meta) {
                            let a=''
                            if(data!=null){
                                a=`<span>${data}</span>`
                            } else {
                                a=`<span>-</span>`
                            }
                            return a
                        }
                    },
                    {
                        data: 'status',
                        class : "text-center",
                        render: function (data, type, full, meta) {
                            let a=''
                            if(data==1){
                                a=`<span class="badge badge-success">Active</span>`
                            } else {
                                a=`<span class="badge badge-danger">Inactive</span>`
                            }
                            return a
                        }
                    },
                    {
                        orderable: false,
                        class : "text-center",
                        render: function (data, type, full, meta) {
                            let a=`
                                <a href="#" class="text-info mr-1"><span class="ti-eye"></span></a>
                                <a href="#" class="text-danger"><span class="ti-trash"></span></a>
                            `
                            return a
                        }
                    },
                ]
            });

            });
    </script>
@endsection
