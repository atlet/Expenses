# Expenses

An application for tracking personal and business expenses, built with the CakePHP 5.2 framework.

## Overview

"Expenses" enables accurate recording and analysis of financial outflows. It is designed for easy data entry and clear reporting.

### Key Features

*   **Expense Tracking**: Record one-time and recurring expenses.
*   **Categorization**: Organize expenses by categories for better transparency.
*   **Splits**: Ability to split expenses (e.g., between multiple people or departments).
*   **People Management**: Manage users and people associated with expenses.
*   **Attachments**: Store and manage proofs of purchase (invoices) with expenses.
*   **Statistics**: Comprehensive Dashboard and expense reports.

## Technologies

*   **PHP**: 8.1+
*   **Framework**: CakePHP 5.2
*   **Database**: MySQL / MariaDB
*   **Authentication**: CakePHP Authentication plugin

## Installation

To run the project locally, follow these steps:

1.  **Clone the Repository**
    ```bash
    git clone <repository-url>
    cd expenses
    ```

2.  **Install Dependencies**
    Use Composer to install the required libraries:
    ```bash
    composer install
    ```

3.  **Configuration**
    Copy the configuration template and edit the database settings:
    ```bash
    cp config/app_local.example.php config/app_local.php
    ```
    In `config/app_local.php`, set your MySQL database access details (host, username, password, database).

4.  **Database**
    Run migrations to set up the database structure:
    ```bash
    bin/cake migrations migrate
    ```

5.  **Start Server**
    For development, you can use the built-in PHP server:
    ```bash
    bin/cake server
    ```
    The application will be accessible at `http://localhost:8765`.

## Project Structure

*   `src/Controller`: Controllers for managing logic (Expenses, Categories, Users, ...).
*   `src/Model`: Data models and validation.
*   `templates`: Views for the application's presentation layer.
*   `tests`: Application tests.

## License

This project is based on the CakePHP framework and is licensed under the MIT License.
