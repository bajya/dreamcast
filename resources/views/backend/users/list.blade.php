@if(!empty($results) && count($results) > 0)
    @foreach ($results as $val)
        <tr>
            <td><img src="{{ $val->image }}" width="70%" /></td>
            <td>{{ ucfirst($val->name) }}</td>
            <td>{{ $val->phone_code.' '.$val->mobile }}</td>
            <td>{{ $val->email }}</td>
            <td>{{ isset($val->role->name) ? ucfirst($val->role->name) : '-' }}</td>
            <td>{!! $val->description !!}</td>
        </tr>
    @endforeach
@endif
 