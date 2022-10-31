<form action="{{ url('project-approved/update-visitor-form/'.$id_project.'/'.$id_project_location) }}" method="post">
    @csrf
    <div class="row">
        <!-- Left Column -->
        <div class="col-sm-12 col-md-6">

            <!-- Company's name field -->
            <div class="form-group">
                <label for="project-name">Project's Name</label>
                <input name="project_name" class="form-control" type="text" placeholder="Please input your project's name" value="{{ $project->name }}" readonly required>
            </div>

            <!-- Company's name field -->
            <div class="form-group">
                <label for="company-name">Company's Name</label>
                <input type="hidden" name="id_company" class="form-control" type="number" placeholder="Please input your project's name" value="{{ $project->id_company }}" readonly >
                <input name="company_name" class="form-control" type="text" placeholder="" value="{{ $project->company_name }}" readonly required>
                {{-- <select id="company-name" class="form-control" name="company_name">
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select> --}}
            </div>

            <!-- Company's address field -->
            <div class="form-group">
                <label for="company-address">Company's Address</label>
                <textarea class="form-control" name="company_address" id="company-address" rows="10"
                    placeholder="Please input your company's address"></textarea>
            </div>

            <!-- Company's phone number field -->
            <div class="form-group">
                <label for="company-phone">Company's Phone Number</label>
                <input id="company-phone" name="company_phone" class="form-control" type="text" placeholder="+6281280889099" required>
            </div>

            <!-- Leader name field -->
            <div class="form-group">
                <label for="leader-name">Leader's Name</label>
                <input type="hidden" id="leader-id" name="leader_id" class="form-control" type="text" placeholder="Please input your leader name" required>
                <input id="leader-name" name="leader_name" class="form-control" type="text" placeholder="Please input your leader name" required>
            </div>
            <!-- KTP field -->
            <div class="form-group">
                <label for="identity-card-number">Leader's Identity Card Number (KTP)</label>
                <input id="identity-card-number" name="identity_card_number" class="form-control" type="text" placeholder="Please input your KTP number" required>
            </div>

            <!-- Email field -->
            <div class="form-group">
                <label for="leader-email">Leader's Email</label>
                <input id="leader-email" name="leader_email" class="form-control" type="email" placeholder="Please input your email" required>
            </div>
        </div>
        <!-- End of Left Column -->

        <!-- Right Column -->
        <div class="col-sm-12 col-md-6">
            <!-- Members field -->
            <div class="form-group">
                <fieldset id="members-fieldset" class="y-field">
                    <p class="d-flex align-items-center justify-content-between">
                        <label>Members</label>
                        <button type="button" class="btn btn-primary y-add-field"><i class="fas fa-plus"></i> Add member</button>
                    </p>
                    <div class="y-form-group form-group d-flex align-items-center">
                        <input type="hidden" class="form-control mx-auto idMember" type="number" name="members_id[]" data-placeholder="Member's id " placeholder="Member's id" required>
                        <input class="form-control mx-auto nameMember" type="text" name="members_name[]" data-placeholder="Member's Name " placeholder="Member's Name" required>
                        <input class="form-control mx-auto ktpMember" type="text" name="members_ktp[]" data-placeholder="Member's ktp number " placeholder="Member's ktp number" required>
                        <input class="form-control mx-auto emailMember" type="text" name="members_email[]" data-placeholder="Member's Email " placeholder="Member's Email" required>
                        <i class="cursor-pointer px-2 fas fa-times y-remove-field"></i>
                    </div>
                    {{-- <div class="y-form-group form-group d-flex align-items-center">
                        <input hidden class="form-control mx-auto idMember" type="number" name="members_id[]" data-placeholder="Member's id " placeholder="Member's id" required>
                        <input class="form-control mx-auto nameMember" type="text" name="members_name[]" data-placeholder="Member's Name " placeholder="Member's Name" required>
                        <input class="form-control mx-auto ktpMember" type="text" name="members_ktp[]" data-placeholder="Member's ktp number " placeholder="Member's ktp number" required>
                        <input class="form-control mx-auto emailMember" type="text" name="members_email[]" data-placeholder="Member's Email " placeholder="Member's Email" required>
                        <i class="cursor-pointer px-2 fas fa-times y-remove-field"></i>
                    </div> --}}
                </fieldset>
            </div>

            <!-- YKK Employees to meet field -->
            <div class="form-group " {{$project->type == 2 ? 'hidden' : ''}} >
                <fieldset id="employees-fieldset" class="y-field">
                    <p class="d-flex align-items-center justify-content-between">
                        <label>YKK Employees to meet</label>
                        <button type="button" class="btn btn-primary y-add-field"><i class="fas fa-plus"></i> Add employee</button>
                    </p>
                    <div class="y-form-group form-group d-flex align-items-center">
                        <input class="form-control mx-1" type="text" name="employee_name[]" data-placeholder="Employee's name " placeholder="Employee's name" required>
                        <input class="form-control mx-1" type="text" name="employee_dept[]" data-placeholder="Employee's dept " placeholder="Employee's dept" required>
                        <i class="cursor-pointer px-2 fas fa-times y-remove-field"></i>
                    </div>
                    <div class="y-form-group form-group d-flex align-items-center">
                        <input class="form-control mx-1" type="text" name="employee_name[]" data-placeholder="Employee's name " placeholder="Employee's name" required>
                        <input class="form-control mx-1" type="text" name="employee_dept[]" data-placeholder="Employee's dept " placeholder="Employee's dept" required>
                        <i class="cursor-pointer px-2 fas fa-times y-remove-field"></i>
                    </div>
                </fieldset>
            </div>

            <!-- Visitor type field -->
            <div class="form-group">
                <label>Visitor Type</label>
                <select id="visitor-type" class="form-control" name="visitor_type">
                    @foreach ($visitor_types as $visitor_type)
                        <option value="{{ $visitor_type->id }}">{{ $visitor_type->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Supplier field -->
            <div id="form-group-supplier-type" class="form-group">
                <label>Supplier Type</label>
                <select id="supplier-type" class="form-control" name="supplier_type">
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Visit purpose field -->
            <div class="form-group" {{$project->type == 2 ? 'hidden' : ''}}>
                <label>Visit purpose</label>
                <select id="visit-purpose" class="form-control" name="visit_purpose">
                    @foreach ($purposes as $purpose)
                        <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Visit time field -->
            <div class="form-group" {{$project->type != 2 ? 'hidden' : ''}}>
                <label>Project Date</label>
                <input id="project_date" class="form-control ykk-daterangepicker" type="text" name="project_date" readonly value="{{$projectLocation->date_start.' Until '.$projectLocation->date_end}}"/>
            </div>

            <div class="form-group">
                <label for="project-detail">Project's Detail</label>
                <input name="project_detail" class="form-control" type="text" placeholder="Please input your project's detail" value="" required>
            </div>

            <!-- Visit time field -->
            @if ($project->type != 1)
                <div class="form-group"{{$project->type == 2 ? 'hidden' : ''}}>
                    <label>Visit Date</label>
                    <input type="text" class="form-control" value="{{ date('M d, Y', strtotime($projectLocation->date_start)) }}" readonly>
                </div>
                <div class="form-group"{{$project->type == 2 ? 'hidden' : ''}}>
                    <label>Visit time</label>
                    {{-- <input id="visit-time" class="form-control ykk-daterangepicker" type="text" name="visit_time" readonly /> --}}
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" value="{{ date('H:i', strtotime($projectLocation->time_start)) }}" readonly>
                        </div>
                        <div class="col-auto d-flex align-items-center justify-content-center">-</div>
                        <div class="col">
                            <input type="text" class="form-control" value="{{ date('H:i', strtotime($projectLocation->time_end)) }}" readonly>
                        </div>
                    </div>
                </div>
            @endif
            @if ($project->type == 1)
                <div class="form-group">
                    <label>Visit Date</label>
                    <div class="d-flex align-item-center">
                        <div class="w--100 d-flex">
                            <input type="date" class="form-control" name="date_start" value="" min="{{ date('Y-m-d', strtotime(\Carbon\Carbon::now()->addDays(7))) }}">
                        </div>
                        <div class="col-auto d-flex align-items-center justify-content-center">-</div>
                        <div class="w--100 d-flex">
                            <input type="date" class="form-control" name="date_end" value="" min="{{ date('Y-m-d', strtotime(\Carbon\Carbon::now()->addDays(7))) }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Visit time</label>
                    <div class="d-flex align-item-center">
                        <div class="w--100 input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                            <input name="time_start" type="text" class="form-control" placeholder="hh:mm" value="">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                        <div class="col-auto d-flex align-items-center justify-content-center">-</div>
                        <div class="w--100 input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
                            <input name="time_end" type="text" class="form-control" placeholder="hh:mm" value="">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-time"></span>
                            </span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <!-- End of Right Column -->
    </div>

    <div class="box {{$project->type != 2 ? 'd-none' : ''}}">
        <div class="box-header">
            <h4 class="box-title">Detail Activity</h4>
        </div>
        <div class="box-body">
            <div class="">
                <div>
                    <div class="row">
                        <div class="col-1 text-center align-self-center">
                            <label class="font-weight-bold">Site</label>
                        </div>
                        <div class="col-1 text-center align-self-center">
                            <label class="font-weight-bold">Location</label>
                        </div>
                        <div class="col-1 text-center align-self-center">
                            <label class="font-weight-bold">Area</label>
                        </div>
                        <div class="col-1 text-center align-self-center">
                            <label class="font-weight-bold">Working</label>
                        </div>
                        <div class="col-1 text-center align-self-center">
                            <label class="font-weight-bold">Date Start</label>
                        </div>
                        <div class="col-1 text-center align-self-center">
                            <label class="font-weight-bold">Date End</label>
                        </div>
                        <div class="col-1 text-center align-self-center">
                            <label class="font-weight-bold">Time Start</label>
                        </div>
                        <div class="col-1 text-center align-self-center">
                            <label class="font-weight-bold">Time End</label>
                        </div>
                        <div class="col-1 text-center align-self-center">
                            <label class="font-weight-bold">Safety Management Level</label>
                        </div>
                        <div class="col-1 text-center align-self-center">
                            <label class="font-weight-bold">High Risk Category</label>
                        </div>
                        <div class="col-1 text-center align-self-center">
                            <label class="font-weight-bold">NDA</label>
                        </div>
                        <div class="col-1 text-center">
                            <button id="add-detail-activity" type="button" class="btn btn-primary "><i class="fas fa-plus"></i> Add </button>
                        </div>
                    </div>
                </div>
                <fieldset id="activity-fieldset">
                </fieldset>
            </div>
        </div>
    </div>
    <br>
    <div class="form-group">
        <button class="btn btn-success" type="submit">Submit</button>
    </div>
</form>

{{-- MODAL HERE --}}
<div class="modal fade" data-backdrop="false" id="modal-add-activity" style="z-index: 9999">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Activity	</h5>
            </div>
            <div class="modal-body">
                <form action="" method="GET" >
                    <div class="form-group" >
                        <label>Site Name</label>
                        <select name="id_site" class="form-control select2"  data-tags="true">
                            <option value="none" selected readonly>Select Site</option>
                        </select>
                    </div>
                    <div class="form-group" >
                        <label>Location Name</label>
                        <select name="id_location" class="form-control select2"  data-tags="true">
                            <option value="none" selected readonly>Select Location</option>
                        </select>
                    </div>
                    <div class="form-group" >
                        <label>Area Name</label>
                        <select name="id_area" class="form-control select2"  data-tags="true">
                            <option value="none" selected readonly>Select Area</option>
                        </select>
                    </div>
                    <div class="form-group" >
                        <label>Working Category</label>
                        <select name="work_category" class="form-control select2"  data-tags="true">
                            <option value="none" readonly selected>Working Category</option>
                            <option value="1" >Yes</option>
                            <option value="0" >No</option>
                        </select>
                    </div>
                    <div  id="date_template_double" class="form-group">
                        <label>Date</label>
                        <div class="row align-items-center">
                            <div class="col-sm-5 col-5">
                                <input id="calendar" name="date_start" type="date" class="form-control form-control-sm" name="date_meet" value="{{ date('Y-m-d')}}">
                            </div>
                            <div class="col-sm-2 col-2 align-center">
                                <p class="mb-0">Until</p>
                            </div>
                            <div class="col-sm-5 col-5">
                                <input id="calendar" name="date_end" type="date" class="form-control form-control-sm" name="date_meet" value="{{ date('Y-m-d')}}">
                            </div>
                        </div>
                    </div>

                    <div id="time_template" class="form-group">
                        <label>Meeting time</label>
                        <div class="row align-items-center">
                            <div class="col-sm-5 col-5">
                                <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                    <input name="time_start" type="text" class="form-control" value="{{ date('H:i')}}">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-2 col-2 align-center">
                                <p class="mb-0">Until</p>
                            </div>
                            <div class="col-sm-5 col-5">
                                <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                    <input name="time_end" type="text" class="form-control" value="{{ date('H:i')}}">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div hidden class="form_group">
                        <input class="form-control " name="risk_level" type="number" value=""/>
                        <input class="form-control " name="risk_level_desc" type="text" readonly value=""/>
                    </div>
                    <div hidden id="high-risk" class="form-group" >
                        <label>High Risk Category</label>
                        <select  name="high_risk_category" class="form-control select2"  data-tags="true">
                            <option value="none" selected readonly>Select Area</option>
                        </select>
                    </div>
                    <div hidden class="form_group">
                        <input class="form-control " name="is_need_nda" type="number" value=""/>
                        <input class="form-control " name="is_need_nda_desc" type="text" readonly value=""/>
                    </div>

                    <div class="box-footer">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-bold btn-pure btn-secondary btn-block" data-dismiss="modal">Close</button>
                            </div>
                            <div class="col-6">
                                <button id="submit-activity" type="submit" class="btn btn-bold btn-pure btn-info float-right btn-block">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@section('script2')
    <script>
        /**
         * ajax fill company detail
         */
        const fillVisitorDetail = (id) =>{
            $.ajax({
                url: `{{ url('visitor/${id}') }}`,
                type: 'get',
                dataType: "json",
                success: function(data) {
                    $('#identity-card-number').val(data.ktp)
                    $('#leader-email').val(data.email)
                }
            });
        }
        const fillVisitorDetailMember = (id,index) =>{
            $.ajax({
                url: `{{ url('visitor/${id}') }}`,
                type: 'get',
                dataType: "json",
                success: function(data) {
                    $('#id_hidden_member_'+index).val(data.id)
                    $('#name_member_'+index).val(data.name)
                    $('#ktp_member_'+index).val(data.ktp)
                }
            });
        }

        const fillCompanyDetail = (id) =>{
            $.ajax({
                url: `{{ url('company/${id}') }}`,
                type: 'get',
                dataType: "json",
                success: function(data) {
                    $('#company-address').val(data.address)
                    $('#company-phone').val(data.phone)
                }
            });
        }

        const loadVisitorLeader = (id) =>{
            $.ajax({
                url: "{{route('getVisitorSelect2')}}",
                type: 'get',
                dataType: "json",
                data: {
                    id_company: id,
                },
                success: function (datas) {
                    var data = datas;
                    $('select[name=leader_id]').select2({data: data});
                },
            });
        }

        const loadVisitorMember = (id) =>{
            return $.ajax({
                url: "{{route('getVisitorSelect2')}}",
                type: 'get',
                dataType: "json",
                data: {
                    id_company: id,
                }//,
                // success: function (datas) {
                //     console.log("lalala");
                //     var data = datas;
                //     $('select[name=member_id]').select2({data: data});
                // },
            });
        }

        /**
         * ajax fill leader & members detail
         */
        const fillMembersDetail = (id) => {
            $.ajax({
                url: `{{ url('visitor-project/show-by-id-project/${id}') }}`,
                type: 'get',
                dataType: "json",
                success: function(data) {
                    const leader = data.find((val) => Number(val?.visitor_level) === 1);
                    const members = data.filter((val) => Number(val?.visitor_level) !== 1);
                    $("#leader-id").val(leader?.visitor_id)
                    $('#leader-name').val(leader?.visitor_name)
                    $('#leader-email').val(leader?.visitor_email)
                    $('#identity-card-number').val(leader?.visitor_ktp)

                    let html = ``;
                    let no = 1;
                    members.map((value) => {
                        html += `
                            <div class="y-form-group form-group d-flex align-items-center">
                                <input hidden class="form-control mx-auto idMember" type="number" name="members_id[]" data-placeholder="Member's id " placeholder="Member's id" value="${value.visitor_id}" required>
                                <input class="form-control mx-auto nameMember" type="text" name="members_name[]" data-placeholder="Member's Name " placeholder="Member's Name" ${value.visitor_name} required>
                                <input class="form-control mx-auto ktpMember" type="text" name="members_ktp[]" data-placeholder="Member's ktp number " placeholder="Member's ktp number" ${value.visitor_ktp} required>
                                <input class="form-control mx-auto emailMember" type="text" name="members_email[]" data-placeholder="Member's Email " placeholder="Member's Email" ${value.visitor_email} required>
                            </div>`;
                        no++;
                    })
                    if (members.length) {
                        no = 1;
                        $('#members-fieldset .y-form-group').remove();
                        $('#members-fieldset').append(html)
                        $('.memberSelect2').select2()
                    }
                }
            });
        }


        /**
         * ajax fill employee detail
         */
        const fillEmployeesDetail = (id) => {

            $.ajax({
                url: `{{ url('employee-project/show-by-id-project/${id}') }}`,
                type: 'get',
                dataType: "json",
                success: function(data) {
                    let html = ``;
                    data.map((value) => {
                        html += `
                        <div class="y-form-group form-group d-flex align-items-center">
                            <input class="form-control mx-1" type="text" name="employee_name[]" data-placeholder="Employee's name " placeholder="Employee's name" value="${value?.employee_name}">
                            <input class="form-control mx-1" type="text" name="employee_dept[]" data-placeholder="Employee's dept " placeholder="Employee's dept">
                            <i class="cursor-pointer px-2 fas fa-times y-remove-field"></i>
                        </div>`;
                    })
                    if (data.length) {
                        $('#employees-fieldset .y-form-group').remove();
                        $('#employees-fieldset').append(html)
                    }

                }
            });
        }


        /**
         * select2 init
         */
        $(document).ready(function() {
            $('#company-name').select2({
                tags: true,
            })
            loadVisitorLeader($('input[name=id_company]').val())
            fillCompanyDetail($('input[name=id_company]').val())
            fillMembersDetail({{ $id_project }})
            fillEmployeesDetail({{ $id_project }})
            loadVisitorMember($('input[name=id_company]').val()).then(function(data){
                $('select[name=member_select]').select2({data: data});
            })

            $.ajax({
                url: "{{route('getsitesSelect2')}}",
                type: 'get',
                dataType: "json",
                success: function (datas) {
                    var data = datas
                    $('select[name=id_site]').select2({data: data}).trigger('change')
                }
            });
        })

        $('select[name=member_select]').on('change',function() {
            let id = this.value
            let index = this.id.match(/\d/)
            console.log('running');
            fillVisitorDetailMember(id,index)
        });

        // $('select[name=leader_id]').on('change',function(){
        //     let val = $('select[name=leader_id]').find(':selected').val();
        //     $('#leader-name').val(val)
        //     fillVisitorDetail(val);
        // })


        /**
         * Form Visitor
         */

        $('#form-group-supplier-type').hide()
        $('#visitor-type').change(function(e) {
            if ($(this).val() == 8) {
                $('#form-group-supplier-type').show()
            } else {
                $('#form-group-supplier-type').hide()
            }
        })

        $('select[name=id_site]').on('change',function(){
            {
                $.ajax({
                    url:"{{route('getLocationSelect2')}}",
                    type: 'get',
                    dataType: "json",
                    data:{
                        id:this.value
                    },
                    success: function(datas) {
                        var data = datas
                        // console.log(datas);
                        $('select[name=id_location]').empty();
                        $('select[name=id_area]').empty();
                        $('select[name=id_location]').select2({data: data}).trigger('change')
                    }
                });
            }
        });
        $('select[name=id_location]').on('change',function(){
            {
                $.ajax({
                    url:"{{route('getAreaSelect2')}}",
                    type: 'get',
                    dataType: "json",
                    data:{
                        id:this.value
                    },
                    success: function(datas) {
                        var data = datas
                        $('select[name=id_area]').empty();
                        $('select[name=id_area]').select2({data: data}).trigger('change')
                    },
                });
                id_location = this.value;
                console.log(id_location);
                $.ajax({
                    url:`{{ url('locations-get/${id_location}') }}`,
                    type: 'get',
                    dataType: "json",
                    success: function(datas) {
                        var data = datas
                        $("#is_need_nda").val(data.is_need_nda.is_need_nda);
                    },
                });
            }
        });

        $('select[name=work_category]').on('change',function() {
            id_area = $('select[name=id_area]').val()
            working_value = this.value;
            if(id_area != null){
                $.ajax({
                    url:`{{ url('areas-get/${id_area}') }}`,
                    type: 'get',
                    dataType: "json",
                    success: function(datas) {
                        var data = datas
                        console.log(data);
                        if(working_value == 0){
                            $("input[name=risk_level]").val(data.risk_not_work.risk_not_work);
                            $("input[name=risk_level_desc]").val(data.risk_not_work.display);
                            $("#high-risk").attr("hidden",true);
                            $('select[name=id_location]').empty();
                        }else{
                            $("input[name=risk_level]").val(data.risk_work.risk_work);
                            $("input[name=risk_level_desc]").val(data.risk_work.display);
                            if(data.risk_work.risk_work == 3){
                                $.ajax({
                                    url:"{{route('getHighRiskSelect2')}}",
                                    type: 'get',
                                    dataType: "json",
                                    data:{
                                        id:this.value
                                    },
                                    success: function(datas) {
                                        var data = datas
                                        console.log(datas);
                                        $("#high-risk").attr("hidden",false);
                                        $('select[name=high_risk_category]').select2({data: data},{
                                            width: '100%'
                                        }).trigger('change')

                                    }
                                });

                            }else{
                                $("#high-risk").attr("hidden",true);
                                $('select[name=id_location]').empty();
                            }
                        }
                    },
                });
            }
        });

        $('.clockpicker').clockpicker()
            .find('input').change(function(){
            // TODO: time changed
        });

        let idl = $('input[name="id_company"]').val();
        console.log('idCom'+idl);
        if(idl != ''){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(document).on('keydown.autocomplete', '#leader-name', function() {
                id_company = $("input[name='id_company']").val();
                $( this ).autocomplete({
                    source: function( request, response ) {
                        console.log(request.term)
                        $.ajax({
                            url:"{{route('visitorAutoComplete')}}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                cari: request.term,
                                id_company: id_company
                            },
                            success: function( data ) {
                                //console.log(data)
                                response( data );
                            }
                        });
                    },
                    select: (event, ui) => {
                        $('#leader-id').val(ui.item.id);
                        $('#leader-name').val(ui.item.name);
                        $('#identity-card-number').val(ui.item.ktp);
                        $('#leader-email').val(ui.item.email);
                        return false;
                    }
                });
            });

            $(document).on('keydown.autocomplete', '.nameMember', function() {
                id_company = $("input[name='id_company']").val();
                var parent  = $(this).closest('.form-group');
                $( this ).autocomplete({
                    source: function( request, response ) {
                        console.log(request.term)
                        $.ajax({
                            url:"{{route('visitorAutoComplete')}}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                cari: request.term,
                                id_company: id_company
                            },
                            success: function( data ) {
                                //console.log(data)
                                response( data );
                            }
                        });
                    },
                    select: (event, ui) => {
                        console.log(ui);
                        parent.find('.idMember').val(ui.item.id);
                        parent.find('.nameMember').val(ui.item.name);
                        parent.find('.ktpMember').val(ui.item.ktp);
                        parent.find('.emailMember').val(ui.item.email);
                        return false;
                    }
                });
            });
        }

        $('#add-detail-activity').on('click',function(){
            $('#modal-add-activity select').select2({
                width: '100%'
            });
            $('#modal-add-activity').modal('show');
        })

        $('#submit-activity').on('click',function(e){
            e.preventDefault();
            id_site = $('select[name=id_site]').find(':selected').val()
            name_site = $('select[name=id_site]').find(':selected').text()
            id_location = $('select[name=id_location]').find(':selected').val()
            name_location = $('select[name=id_location]').find(':selected').text()
            id_area = $('select[name=id_area]').find(':selected').val()
            name_area = $('select[name=id_area]').find(':selected').text()
            id_work_category = $('select[name=work_category]').find(':selected').val()
            name_work_category = $('select[name=work_category]').find(':selected').text()
            id_high_risk_category = $('select[name=high_risk_category]').find(':selected').val()
            name_high_risk_category = $('select[name=high_risk_category]').find(':selected').text()
            date_start = $('input[name=date_start]').val();
            date_end = $('input[name=date_end]').val();
            time_start = $('input[name=time_start]').val();
            time_end = $('input[name=time_end]').val();
            risk_level = $('input[name=risk_level]').val();
            risk_level_desc = $('input[name=risk_level_desc]').val();
            is_need_nda = $('input[name=is_need_nda]').val();

            console.log(risk_level);
            console.log(risk_level_desc);

            html = `<div class="form-group z-row" >
                        <div class="row">
                            <div class="col-1">
                                <input hidden class="form-control site_view" name="id_site[]" type="text" readonly value="${id_site}"/>
                                <label class="font-weight-normal text-center align-self-center">${name_site}</label>
                            </div>
                            <div class="col-1">
                                <input hidden class="form-control location_view" name="id_location[]" type="text" readonly value="${id_location}"/>
                                <label class="font-weight-normal text-center align-self-center">${name_location}</label>
                            </div>
                            <div class="col-1">
                                <input hidden class="form-control area_view" name="id_area[]" type="text" readonly value="${id_area}"/>
                                <label class="font-weight-normal text-center align-self-center">${name_area}</label>
                            </div>
                            <div class="col-1 text-center">
                                <input hidden class="form-control is_working_view" name="is_working[]" type="text" readonly value="${id_work_category}"/>
                                <label class="font-weight-normal text-center align-self-center">${name_work_category}</label>
                            </div>
                            <div class="col-1 text-center">
                                <input  hidden class="form-control date_start_view" name="date_start[]" type="text" readonly value="${date_start}"/>
                                <label class="font-weight-normal text-center align-self-center">${date_start}</label>
                            </div>
                            <div class="col-1 text-center">
                                <input hidden hidden class="form-control date_end_view" name="date_end[]" type="text" readonly value="${date_end}"/>
                                <label class="font-weight-normal text-center align-self-center">${date_end}</label>
                            </div>
                            <div class="col-1  text-center">
                                <input hidden class="form-control time_start_view" name="time_start[]" type="text" readonly value="${time_start}"/>
                                <label class="font-weight-normal text-center align-self-center">${time_start}</label>
                            </div>

                            <div class="col-1  text-center">
                                <input hidden class="form-control time_end_view" name="time_end[]" type="text" readonly value="${time_end}"/>
                                <label class="font-weight-normal text-center align-self-center">${time_end}</label>
                            </div>
                            <div class="col-1  text-center">
                                <input hidden class="form-control risk_level_view_id" name="risk_level[]" type="text"  readonly value="${risk_level}"/>
                                <label class="font-weight-normal text-center align-self-center"> ${risk_level_desc}</label>
                            </div>
                            <div class="col-1  text-center">
                                <input hidden class="form-control risk_category_view_id" name="risk_category[]" type="text" readonly value="${id_high_risk_category}"/>
                                <label class="font-weight-normal text-center align-self-center">${id_high_risk_category == 'none' ? '-':name_high_risk_category}</label>
                            </div>
                            <div class="col-1  text-center">
                                <input hidden class="form-control nda_view_id" type="text" name="is_need_nda[]" readonly value="${is_need_nda}"/>
                                <label class="font-weight-normal text-center align-self-center">${is_need_nda == 1 ? 'YES' : 'NO'}</label>
                            </div>
                            <div class="col-1  text-center">
                                <i class="cursor-pointer px-2 fas fa-times z-remove-field"></i>
                            </div>
                        </div>
                    </div>`
            const fieldset = $('#activity-fieldset');
            fieldset.append(html)
        });




    </script>
@endsection
