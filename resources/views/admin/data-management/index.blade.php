@extends('admin.layout')

@section('title', 'Data Management')

@section('content')
<div class="container mx-auto px-4 py-8 space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-6 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Data Management</h2>
            <p class="text-gray-600 mt-2 text-sm">Manage soft-deleted records and restore or permanently delete them</p>
        </div>
    </div>

    <!-- @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif -->

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    @if(count($deletedData) > 0)
        @foreach($deletedData as $table => $data)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ ucfirst(str_replace('_', ' ', $table)) }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Table: {{ $table }}</p>
                        </div>
                        <span class="px-3 py-1 text-sm font-medium text-indigo-600 bg-indigo-100 rounded-full">
                            {{ $data['count'] }} deleted records
                        </span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                                @foreach($data['columns'] as $column)
                                    @if($column !== 'id' && $column !== 'deleted_at')
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ ucfirst(str_replace('_', ' ', $column)) }}</th>
                                    @endif
                                @endforeach
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Deleted At</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($data['records'] as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $record->id }}</td>
                                    @foreach($data['columns'] as $column)
                                        @if($column !== 'id' && $column !== 'deleted_at')
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $record->$column }}
                                            </td>
                                        @endif
                                    @endforeach
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $record->deleted_at }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <form action="{{ route('admin.data-management.restore', [$table, $record->id]) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900 transition duration-200" title="Restore">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.data-management.permanent-delete', [$table, $record->id]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition duration-200" title="Delete Permanently" onclick="return confirm('Are you sure you want to permanently delete this record?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="text-center text-gray-500">
                No deleted records found.
            </div>
        </div>
    @endif
</div>
@endsection 