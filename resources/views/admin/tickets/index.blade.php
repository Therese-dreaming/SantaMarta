@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Support Tickets</h1>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        User
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Subject
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Created
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($tickets as $ticket)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        #{{ $ticket->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $ticket->user->name }}</div>
                        <div class="text-sm text-gray-500">{{ $ticket->user->email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">
                            @if($ticket->subject_type === 'others')
                                {{ $ticket->other_subject }}
                            @else
                                {{ str_replace('_', ' ', ucfirst($ticket->subject_type)) }}
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($ticket->status === 'open') bg-yellow-100 text-yellow-800
                            @elseif($ticket->status === 'in_progress') bg-blue-100 text-blue-800
                            @elseif($ticket->status === 'resolved') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $ticket->created_at->format('M j, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="text-[#0d5c2f] hover:text-[#0d5c2f]/80">
                            View Details
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tickets->links() }}
    </div>
</div>
@endsection 