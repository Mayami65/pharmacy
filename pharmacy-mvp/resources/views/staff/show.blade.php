<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Staff Details') }} - {{ $staff->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('staff.edit', $staff) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('staff.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $staff->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $staff->email }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Role</label>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $staff->role === 'manager' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $staff->role_display_name }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $staff->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $staff->status_display_name }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                            <div class="space-y-3">
                                @if($staff->phone)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $staff->phone }}</p>
                                    </div>
                                @endif
                                @if($staff->address)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Address</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $staff->address }}</p>
                                    </div>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Last Login</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $staff->last_login_at ? $staff->last_login_at->format('M d, Y H:i') : 'Never' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Member Since</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $staff->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Permissions -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Permissions</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full {{ $staff->canProcessSales() ? 'bg-green-500' : 'bg-red-500' }} mr-2"></div>
                                <span class="text-sm text-gray-700">Process Sales</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full {{ $staff->canManageInventory() ? 'bg-green-500' : 'bg-red-500' }} mr-2"></div>
                                <span class="text-sm text-gray-700">Manage Inventory</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full {{ $staff->canViewAnalytics() ? 'bg-green-500' : 'bg-red-500' }} mr-2"></div>
                                <span class="text-sm text-gray-700">View Analytics</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full {{ $staff->canGenerateReports() ? 'bg-green-500' : 'bg-red-500' }} mr-2"></div>
                                <span class="text-sm text-gray-700">Generate Reports</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full {{ $staff->canManageStaff() ? 'bg-green-500' : 'bg-red-500' }} mr-2"></div>
                                <span class="text-sm text-gray-700">Manage Staff</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
