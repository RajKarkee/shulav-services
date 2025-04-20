@forelse ($routes as $route)
    <tr>
        <td>{{ $route->fromLocation->name }}</td>
        <td>{{ $route->toLocation->name }}</td>
        <td>{{ $route->busType->bus_type_name }}</td>
        <td>{{ $route->description ?: 'N/A' }}</td>
        <td>
            <button class="btn btn-sm btn-primary" onclick="editData({{ $route->id }})">Edit</button>
            <button class="btn btn-sm btn-danger" onclick="delData({{ $route->id }})">Delete</button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center">No routes found</td>
    </tr>
@endforelse
