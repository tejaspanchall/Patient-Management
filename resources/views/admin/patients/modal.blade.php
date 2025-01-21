<div id="patientModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-8 mx-auto mt-20 max-w-2xl rounded-lg modal-content">
        <h2 id="modalTitle" class="text-xl font-bold mb-4">Add New Patient</h2>
        <form id="patientForm">
            @csrf
            <input type="hidden" name="patient_id" value="">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2">First Name</label>
                    <input type="text" name="first_name" class="w-full border p-2 rounded" required>
                </div>
                <div>
                    <label class="block mb-2">Last Name</label>
                    <input type="text" name="last_name" class="w-full border p-2 rounded" required>
                </div>
                <div>
                    <label class="block mb-2">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="w-full border p-2 rounded" required>
                </div>
                <div>
                    <label class="block mb-2">Gender</label>
                    <select name="gender" class="w-full border p-2 rounded" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
    <label class="block mb-2">Phone Number</label>
    <input type="tel" 
           name="phone_number" 
           class="w-full border p-2 rounded" 
           pattern="^[0-9]{3}-[0-9]{4}$|^[0-9]{10}$"
           placeholder="0000000000"
           required>
    <span class="text-xs text-gray-500">Format: XXXXXXXXXX</span>
</div>
<div>
    <label class="block mb-2">Email</label>
    <input type="email" 
           name="email" 
           class="w-full border p-2 rounded"
           pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
           title="Please enter a valid email address"
           placeholder="example@email.com"
           required>
</div>
                <div class="col-span-2">
                    <label class="block mb-2">Address</label>
                    <textarea name="address" class="w-full border p-2 rounded" required></textarea>
                </div>
                <div>
                    <label class="block mb-2">Emergency Contact Name</label>
                    <input type="text" name="emergency_contact_name" class="w-full border p-2 rounded" required>
                </div>
                <div>
    <label class="block mb-2">Emergency Contact Phone</label>
    <input type="tel" 
           name="emergency_contact_phone" 
           class="w-full border p-2 rounded"
           pattern="^[0-9]{3}-[0-9]{4}$|^[0-9]{10}$"
           placeholder="0000000000"
           required>
    <span class="text-xs text-gray-500">Format: XXXXXXXXXX</span>
</div>
                <div>
                    <label class="block mb-2">Blood Group</label>
                    <select name="blood_group" class="w-full border p-2 rounded">
                        <option value="">Select Blood Group</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block mb-2">Medical History</label>
                    <textarea name="medical_history" class="w-full border p-2 rounded"></textarea>
                </div>
                <div class="col-span-2">
                    <label class="block mb-2">Allergies</label>
                    <textarea name="allergies" class="w-full border p-2 rounded"></textarea>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="button" onclick="closeModal()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Save Patient
                </button>
            </div>
        </form>
    </div>
</div>
