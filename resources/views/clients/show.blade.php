<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Client Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('clients.edit', $client) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit Client
                </a>
                <a href="{{ route('clients.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-2xl font-bold">
                                {{ substr($client->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $client->name }}</h3>
                                <div class="flex items-center mt-1">
                                    @if($client->removed)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Deleted</span>
                                    @elseif($client->enabled)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Disabled</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Contact Information</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="mb-3">
                                    <span class="text-sm text-gray-500 block">Email</span>
                                    <span class="text-base text-gray-900 font-medium">{{ $client->email ?? 'Not provided' }}</span>
                                </div>
                                <div class="mb-3">
                                    <span class="text-sm text-gray-500 block">Phone</span>
                                    <span class="text-base text-gray-900 font-medium">{{ $client->phone ?? 'Not provided' }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Location</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="mb-3">
                                    <span class="text-sm text-gray-500 block">Country</span>
                                    <span class="text-base text-gray-900 font-medium">{{ $client->country ?? 'Not provided' }}</span>
                                </div>
                                <div class="mb-3">
                                    <span class="text-sm text-gray-500 block">Address</span>
                                    <span class="text-base text-gray-900 font-medium">{{ $client->address ?? 'Not provided' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                             <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">System Information</h4>
                             <div class="bg-gray-50 p-4 rounded-lg grid grid-cols-2">
                                <div>
                                    <span class="text-sm text-gray-500 block">Created At</span>
                                    <span class="text-base text-gray-900 font-medium">{{ $client->created_at->format('M d, Y h:i A') }}</span>
                                </div>
                                <div>
                                    <span class="text-sm text-gray-500 block">Last Updated</span>
                                    <span class="text-base text-gray-900 font-medium">{{ $client->updated_at->format('M d, Y h:i A') }}</span>
                                </div>
                             </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
