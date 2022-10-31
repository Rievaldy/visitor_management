@extends('form_visitor')

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href='{{ asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css') }}' rel='stylesheet' />
    <link rel="stylesheet" href={{ asset('vendor/kukrik/bootstrap-clockpicker/assets/css/bootstrap-clockpicker.min.css') }}>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
@endsection

@section('breadcrumb')
    <div class="mr-auto w-p50">
        <h3 class="page-title border-0">Project Approved</h3>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="box1">
                <div class="card px-0 pt-4 pb-0 mt-3 mb-0">
                    <div class="row">
                        <div class="col-md-12 mx-0">
                            <form id="msform">
                                <ul class="oprogressbar">
                                    <li class="active" id="visitor-form"><strong>Fill Visitor Form</strong></li>
                                    @if ($is_need_nda)
                                        <li class="{{ $project_approved_status > 1 ? 'active' : '' }}" id="nda-form">
                                            <strong>Fill NDA Form</strong></li>
                                    @endif
                                    @if ($is_need_nda)
                                        <li class="{{ $project_approved_status > 2 ? 'active' : '' }}" id="nda-approval">
                                            <strong>Waiting for NDA Approval</strong></li>
                                    @endif
                                    <li class="{{ $project_approved_status > 3 ? 'active' : '' }}" id="director-approval">
                                        <strong>Waiting for Factory Director Approval</strong></li>
                                    <li class="{{ $project_approved_status > 4 ? 'active' : '' }}" id="approved">
                                        <strong>Yeay!, you have been approved</strong></li>
                                </ul>
                            </form>
                        </div>
                    </div>
                    <div class="container m-5 m-auto">
                        @if ($project_approved_status === 1)
                            <!-- Visitor Form -->
                            @include('ProjectApproved.index-visitor_form')
                            <!-- End of Visitor Form -->
                        @endif

                        @if ($project_approved_status === 2)
                            <!-- NDA Form -->
                            @include('ProjectApproved.index-nda_form')
                            <!-- End of NDA Form -->
                        @endif

                        @if ($project_approved_status === 3)
                            <!-- NDA Approval -->
                            @include('ProjectApproved.index-approval', [
                                'text' => 'Submit successfully, your application was sent to NDA, We will look into this and get back to you soon via email.',
                                'img' => 'img/undraw_people_search.svg',
                            ])
                            <!-- End of NDA Approval -->
                        @endif

                        @if ($project_approved_status === 4)
                            <!-- Director Approval -->
                            @include('ProjectApproved.index-approval', [
                                'text' => 'Submit successfully, your application was sent to Factory Director, We will look into this and get back to you soon via email.',
                                'img' => 'img/undraw_people_search.svg',
                            ])
                            <!-- End of Director Approval -->
                        @endif

                        @if ($project_approved_status === 5)
                            <!-- Approval -->
                            @include('ProjectApproved.index-approval', [
                                'text' => 'Your request has been approved! Now you can visit YKK',
                                'img' => 'img/undraw_checklist.svg',
                            ])
                            <!-- End of Approval -->
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script  src="{{ asset('vendor/kukrik/bootstrap-clockpicker/assets/js/bootstrap-clockpicker.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
    <script>
        /**
         * Visit time & datepicker configuration
         */
        $('#visit-time.ykk-daterangepicker').daterangepicker({
            timePicker: true,
            opens: 'left',
            startDate: moment().format("YYYY/MM/DD hh:mm A"),
            endDate: moment().add(1, 'months').format("YYYY/MM/DD hh:mm A"),
            locale: {
                format: 'YYYY/MM/DD hh:mm A'
            }
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD hh:mm A') + ' to ' + end
                .format('YYYY-MM-DD hh:mm A'));
        });


        /**
         * Add & Remove fields
         */
        $('.y-add-field').click(function(e) {
            e.preventDefault();
            const fieldset = this.parentNode.parentNode;
            const lastFormGroup = fieldset.querySelector('.y-form-group:last-child');
            console.log(lastFormGroup.data?.no);
            const lastNo = lastFormGroup.dataset?.no;
            const formGroup = lastFormGroup.cloneNode(true)
            const inputs = formGroup.querySelectorAll('input')

            for (const input of inputs) {
                input.defaultValue = ""
                input.placeholder = `${input.dataset.placeholder}`
            }
            if (lastNo) {
                formGroup.dataset.no = (Number(lastNo) + 1)
            }
            fieldset.append(formGroup)
        })

        $('.y-field').click(function(e) {
            e.preventDefault();
            if ($(e.target).parents('fieldset').find('.y-form-group').length > 1 && e.target.classList.contains('y-remove-field')) {
                $(e.target).parent('.y-form-group').remove()
            }
        })

    </script>
@endsection
