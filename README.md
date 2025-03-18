# Patient Management System

The Patient Management System is designed to help healthcare facilities efficiently manage their patient information. It offers features for adding, viewing, updating, and deleting patient records with an intuitive user interface.

## Features

- **Patient Records Management**: Create, read, update, and delete patient information
- **Advanced Search & Filtering**: Quickly find patients by name, email, phone number, gender, or blood type
- **Sortable Data**: Sort patient records by different fields
- **Responsive Design**: Works seamlessly on desktop and mobile devices
- **Data Validation**: Ensures accurate and complete patient information
- **Soft Deletion**: Safely archives patient records instead of permanently deleting them

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Livewire, Tailwind CSS
- **Database**: MySQL/PostgreSQL (configurable)

## Installation

1. Clone the repository:
   ```
   git clone https://github.com/tejaspanchall/Patient-Management.git
   cd Patient-Management
   ```

2. Install dependencies:
   ```
   composer install
   npm install
   ```

3. Configure environment variables:
   ```
   cp .env.example .env
   php artisan key:generate
   ```

4. Set up your database credentials in the `.env` file

5. Run migrations:
   ```
   php artisan migrate
   ```

6. Start the development server:
   ```
   php artisan serve
   npm run dev
   ```

## Usage

1. Access the admin dashboard at `/admin/patients`
2. Use the search bar to find specific patients
3. Filter patients by gender or blood group
4. Click on a patient row to view detailed information
5. Edit patient details through the provided form
6. Delete patients when necessary (records are soft-deleted)

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the project
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.
