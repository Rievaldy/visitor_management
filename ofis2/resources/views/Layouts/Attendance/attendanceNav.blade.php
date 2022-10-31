<div class="row">
    <div class="col-sm-1 col-4 pr-0">
        <a href="{{ route('purchasing') }}" class="btn btn-outline-primary btn-sm btn-block {{ Request::segment(1) === 'attendance' &&  Request::segment(2) === 'all' ? 'active' : '' }}">
            All
        </a>
    </div>
    <div class="col-sm-1 col-4 pr-0">
        <a href="{{ route('attendanceOnline') }}" class="btn btn-outline-primary btn-sm btn-block {{ Request::segment(1) === 'attendance'  && Request::segment(2) === 'online' || Request::segment(3) === 'online' ? 'active' : '' }}">
            Online
        </a>
    </div>
    <div class="col-sm-1 col-4">
        <a href="{{ route('attendanceOffline') }}" class="btn btn-outline-primary btn-sm btn-block {{ Request::segment(1) === 'attendance' && Request::segment(2) === 'offline' || Request::segment(3) === 'offline' ? 'active' : '' }}">
            Offline
        </a>
    </div>
</div>
