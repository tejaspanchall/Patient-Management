<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @livewireStyles
    <style>
        .modal-content {
            max-height: 80vh;
            overflow-y: auto;
        }
        .invalid-input {
            border-color: #EF4444;
        }
        .valid-input {
            border-color: #10B981;
        }
        .validation-message {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .error-message {
            color: #EF4444;
        }
        .success-message {
            color: #10B981;
        }
    </style>
</head>
<body class="bg-gray-100">
    
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Patient Management</h1>
                <button onclick="openModal()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Add New Patient
                </button>
            </div>

            <livewire:patients-table />
        </div>
    </div>

    @include('admin.patients.modal')

    @livewireStyles
    @livewireScripts
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function openModal(patientId = null) {
            if (patientId) {
                $.get(`/admin/patients/${patientId}`, function(data) {
                    fillModalWithData(data);
                });
            }
            document.getElementById('patientModal').classList.remove('hidden');
            resetValidationStyles();
        }

        function closeModal() {
            document.getElementById('patientModal').classList.add('hidden');
            document.getElementById('patientForm').reset();
            resetValidationStyles();
        }

        function resetValidationStyles() {
            const form = document.getElementById('patientForm');
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.classList.remove('invalid-input', 'valid-input');
                const message = input.parentElement.querySelector('.validation-message');
                if (message) {
                    message.remove();
                }
            });
        }

        function fillModalWithData(patient) {
            const form = document.getElementById('patientForm');
            form.elements['patient_id'].value = patient.id;

            for (let key in patient) {
                const input = form.elements[key];
                if (input) {
                    if (key === 'date_of_birth') {
                        input.value = patient[key].split('T')[0];
                    } else {
                        input.value = patient[key];
                    }
                }
            }
            document.getElementById('modalTitle').textContent = 'Edit Patient';
        }

        function validateEmail(email) {
            const pattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return pattern.test(email);
        }

        function validatePhone(phone) {
            const pattern = /^[0-9]{3}-[0-9]{4}$|^[0-9]{10}$/;
            return pattern.test(phone);
        }

        function formatPhoneNumber(phone) {
            return phone.replace(/\D/g, '');
        }

        function showValidationMessage(input, isValid, message) {
            const parent = input.parentElement;
            let messageElement = parent.querySelector('.validation-message');
            
            if (!messageElement) {
                messageElement = document.createElement('div');
                messageElement.className = 'validation-message';
                parent.appendChild(messageElement);
            }

            input.classList.remove('valid-input', 'invalid-input');
            input.classList.add(isValid ? 'valid-input' : 'invalid-input');
            messageElement.className = `validation-message ${isValid ? 'success-message' : 'error-message'}`;
            messageElement.textContent = message;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('patientForm');

            // Real-time validation
            const emailInput = form.elements['email'];
            const phoneInput = form.elements['phone_number'];
            const emergencyPhoneInput = form.elements['emergency_contact_phone'];

            emailInput.addEventListener('input', function() {
                const isValid = validateEmail(this.value);
                showValidationMessage(
                    this,
                    isValid,
                    isValid ? 'Valid email address' : 'Please enter a valid email address'
                );
            });

            phoneInput.addEventListener('input', function() {
                const isValid = validatePhone(this.value);
                showValidationMessage(
                    this,
                    isValid,
                    isValid ? 'Valid phone number' : 'Please enter a valid phone number'
                );
            });

            emergencyPhoneInput.addEventListener('input', function() {
                const isValid = validatePhone(this.value);
                showValidationMessage(
                    this,
                    isValid,
                    isValid ? 'Valid phone number' : 'Please enter a valid phone number'
                );
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let isValid = true;

                // Validate email
                if (!validateEmail(emailInput.value)) {
                    showValidationMessage(emailInput, false, 'Please enter a valid email address');
                    isValid = false;
                }

                // Validate phone numbers
                if (!validatePhone(phoneInput.value)) {
                    showValidationMessage(phoneInput, false, 'Please enter a valid phone number');
                    isValid = false;
                }

                if (!validatePhone(emergencyPhoneInput.value)) {
                    showValidationMessage(emergencyPhoneInput, false, 'Please enter a valid emergency contact phone number');
                    isValid = false;
                }

                if (!isValid) {
                    return false;
                }

                // Format phone numbers
                phoneInput.value = formatPhoneNumber(phoneInput.value);
                emergencyPhoneInput.value = formatPhoneNumber(emergencyPhoneInput.value);

                // Prepare form data for submission
                const formData = new FormData(this);
                const patientId = formData.get('patient_id');

                const data = {};
                formData.forEach((value, key) => {
                    if (key !== '_token') {
                        data[key] = value;
                    }
                });

                // Submit form
                $.ajax({
                    url: patientId ? `/admin/patients/${patientId}` : '/api/patients',
                    method: patientId ? 'PUT' : 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    data: JSON.stringify(data),
                    processData: false,
                    success: function(response) {
                        closeModal();
                        window.location.reload();
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                        alert('Error: ' + (xhr.responseJSON?.message || 'Something went wrong'));
                    }
                });
            });
        });

        function deletePatient(patientId) {
            if (confirm('Are you sure you want to delete this patient?')) {
                $.ajax({
                    url: `/admin/patients/${patientId}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        if(response.status === 'success') {
                            window.location.reload();
                        } else {
                            alert('Error: Failed to delete patient');
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        alert('Error: ' + (xhr.responseJSON?.message || 'Failed to delete patient'));
                    }
                });
            }
        }
    </script>
</body>
</html>