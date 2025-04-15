# 🏠 Mini House Buy or Rental System

_A comprehensive web application for buying and renting houses, built with Laravel._

---

## 👩‍💼 Developers

1. *GIKUNDIRO Ange Ghislaine* – 22RP01964  
2. *URUJENI Shallon* – 22RP03332

---

## 🚀 Getting Started

### ✅ Prerequisites

- PHP 8.2 or higher  
- Composer  

---

### 🔧 Installation Steps

#### 📁 Step 1: Clone the repository
```bash
git clone https://github.com/Ghislaine123/group-3-22RP01964-22RP03332-rentorsell.git
```

#### 📂 Step 2: Navigate into the project folder
```bash
cd rentorsell
```

#### 📦 Step 3: Install PHP dependencies
```bash
composer update
```

#### 🔗 Step 4: Link storage
```bash
php artisan storage:link
```

#### 🧱 Step 5: Run database migrations
```bash
php artisan migrate
```

#### 🚀 Step 6: Start Laravel development server
```bash
php artisan serve
```

---

## 🔐 Authentication Flow

### 1. *User Registration*
- Register as buyer or seller  
- Provide name, email, phone, and password  
- Passwords are securely hashed  

### 2. *User Login*
- Login using email and password  
- Sanctum-based token authentication  
- Redirect user based on role (buyer/seller)  

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

---

## 🧪 Testing
```bash
php artisan test
```

---

## 📄 License

This project is licensed under the MIT License – see the `LICENSE` file for details.
