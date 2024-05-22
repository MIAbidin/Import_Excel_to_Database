# Import Excel to Database

This project allows users to upload an Excel file containing data and import it into a MySQL database table. It consists of two main files:

1. **index.php**: This file contains the HTML form for uploading the Excel file and displaying data from the database.
2. **import.php**: This script handles the file upload, validates the Excel file, maps its columns to the database table columns, and inserts the data into the database.

## Getting Started

To use this project, follow these steps:

1. Clone this repository to your local machine or server:
git clone <repository-url>

2. Ensure you have PHP and Composer installed on your machine or server.

3. Install the required dependencies by running the following command in the project directory:

Composer install

4. Set up your MySQL database and update the `koneksi.php` file with your database credentials.

5. Make sure the directory where you intend to store uploaded files is writable by the web server.

6. Navigate to the project directory in your web browser and start using the application by uploading an Excel file.

## File Structure

- **index.php**: HTML form for uploading Excel files and displaying data from the database.
- **import.php**: Script to handle file upload, validate Excel file, and import data into the database.
- **koneksi.php**: File containing database connection configuration.
- **vendor/**: Directory containing Composer dependencies.

## Dependencies

This project relies on the following external libraries:

- **PhpOffice/PhpSpreadsheet**: Used for reading Excel files.
- **mysqli**: PHP extension for MySQL database access.

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, please open an issue or submit a pull request.
