<div class="flex space-x-2">
    <button onclick="openModal({{ $patient->id }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded">
        Edit
    </button>
    <button onclick="deletePatient({{ $patient->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
        Delete
    </button>
</div>