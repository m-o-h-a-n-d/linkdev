@extends('backend.layouts.app')

@section('title', 'Users | Handball System')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-users text-primary mr-2"></i>System Users</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-gray-800">Registered Web Users</h6>
            <span class="badge badge-primary font-weight-bold">{{ $users->total() }} Users</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Email Verification</th>
                            <th>Registered Date</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td class="font-weight-bold">
                                    <span class="text-primary font-weight-bold"><i
                                            class="fas fa-user-circle mr-1 text-primary"></i> {{ $user->name }}</span>
                                </td>
                                <td class="font-weight-medium text-gray-800">{{ $user->email }}</td>
                                <td>
                                    @if ($user->hasRole('super-admin'))
                                        <span class="badge badge-danger">Admin</span>
                                    @else
                                        <span class="badge badge-secondary">User</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->email_verified_at)
                                        <span class="badge badge-success"><i
                                                class="fas fa-check-circle mr-1"></i>Verified</span>
                                    @else
                                        <span class="badge badge-warning text-dark"><i
                                                class="fas fa-clock mr-1"></i>Pending</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $user->created_at ? $user->created_at->format('M d, Y') : '-' }}
                                </td>
                                <td class="text-right">
                                    <div class="d-flex justify-content-end align-items-center" style="gap: 8px;">
                                        @can('users.edit')
                                        <form action="{{ route('admin.users.toggle-admin', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="btn btn-sm {{ $user->hasRole('super-admin') ? 'btn-outline-danger' : 'btn-success' }}">
                                                <i
                                                    class="fas {{ $user->hasRole('super-admin') ? 'fa-user-minus' : 'fa-user-plus' }} mr-1"></i>
                                                {{ $user->hasRole('super-admin') ? 'Remove Admin' : 'Make Admin' }}
                                            </button>
                                        </form>
                                        @endcan

                                        @can('users.delete')
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this user permanently from all related tables?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash mr-1"></i>
                                                Delete
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($users->hasPages())
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    @endif
@endsection
