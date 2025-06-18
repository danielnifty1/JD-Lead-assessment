# Laravel E-Commerce Application

A modern e-commerce application built with Laravel, featuring product management, shopping cart, order processing, and Cloudinary integration for image uploads.

## Features

- User Authentication (Register/Login)
- Product Browsing and Management
- Shopping Cart Functionality
- Order Processing and Management
- Admin Dashboard
- Image Upload with Cloudinary
- Responsive Design

## Prerequisites

- PHP >= 8.1
- Composer
- MySQL
- Node.js & NPM
- Cloudinary Account

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd <project-folder>
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install and compile frontend dependencies:
```bash
npm install
npm run dev
```

4. Create and configure environment file:
```bash
cp .env.example .env
```

5. Configure your `.env` file with:
   - Database credentials
   - Cloudinary credentials:
     ```
     CLOUDINARY_CLOUD_NAME=your_cloud_name
     CLOUDINARY_API_KEY=your_api_key
     CLOUDINARY_API_SECRET=your_api_secret
     ```

6. Generate application key:
```bash
php artisan key:generate
```

7. Run database migrations:
```bash
php artisan migrate
```

8. Publish vendor files:
```bash
php artisan vendor:publish --provider="CloudinaryLabs\CloudinaryLaravel\CloudinaryServiceProvider"
```

## Running the Application

1. Start the Laravel development server:
```bash
php artisan serve
```

2. Access the application at `http://localhost:8000`

## Usage

### Customer Features

1. **Registration and Login**
   - Visit `/register` to create a new account
   - Visit `/login` to access your account

2. **Browse Products**
   - View all products at `/products`
   - Click on individual products for detailed view

3. **Shopping Cart**
   - Add products to cart
   - Update quantities
   - Remove items
   - Proceed to checkout

4. **Orders**
   - View order history
   - Track order status
   - Cancel orders (if applicable)

### Admin Features

1. **Access Admin Panel**
   - Login as admin
   - Navigate to `/admin`

2. **Product Management**
   - Add new products
   - Edit existing products
   - Upload product images
   - Manage inventory

3. **Order Management**
   - View all orders
   - Update order status
   - Process refunds

## File Upload

The application uses Cloudinary for file uploads. To upload files:

1. Navigate to `/uploads`
2. Select your file
3. The file will be uploaded to Cloudinary
4. You'll receive a secure URL for the uploaded file

## Security

- Authentication is required for cart and order operations
- Admin middleware protects administrative routes
- CSRF protection is enabled
- Secure file uploads through Cloudinary

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License.
