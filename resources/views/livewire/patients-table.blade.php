<div>
    <div class="mb-4 flex flex-wrap gap-4 items-center">
        <input wire:model.live="search" type="text" placeholder="Search patients..." 
            class="p-2 border rounded w-full md:w-1/3">
        
        <select wire:model.live="filterGender" class="p-2 border rounded">
            <option value="">All Genders</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select>

        <select wire:model.live="filterBloodGroup" class="p-2 border rounded">
            <option value="">All Blood Groups</option>
            <option value="A+">A+</option>
            <option value="A-">A-</option>
            <option value="B+">B+</option>
            <option value="B-">B-</option>
            <option value="AB+">AB+</option>
            <option value="AB-">AB-</option>
            <option value="O+">O+</option>
            <option value="O-">O-</option>
        </select>

        <button wire:click="resetFilters" class="px-4 py-2 rounded border flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
        </svg>
        Reset
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-6 py-3 border-b cursor-pointer w-20" wire:click="sortBy('id')">
                        ID 
                        @if($sortField === 'id')
                            <span>{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 border-b cursor-pointer w-40" wire:click="sortBy('first_name')">
                        First Name
                        @if($sortField === 'first_name')
                            <span>{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 border-b cursor-pointer w-40" wire:click="sortBy('last_name')">
                        Last Name
                        @if($sortField === 'last_name')
                            <span>{!! $sortDirection === 'asc' ? '↑' : '↓' !!}</span>
                        @endif
                    </th>
                    <th class="px-6 py-3 border-b w-32">Date of Birth</th>
                    <th class="px-6 py-3 border-b w-28">Gender</th>
                    <th class="px-6 py-3 border-b w-36">Phone</th>
                    <th class="px-6 py-3 border-b w-64">Email</th>
                    <th class="px-6 py-3 border-b w-96">Address</th>
                    <th class="px-6 py-3 border-b w-64">Emergency Contact</th>
                    <th class="px-6 py-3 border-b w-28">Blood Group</th>
                    <th class="px-6 py-3 border-b w-96">Medical History</th>
                    <th class="px-6 py-3 border-b w-96">Allergies</th>
                    <th class="px-6 py-3 border-b w-32">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3 border-b">{{ $patient->id }}</td>
                        <td class="px-6 py-3 border-b truncate">{{ $patient->first_name }}</td>
                        <td class="px-6 py-3 border-b truncate">{{ $patient->last_name }}</td>
                        <td class="px-6 py-3 border-b">{{ $patient->date_of_birth->format('Y-m-d') }}</td>
                        <td class="px-6 py-3 border-b">{{ ucfirst($patient->gender) }}</td>
                        <td class="px-6 py-3 border-b truncate">{{ $patient->phone_number }}</td>
                        <td class="px-6 py-3 border-b">
                            <div class="max-w-full overflow-x-auto whitespace-nowrap">
                                {{ $patient->email }}
                            </div>
                        </td>
                        <td class="px-6 py-3 border-b">
                            <div class="max-w-full overflow-x-auto whitespace-nowrap">
                                {{ $patient->address }}
                            </div>
                        </td>
                        <td class="px-6 py-3 border-b">
                            <div class="max-w-full overflow-x-auto whitespace-nowrap">
                                {{ $patient->emergency_contact_name }} ({{ $patient->emergency_contact_phone }})
                            </div>
                        </td>
                        <td class="px-6 py-3 border-b">{{ $patient->blood_group }}</td>
                        <td class="px-6 py-3 border-b">
                            <div class="max-w-full overflow-x-auto whitespace-nowrap">
                                {{ $patient->medical_history }}
                            </div>
                        </td>
                        <td class="px-6 py-3 border-b">
                            <div class="max-w-full overflow-x-auto whitespace-nowrap">
                                {{ $patient->allergies }}
                            </div>
                        </td>
                        <td class="px-6 py-3 border-b">
                            @include('admin.patients.actions', ['patient' => $patient])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="px-6 py-4 border-b text-center">No patients found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $patients->links() }}
    </div>
</div>