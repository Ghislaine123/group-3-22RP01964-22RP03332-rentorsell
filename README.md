# 🏠 Mini House Buy or Rental System

_A comprehensive web application for buying and renting houses, built with Laravel and 

---

## 👩‍💼 Developers

1. **GIKUNDIRO Ange Ghislaine** – 22RP01964  
2. **URUJENI Shallon** – 22RP03332

---

## 🚀 Getting Started

### ✅ Prerequisites

- PHP 8.2 or higher  
- Composer  


### 🔧 Installation Steps

```bash
# 1. Clone the repository
git clone https://github.com/Ghislaine123/group-3-22RP01964-22RP03332-rentorsell.git

# 2. Navigate into the project folder
cd rentorsell

# 3. Install PHP dependencies
composer update

# 4. Link storage
php artisan storage:link

# 5. Run database migrations
php artisan migrate

# 6. Start Laravel development server
php artisan serve


## 🔐 Authentication Flow

1. **User Registration**
   - Register as buyer or seller
   - Input name, email, phone, password (hashed)

2. **User Login**
   - Authenticate using email and password
   - Sanctum-based token generation
   - Redirect based on user role

---

## 🔄 System Flow

### 👨‍💼 Seller Flow
1. Register/Login as seller  
2. Create and manage property listings  
3. View and respond to buyer requests  
4. Update property status  

### 🧑‍💼 Buyer Flow
1. Register/Login as buyer  
2. Browse available properties  
3. Search and filter listings  
4. Send requests or offers  
5. Track request status
