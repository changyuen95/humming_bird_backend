@extends('voyager::master')

@section('content')
<div class="container-fluid mt-5">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>Tour Listing</h3>
            <a href="{{ route('tour.create') }}" class="btn btn-success">Add Tour</a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table table-bordered" id="tourTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tours as $tour)
                        <tr>
                            <td>{{ $tour->name }}</td>
                            <td>{{ $tour->from_date }}</td>
                            <td>{{ $tour->to_date }}</td>
                            <td>{{ $tour->price }}</td>
                            <td>{{ $tour->status }}</td>
                            <td>{{ $tour->updated_at? $tour_updated_at->format('Y-m-d H:i:s') : null }}</td>
                            <td>
                                <a href="{{ route('tour.edit', $tour->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form action="{{ route('tour.destroy', $tour->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this tour?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

        // Replace it with
    jQuery(document).ready(function () {
        jQuery('#tourTable').DataTable();
    });
</script>
@endsection
