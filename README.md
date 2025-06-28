# SANAD Studio Backend API

A modern Laravel 12 REST API with OAuth2 authentication using Laravel Passport, comprehensive Swagger documentation, and clean architecture with Repository and Service patterns.

## 🚀 Features

- **Laravel 12** - Latest Laravel framework with modern PHP features
- **Laravel Passport** - OAuth2 authentication for secure API access
- **Swagger/OpenAPI** - Interactive API documentation
- **Repository Pattern** - Clean separation of data access logic
- **Service Layer** - Business logic abstraction
- **MySQL Database** - Robust relational database support
- **Form Request Validation** - Structured input validation
- **CORS Support** - Cross-origin resource sharing enabled

## 📋 Requirements

- PHP 8.2 or higher
- MySQL 5.7+ or 8.0+
- Composer
- Node.js & NPM (for frontend assets, optional)

## ⚡ Quick Start

### 1. Clone the Repository
```bash
git clone https://github.com/Moatazkhaled93/SANAD_STUDIO_BACKEND.git
cd SANAD_STUDIO_BACKEND
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration
Update your `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sanad_studio
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Database Migration & Seeding
```bash
php artisan migrate
php artisan passport:install
php artisan db:seed --class=AdminUserSeeder
```

### 6. Generate Swagger Documentation
```bash
php artisan l5-swagger:generate
```

### 7. Start the Server
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

## 🔐 Default Admin Credentials

- **Email:** `admin@sandstudio.com`
- **Password:** `123456789`

## 📚 API Documentation

Access the interactive Swagger documentation at:
```
http://localhost:8000/api/documentation
```

## 🛠 API Endpoints

### Authentication
- `POST /api/login` - User login
- `POST /api/logout` - User logout (requires authentication)
- `GET /api/user` - Get authenticated user profile
- `PUT /api/user` - Update user profile

### User Management
- `GET /api/users` - Get all users (paginated)
- `POST /api/users` - Create a new user
- `GET /api/users/{id}` - Get user by ID
- `PUT /api/users/{id}` - Update user
- `DELETE /api/users/{id}` - Delete user

## 🏗 Architecture

### Repository Pattern
- `BaseRepositoryInterface` - Common repository contract
- `UserRepositoryInterface` - User-specific repository contract
- `BaseRepository` - Base repository implementation
- `UserRepository` - User repository implementation

### Service Layer
- `BaseService` - Base service class
- `AuthService` - Authentication business logic
- `UserService` - User management business logic

### Request Validation
- `LoginRequest` - Login form validation
- `UpdateProfileRequest` - Profile update validation
- `StoreUserRequest` - User creation validation
- `UpdateUserRequest` - User update validation

## 🔧 Configuration

### Passport Configuration
The application uses Laravel Passport for OAuth2 authentication. Keys are automatically generated during installation.

### Swagger Configuration
Swagger documentation is configured in `config/l5-swagger.php` and can be customized as needed.

### CORS Configuration
CORS is configured to allow cross-origin requests for API consumption.

## 🧪 Testing

### Using Swagger UI
1. Navigate to `http://localhost:8000/api/documentation`
2. Use the login endpoint with admin credentials
3. Copy the access token from the response
4. Click "Authorize" and enter: `Bearer {your_token}`
5. Test protected endpoints

### Using cURL
```bash
# Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@sandstudio.com","password":"123456789"}'

# Get user profile (replace {token} with actual token)
curl -X GET http://localhost:8000/api/user \
  -H "Authorization: Bearer {token}"
```

## 📁 Project Structure

```
app/
├── Contracts/              # Interface definitions
├── Http/
│   ├── Controllers/API/    # API Controllers
│   ├── Middleware/         # Custom middleware
│   └── Requests/           # Form request validation
├── Models/                 # Eloquent models
├── Providers/              # Service providers
├── Repositories/           # Data access layer
└── Services/               # Business logic layer
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Support

For support, email support@sanadstudio.com or create an issue in this repository.

---

**Built with ❤️ using Laravel 12 & Laravel Passport**

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

## 🐳 Docker Deployment

### Development with Docker Compose
```bash
# Build and start containers
docker-compose up -d

# Access the application
# Web: http://localhost:8000
# phpMyAdmin: http://localhost:8080
```

### Production Docker Build
```bash
# Build production image
docker build -t sanad-studio-backend .

# Run production container
docker run -d -p 80:80 --name sanad-backend sanad-studio-backend
```

## 🚀 Production Deployment

### Automatic Deployment (CI/CD)
1. Configure GitHub secrets (see `DEPLOYMENT.md`)
2. Push to `main` branch to trigger automatic deployment

### Manual Deployment
```bash
# Deploy to production server
./deploy.sh

# Or setup production environment on server
./setup-production.sh
```

### Server Requirements
- **Server**: https://sanad.studio
- **IP**: 191.101.50.240
- **Path**: `/home/sanad/public_html/backend`
- **PHP**: 8.2+
- **MySQL**: 8.0+
- **SSL**: Required

## 📊 API Endpoints

### Authentication
- `POST /api/login` - User login
- `POST /api/logout` - User logout (authenticated)
- `GET /api/user` - Get current user (authenticated)

### CMS Pages
- `GET /api/pages` - List all pages
- `GET /api/pages/{section}` - Get page by section
- `PUT /api/pages/{section}` - Update page (authenticated)

### Partner Inquiries
- `POST /api/partners` - Submit inquiry (public)
- `GET /api/partners` - List inquiries (authenticated)
- `GET /api/partners/{id}` - Get inquiry details (authenticated)

### Blog Posts
- `GET /api/posts/published` - Get published posts
- `GET /api/posts/featured` - Get featured posts
- `POST /api/posts` - Create post (authenticated)
- `PUT /api/posts/{id}` - Update post (authenticated)

## 🔒 Security Features

- OAuth2 authentication with Bearer tokens
- CORS configuration
- Rate limiting
- SQL injection prevention
- XSS protection
- CSRF protection
- Security headers

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit
```

## 📝 Documentation

- **API Documentation**: `/api/documentation` (Swagger UI)
- **Deployment Guide**: `DEPLOYMENT.md`
- **Architecture**: Repository + Service Pattern

## 🛠️ Development

### Local Development Server
```bash
php artisan serve
# Access: http://localhost:8000
```

### Code Quality
```bash
# PHP CS Fixer
composer format

# Static Analysis
composer analyse
```

## 📞 Support

For technical support or questions:
- **Email**: dev@sandstudio.com
- **Website**: https://sanad.studio

## 📄 License

This project is proprietary software. All rights reserved by Sanad Studio.

---

**Built with ❤️ by Sanad Studio Team**
