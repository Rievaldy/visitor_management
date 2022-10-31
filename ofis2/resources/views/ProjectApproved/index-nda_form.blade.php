<form action="{{ url('project-approved/update-nda-form/'.$id_project.'/'.$id_project_location) }}" method="post">
    @csrf
    <div class="row">
        <!-- Left Column -->
        <div class="col-sm-12 col-md-6">
            <p class="h6"><strong>Please fill your area detail</strong></p>
            <br>

            <!-- Restricted area field -->
            <div class="form-group">
                <fieldset class="y-field">
                    <p class="d-flex align-items-center justify-content-between">
                        <label>Restricted Area</label>
                        <button type="button" class="btn btn-primary btn-sm y-add-field"><i class="fas fa-plus"></i> Add Other Restricted Area</button>
                    </p>
                    <div class="y-form-group form-group d-flex justify-content-between">
                        <div class="flex-grow-1 mr-2">
                            <div class="form-group">
                                    <label>Area Name</label>
                                    <select id="restricted_area" class="form-control" name="restricted_area[]">
                                    @if (!count($restricted_areas))
                                        <option value="-1">No data availlable</option>
                                    @endif
                                    @foreach ($restricted_areas as $restricted_area)
                                        <option value="{{ $restricted_area->id }}">{{ $restricted_area->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <input class="form-control mx-1" type="text" name="restricted_area[]" data-placeholder="Area's name " placeholder="Area's name"> --}}
                            </div>
                            <div class="form-group">
                                    <label>Purpose</label>
                                    <select id="restricted_area-purpose" class="form-control" name="restricted_area_purpose[]">
                                    @foreach ($purposes as $purpose)
                                        <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <textarea class="form-control mx-1" type="text" name="restricted_area_purpose[]" data-placeholder="Purpose " placeholder="Purpose"></textarea> --}}
                            </div>
                        </div>
                        <i class="cursor-pointer p-2 fas fa-times y-remove-field "></i>
                    </div>
                </fieldset>
            </div>

            <!-- Strictly estricted area field -->
            <div class="form-group">
                <fieldset class="y-field">
                    <p class="d-flex align-items-center justify-content-between">
                        <label>Strictly Restricted Area</label>
                        <button type="button" class="btn btn-primary btn-sm y-add-field"><i class="fas fa-plus"></i> Add Other Strictly Restricted Area</button>
                    </p>
                    <div class="y-form-group form-group d-flex justify-content-between">
                        <div class="flex-grow-1 mr-2">
                            <div class="form-group">
                                <label>Area Name</label>
                                <select id="strictly_restricted_area" class="form-control" name="strictly_restricted_area[]">
                                    @if (!count($strictly_restricted_areas))
                                        <option value="-1">No data availlable</option>
                                    @endif
                                    @foreach ($strictly_restricted_areas as $strictly_restricted_area)
                                        <option value="{{ $strictly_restricted_area->id }}">{{ $strictly_restricted_area->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <input class="form-control mx-1" type="text" name="strictly_restricted_area[]" data-placeholder="Area's name " placeholder="Area's name" value="{{$projectLocation->location->name}}"> --}}
                            </div>
                            <div class="form-group">
                                <label>Purpose</label>
                                <select id="strictly_restricted_area-purpose" class="form-control" name="strictly_restricted_area_purpose[]">
                                    @foreach ($purposes as $purpose)
                                        <option value="{{ $purpose->id }}">{{ $purpose->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <textarea class="form-control mx-1" name="strictly_restricted_area_purpose[]" data-placeholder="Purpose " placeholder="Purpose"></textarea> --}}
                            </div>
                        </div>
                        <i class="cursor-pointer p-2 fas fa-times y-remove-field"></i>
                    </div>
                </fieldset>
            </div>

        </div>
        <!-- End of Left Column -->

        <!-- Right Column -->
        <div class="col-sm-12 col-md-6">
            <p class="h6"><strong>How many communication devices do you bring ?</strong></p>
            <br>
            <!-- Devices field -->
            <div class="form-group">
                <fieldset class="y-field">
                    <p class="d-flex align-items-center justify-content-between">
                        <label>Member - Device - Purpose - Qty</label>
                        <button type="button" class="btn btn-primary btn-sm y-add-field"><i class="fas fa-plus"></i> Add Other Devices</button>
                    </p>
                    @foreach ($project->visitor_project as $v)
                        <div class="y-form-group form-group d-flex align-items-center">
                            <select id="visitor_project_id" class="form-control" name="visitor_project_id[]">
                                @foreach ($project->visitor_project as $visitor_project)
                                    <option value="{{ $visitor_project->id }}" {{ $v->id === $visitor_project->id ? 'selected' : '' }}>{{ $visitor_project->visitor->name }}</option>
                                @endforeach
                            </select>
                            <span class="mx-5">-</span>
                            <select id="device_id" class="form-control" name="device_id[]">
                                @foreach ($devices as $device)
                                    <option value="{{ $device->id }}">{{ $device->name }}</option>
                                @endforeach
                            </select>
                            <span class="mx-5">-</span>
                            <select id="purpose_device_id" class="form-control" name="purpose_device_id[]">
                                @foreach ($purdevices as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            {{-- <input type="text" class="form-control" name="devicepurpose[]" placeholder="Purpose"> --}}
                            <span class="mx-5">-</span>
                            <input class="form-control mx-1n w-100 text-right" type="number" name="device_qty[]" data-placeholder="1 " placeholder="1" value="1">
                            <a href="javascript:void(0)" class="btn btn-danger y-remove-field ml--3  ">
                                <i class="cursor-pointer px-2 fas fa-times"></i>
                            </a>
                        </div>
                    @endforeach
                    {{-- <div class="y-form-group form-group d-flex align-items-center">
                        <input class="form-control mx-1" type="text" name="device_name[]" data-placeholder="Device name " placeholder="Device name" value="Device name">
                        <input class="form-control mx-1" type="number" name="device_qty[]" data-placeholder="Other device quantity " placeholder="Other device quantity">
                        <i class="cursor-pointer px-2 fas fa-times y-remove-field"></i>
                    </div> --}}
                </fieldset>
            </div>
        </div>
        <!-- End of Right Column -->

        <div class="col-md-12">
            <div class="form-group">
                <button class="btn btn-success" type="submit">Submit</button>
            </div>
        </div>
    </div>
</form>

@section('script2')
    <script>


    </script>
@endsection
