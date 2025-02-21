# Лабораторная работа №5: Компоненты безопасности в Laravel

## Введение
В данной лабораторной работе я продолжил разработку проекта **Task Manager**, добавив компоненты безопасности, такие как аутентификация, авторизация, защита маршрутов, работа с ролями пользователей, а также механизм выхода и защиту от CSRF-атак.

---

## Инструкции по запуску проекта

1. **Перейти в папку проекта**:
   ```bash
   cd task-manager
   ```
2. **Проверить настройки .env** (подключение к базе данных):
   ```env
   DB_DATABASE=task_manager
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. **Запустить миграции**:
   ```bash
   php artisan migrate
   ```
4. **Запустить локальный сервер**:
   ```bash
   php artisan serve
   ```
5. **Открыть проект в браузере**:  
    `http://127.0.0.1:8000`

---

## Описание лабораторной работы

### 1. Аутентификация пользователей

Создан контроллер `AuthController`, содержащий методы:
- `register()` — отображение формы регистрации
- `storeRegister()` — обработка данных формы регистрации
- `login()` — отображение формы входа
- `storeLogin()` — обработка данных формы входа
- `logout()` — выход из системы

Настроены маршруты в `routes/web.php`:
```php
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister']);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'storeLogin']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
```

Созданы представления `resources/views/auth/register.blade.php` и `resources/views/auth/login.blade.php` с формами.

---

### 2. Авторизация пользователей

- Реализована страница **личного кабинета** `dashboard`, доступная только авторизованным пользователям.
- Добавлен middleware `auth` в маршрут:
```php
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');
```

Создано представление `resources/views/dashboard.blade.php`, отображающее данные авторизованного пользователя.

---

### 3. Роли пользователей

Добавлена колонка `role` в таблицу `users` с возможными значениями `admin` и `user`.

Создан метод в `User.php` для проверки роли:
```php
public function isAdmin()
{
    return $this->role === 'admin';
}
```

Настроены права доступа с использованием `Gate`:
```php
Gate::define('view-users', function ($user) {
    return $user->isAdmin();
});
```

Добавлен маршрут `/users` (только для администраторов):
```php
Route::get('/users', [UserController::class, 'index'])->middleware('auth')->name('users.index');
```

Создано представление `resources/views/users/index.blade.php`, выводящее список пользователей.

---

### 4. Выход из системы и защита от CSRF

- В каждой форме добавлена защита от CSRF (`@csrf`).
- Добавлена кнопка выхода в `dashboard.blade.php`:
```blade
<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Выйти</button>
</form>
```

---

## Контрольные вопросы

1. **Какие готовые решения для аутентификации предоставляет Laravel?**  
   Laravel предоставляет пакеты Breeze, Fortify, Jetstream для реализации аутентификации.

2. **Какие методы аутентификации пользователей вы знаете?**  
   - Через сессию (стандартный `Auth`)
   - API-токены (Passport, Sanctum)
   - OAuth (через Laravel Socialite)

3. **Чем отличается аутентификация от авторизации?**  
   - **Аутентификация** — это проверка личности пользователя (логин/пароль).
   - **Авторизация** — это проверка прав доступа к ресурсам (например, роли пользователей).

4. **Как обеспечить защиту от CSRF-атак в Laravel?**  
   - Использовать `@csrf` в формах.
   - Проверять CSRF-токен в запросах.
