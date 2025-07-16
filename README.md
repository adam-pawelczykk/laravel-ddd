# 🧱 Laravel Modular CQRS Application

Projekt oparty o framework **Laravel 12**, zgodny z podejściem **CQRS (Command Query Responsibility Segregation)**, z modularną architekturą aplikacji oraz automatyczną rejestracją handlerów (komend, zapytań i eventów).

---

## 📦 Zawartość projektu

- ✅ Modularna architektura (każdy moduł to osobna domena w `app/Modules/*`)
- ✅ CQRS – osobne klasy dla komend (Commands) i zapytań (Queries)
- ✅ Obsługa zdarzeń domenowych/aplikacji (Events)
- ✅ Automatyczna detekcja handlerów za pomocą refleksji
- ✅ Automatyczna mapowanie requestów na DTO
- ✅ Własny QueryBus
- ✅ Własny CommandBus
- ✅ Własny EventBus
- ✅ Wsparcie middleware w CommandBus
- ✅ Wsparcie stamps w CommandBus i EventBus
- ✅ Automatyczna rejestracja ServiceProvider na podstawie modułów
- ✅ Routing oparty o atrybuty (Spatie Laravel Route Attributes)
- ✅ Testy jednostkowe i funkcjonalne

---

## 🏗️ Struktura katalogów

```
app/
├── Modules/
│   └── Product/
│       ├── Core/
│       │   ├── Application/
│       │   │   ├── Command/
│       │   │   ├── CommandHandler/
│       │   │   ├── Query/
│       │   │   ├── QueryHandler/
│       │   │   └── DTO/
│       │   │   └── Event/
│       │   │   └── EventHandler/
│       │   ├── Domain/
│       │   │   ├── Entity/
│       │   │   └── ProductRepository.php
│       │   └── Infrastructure/
│       │       ├── Repository/
│       │       └── Providers/
│       └── UI/
│           └── Controller/
├── System/
│   ├── Console/
│   ├── MessageBus/
│   └── Providers/
```

---

## ⚙️ Jak działa rejestracja handlerów?

Każdy handler (np. `CreateProductHandler`) jest rejestrowany automatycznie na podstawie:

- Plików znajdujących się w folderach przekazanych przez `HandlerPathProvider`
- Nazwy klasy (`*Handler`)
- Obecności metody `__invoke` przyjmującej `Command`, `Query` lub `Event`

Np.:

```php
class CreateProductHandler
{
    public function __invoke(CreateProduct $command) { ... }
}
```

---

## 🚀 Uruchomienie projektu

1. Skopiuj plik `.env.example` jako `.env`:
   ```bash
   cp .env.example .env
   ```

2. Wygeneruj klucz:
   ```bash
   php artisan key:generate
   ```

3. Utwórz bazę SQLite:
   ```bash
   touch database/database.sqlite
   ```

4. Wykonaj migracje:
   ```bash
   php artisan migrate
   ```

5. Uruchom serwer:
   ```bash
   php artisan serve
   ```

---

## 🧪 Testowanie

Uruchom testy:
```bash
php artisan test
```

Przykład testu:
```php
$this->postJson('/products', [...])
     ->assertStatus(201);
```

Testy znajdują się w `tests/Modules/Product/Feature/`.

---

## 🛠️ Dostępne komendy artisan

- `php artisan bus:debug` – debugowanie zarejestrowanych handlerów (Command/Query/Event)
- `php artisan route:list` – przegląd dostępnych endpointów

---

## 🧰 Wykorzystane pakiety

- [`spatie/laravel-data`](https://github.com/spatie/laravel-data) – mapowanie DTO
- [`spatie/laravel-route-attributes`](https://github.com/spatie/laravel-route-attributes) – routing za pomocą atrybutów PHP
- [`ramsey/uuid`](https://github.com/ramsey/uuid) – UUID jako identyfikatory encji

---

## ✅ Przykład działania

1. **Dodanie produktu:**
   ```
   POST /products
   {
       "name": "Test Product",
       "description": "Some description",
       "price": 99.99,
       "tags": ["tag1", "tag2"]
   }
   ```

2. **Pobranie produktu:**
   ```
   GET /products/{uuid}
   ```

---

## 🔄 TODO / dalszy rozwój

- Obsługa kolejek (async commands/events)
- API versioning
- Autoryzacja
- Generowanie dokumentacji OpenAPI
