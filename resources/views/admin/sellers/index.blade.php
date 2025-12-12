@extends('layouts.app') {{-- أو layouts.admin لو عندك --}}
@section('title', 'Sellers')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Sellers</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($sellers->count())
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Approved</th>
                    <th width="220">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sellers as $seller)
                    <tr>
                        <td>{{ $seller->id }}</td>
                        <td>{{ $seller->name }}</td>
                        <td>{{ $seller->email }}</td>
                        <td>{{ $seller->phone }}</td>
                        <td>
                            @if($seller->approved)
                                <span class="badge badge-success">Approved</span>
                            @else
                                <span class="badge badge-secondary">Pending</span>
                            @endif
                        </td>
                        <td>
                            {{-- Edit --}}
                            <a href="{{ route('admin.sellers.edit', $seller->id) }}"
                               class="btn btn-sm btn-primary">
                                Edit
                            </a>

                            {{-- Approve --}}
                            @if(!$seller->approved)
                                <form action="{{ route('admin.sellers.approve', $seller->id) }}"
                                      method="POST"
                                      style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success">
                                        Approve
                                    </button>
                                </form>
                            @endif

                            {{-- Delete --}}
                            <form action="{{ route('admin.sellers.destroy', $seller->id) }}"
                                  method="POST"
                                  style="display:inline-block;"
                                  onsubmit="return confirm('Delete this seller?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $sellers->links() }}
    @else
        <p>No sellers found.</p>
    @endif
</div>
@endsection
