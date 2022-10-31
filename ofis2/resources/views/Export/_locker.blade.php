<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Employee ID</th>
        <th>Employee Name</th>
        <th>Locker Name</th>
        <th>Open Date</th>
        <th>Open Time</th>
    </tr>
    </thead>
    <tbody>
    @php
        $no = 1;
    @endphp
    @foreach($locker as $loc)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $loc->empl_id }}</td>
            <td>{{ $loc->empl_name }}</td>
            <td>{{ $loc->locker_name }}</td>
            <td>{{ date('M d, Y', strtotime($loc->created_at)) }}</td>
            <td>{{ date('H:i:s', strtotime($loc->created_at)) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
