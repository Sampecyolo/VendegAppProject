#  VendégApp API – Backend


Technológiák: **PHP 8.2**, **Laravel**, **MySQL**, **REST JSON API**.

##  Tech Stack
- **PHP:** 8.2.12  
- **Framework:** Laravel  
- **Database:** MySQL  
- **API Format:** REST + JSON

##  Telepítés és futtatás

### 1. Klónozd a repót
```bash
mkdir backend
cd backend
git clone https://github.com/Sampecyolo/vendegAppApi.git
```

### 2. Install dependencies
```bash
composer install
```

### 3. Setup .env
```
DB_HOST=your_host
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

### 4. Migráció
```bash
php artisan migrate
```

### 5. Szerver indítása
```bash
php artisan serve
```

##  API Dokumentáció

Headers:
```
Content-Type: application/json
Accept: application/json
```

#  Booking API
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/bookings | List all bookings |
| GET | /api/bookings/{id} | Get booking by ID |
| POST | /api/bookings | Create booking |
| PUT | /api/bookings/{id} | Update booking |
| DELETE | /api/bookings/{id} | Delete booking |

### Booking Model
- roomNumber (integer)  
- checkIn (date)  
- checkOut (date)  
- numberOfGuests (integer)  
- paid (integer)  
- paymentMethod (string)

### Example
```json
{
  "roomNumber": 104,
  "checkIn": "2024-06-01",
  "checkOut": "2024-06-05",
  "numberOfGuests": 2,
  "paid": 1,
  "paymentMethod": "credit_card"
}
```

#  Guest API
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | /api/guests | List all guests |
| GET | /api/guests/{id} | Get guest by ID |
| POST | /api/guests | Create guest |
| PUT | /api/guests/{id} | Update guest |
| DELETE | /api/guests/{id} | Delete guest |

### Guest Model
- booking_id  
- firstName  
- lastName  
- phoneNumber  
- address  

### Example
```json
{
  "booking_id": 1,
  "firstName": "János",
  "lastName": "Kovács",
  "phoneNumber": "+36301234567",
  "address": "1111 Budapest, Fő utca 1."
}
```

##  Error responses
```json
{
  "status": "ERROR",
  "error": "404 not found"
}
```
