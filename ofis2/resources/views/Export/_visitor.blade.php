<table>
    <thead>
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Company</th>
        <th>Necessity</th>
        <th>Visit Date</th>
    </tr>
    </thead>
    <tbody>
    @php
        $no = 1;
    @endphp
    @foreach($visitor as $vis)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $vis->name }}</td>
            <td>{{ $vis->phone }}</td>
            <td>{{ $vis->company }}</td>
            <td>{{ $vis->necessity }}</td>
            <td>{{ date('M d, Y H:i:s', strtotime($vis->created_at)) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
