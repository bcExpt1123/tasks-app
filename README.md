# Laravel To-Do List Application

A simple to-do list application built with Laravel and Jetstream, allowing users to manage tasks with essential features like authentication, task completion, and CRUD operations.

## Features

- **User Authentication**: Register and login with Jetstream's built-in authentication.
- **Task Management**: Create, view, edit, delete, and mark tasks as completed.
- **Authorization**: Users can only access and modify their own tasks.
- **Validation**: Ensures valid task title and description inputs.
- **Testing**: Comprehensive test cases for all CRUD operations.

## Prerequisites

To run this application, you’ll need:
- PHP >= 8.2
- Composer
- Node.js and npm
- MySQL or SQLite for the database

## Installation

Follow these steps to set up the project:

1. **Install dependencies**:

```bash
composer install
npm install
```

2. **Set up environment variables**:

Copy .env.example to .env and update the database credentials.

```bash
cp .env.example .env
```

3. **Generate an application key**:

```bash
php artisan key:generate
```

4. **Run database migrations**:

```bash
php artisan migrate --seed
```

5. **Start the vite development server**

```bash
npm run dev
```

5. **Serve the application**:

```bash
php artisan serve
```

## Testing

The application includes tests for CRUD operations and task completion toggling.

1. **Run the tests**:

```bash
php artisan test --filter=TaskTest
```

2. **Test Coverage**:

- **Create Task**: Ensures users can create tasks with valid data
- **Edit Task**: Ensures users can only edit their own tasks
- **Delete Task**: Ensures users can only delete their own tasks
- **Toggle Completion**: Confirms the toggle functionality works and restricts access to the task owner

