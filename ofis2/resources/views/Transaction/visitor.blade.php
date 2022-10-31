@extends('master')

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Visitor</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="flexbox flex-justified text-center mb-30 bg-primary">
                <div class="no-shrink py-30">
                    <span class="ti-panel font-size-50"></span>
                </div>
                <div class="py-30 bg-white text-dark">
                    <div class="font-size-30">10</div>
                    <span>Total Visitor</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="flexbox flex-justified text-center mb-30 bg-danger">
                <div class="no-shrink py-30">
                    <span class="ti-link font-size-50"></span>
                </div>
                <div class="py-30 bg-white text-dark">
                    <div class="font-size-30">5</div>
                    <span>Active Visitor</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-12 text-left">
                            <h4 class="box-title">Visitor List</h4>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-striped dataTables">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-left text-nowrap">Date</th>
                                    <th class="text-left text-nowrap">Time</th>
                                    <th class="text-left text-nowrap">Visitor Name</th>
                                    <th class="text-left">Activity</th>
                                    <th class="text-left">PIC</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-left text-nowrap">24 Jun 2021</td>
                                    <td class="text-left text-nowrap">08:45 </td>
                                    <td class="text-left">Melina Valdemaras Eoghan</td>
                                    <td class="text-left">Meeting</td>
                                    <td class="text-left">Nikhil Kaden Rajesh</td>
                                    <td class="text-center text-success"><span class="btn btn-sm btn-success btn-block btn-rounded">Active</span></td>
                                    <td class="text-center">
                                        <span data-toggle="modal" data-target="#modal-fill">
                                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                                <i class="ti-eye"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td class="text-left text-nowrap">24 Jun 2021</td>
                                    <td class="text-left text-nowrap">08:46 </td>
                                    <td class="text-left">Vesna Ladislav Ansovald</td>
                                    <td class="text-left">Meeting</td>
                                    <td class="text-left">Nikhil Kaden Rajesh</td>
                                    <td class="text-center text-success"><span class="btn btn-sm btn-success btn-block btn-rounded">Active</span></td>
                                    <td class="text-center">
                                        <span data-toggle="modal" data-target="#modal-fill">
                                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                                <i class="ti-eye"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td class="text-left text-nowrap">24 Jun 2021</td>
                                    <td class="text-left text-nowrap">08:47 </td>
                                    <td class="text-left">Ömer Allie Candyce</td>
                                    <td class="text-left">Meeting</td>
                                    <td class="text-left">Nikhil Kaden Rajesh</td>
                                    <td class="text-center text-success"><span class="btn btn-sm btn-success btn-block btn-rounded">Active</span></td>
                                    <td class="text-center">
                                        <span data-toggle="modal" data-target="#modal-fill">
                                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                                <i class="ti-eye"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">4</td>
                                    <td class="text-left text-nowrap">24 Jun 2021</td>
                                    <td class="text-left text-nowrap">08:48 </td>
                                    <td class="text-left">Dagfinnr Kenshin Hoyt</td>
                                    <td class="text-left">Meeting</td>
                                    <td class="text-left">Nikhil Kaden Rajesh</td>
                                    <td class="text-center text-success"><span class="btn btn-sm btn-success btn-block btn-rounded">Active</span></td>
                                    <td class="text-center">
                                        <span data-toggle="modal" data-target="#modal-fill">
                                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                                <i class="ti-eye"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">5</td>
                                    <td class="text-left text-nowrap">24 Jun 2021</td>
                                    <td class="text-left text-nowrap">08:49 </td>
                                    <td class="text-left">Süheyla Polina Darina</td>
                                    <td class="text-left">Meeting</td>
                                    <td class="text-left">Nikhil Kaden Rajesh</td>
                                    <td class="text-center text-success"><span class="btn btn-sm btn-success btn-block btn-rounded">Active</span></td>
                                    <td class="text-center">
                                        <span data-toggle="modal" data-target="#modal-fill">
                                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                                <i class="ti-eye"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">6</td>
                                    <td class="text-left text-nowrap">24 Jun 2021</td>
                                    <td class="text-left text-nowrap">-</td>
                                    <td class="text-left">Alf Daniil Eadgyð</td>
                                    <td class="text-left">Meeting</td>
                                    <td class="text-left">Nilas Maqsud Koralia</td>
                                    <td class="text-center text-success"><span class="btn btn-sm btn-danger btn-block btn-rounded">Inactive</span></td>
                                    <td class="text-center">
                                        <span data-toggle="modal" data-target="#modal-fill">
                                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                                <i class="ti-eye"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">7</td>
                                    <td class="text-left text-nowrap">24 Jun 2021</td>
                                    <td class="text-left text-nowrap">-</td>
                                    <td class="text-left">Alf Daniil Eadgyð</td>
                                    <td class="text-left">Meeting</td>
                                    <td class="text-left">Nilas Maqsud Koralia</td>
                                    <td class="text-center text-success"><span class="btn btn-sm btn-danger btn-block btn-rounded">Inactive</span></td>
                                    <td class="text-center">
                                        <span data-toggle="modal" data-target="#modal-fill">
                                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                                <i class="ti-eye"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">8</td>
                                    <td class="text-left text-nowrap">24 Jun 2021</td>
                                    <td class="text-left text-nowrap">-</td>
                                    <td class="text-left">Ryō Anna Tatyanna</td>
                                    <td class="text-left">Meeting</td>
                                    <td class="text-left">Nilas Maqsud Koralia</td>
                                    <td class="text-center text-success"><span class="btn btn-sm btn-danger btn-block btn-rounded">Inactive</span></td>
                                    <td class="text-center">
                                        <span data-toggle="modal" data-target="#modal-fill">
                                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                                <i class="ti-eye"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">9</td>
                                    <td class="text-left text-nowrap">24 Jun 2021</td>
                                    <td class="text-left text-nowrap">-</td>
                                    <td class="text-left">Naoise Pradeep Doroteia</td>
                                    <td class="text-left">Meeting</td>
                                    <td class="text-left">Nilas Maqsud Koralia</td>
                                    <td class="text-center text-success"><span class="btn btn-sm btn-danger btn-block btn-rounded">Inactive</span></td>
                                    <td class="text-center">
                                        <span data-toggle="modal" data-target="#modal-fill">
                                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                                <i class="ti-eye"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">10</td>
                                    <td class="text-left text-nowrap">24 Jun 2021</td>
                                    <td class="text-left text-nowrap">-</td>
                                    <td class="text-left">Vaike Ragnhildr Aenor</td>
                                    <td class="text-left">Meeting</td>
                                    <td class="text-left">Nilas Maqsud Koralia</td>
                                    <td class="text-center text-success"><span class="btn btn-sm btn-danger btn-block btn-rounded">Inactive</span></td>
                                    <td class="text-center">
                                        <span data-toggle="modal" data-target="#modal-fill">
                                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="View">
                                                <i class="ti-eye"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal here --}}
    <div class="modal modal-fill fade" data-backdrop="false" id="modal-fill" tabindex="-1" style="z-index: 9999">
        <div class="modal-dialog modal-lg"">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title">Large Meeting Room	</h5> --}}
                    <button type="button" class="close" style="padding-right: 28px" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box">
                                <div class="box-header">
                                    <h4 class="box-title">View Facility</h4>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Facility Code</label>
                                        <input type="text" class="form-control" value="INF190281D" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Facility Name</label>
                                        <input type="text" class="form-control" value="Infocus" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <input type="text" class="form-control" value="Office Equipment" placeholder="" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea rows="4" cols="4" class="form-control" placeholder="" readonly>Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci.</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Facility Status</label>
                                        <input type="text" class="form-control" value="Active" placeholder="" readonly>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-3">
                                            <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                                        </div>
                                        <div class="col-3">
                                            <a href="{{ url('/facilities/edit') }}" class="btn btn-bold btn-pure btn-info float-right btn-block">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

