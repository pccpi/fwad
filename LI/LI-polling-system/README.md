

## 1. Введение
Проект **Polling System** представляет собой систему голосования, разработанную с использованием фреймворка Laravel. В рамках данного проекта были реализованы основные компоненты безопасности, такие как аутентификация, авторизация, защита маршрутов, работа с ролями пользователей, механизм выхода и защита от CSRF-атак. Проект позволяет пользователям создавать опросы, участвовать в них, просматривать результаты и фильтровать опросы по статусу.

---

## 2. Инструкции по установке и запуску

### 2.1 Требования
- PHP ^8.0
- Composer
- MySQL или другой совместимый СУБД
- Node.js и npm (для фронтенда)

### 2.2 Установка
1. **Клонирование проекта**:
   ```bash
   git clone https://github.com/your-repository/polling-system.git
   cd polling-system
   ```

2. **Установка зависимостей**:
   ```bash
   composer install
   npm install
   ```

3. **Настройка окружения**:
   Создайте файл `.env` на основе `.env.example` и настройте параметры подключения к базе данных:
   ```env
   DB_DATABASE=polling_system
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Запуск миграций**:
   ```bash
   php artisan migrate
   ```

5. **Генерация ключа приложения**:
   ```bash
   php artisan key:generate
   ```

6. **Запуск локального сервера**:
   ```bash
   php artisan serve
   ```

7. **Открытие проекта в браузере**:
   ```
   http://127.0.0.1:8000
   ```

---

## 3. Описание функционала

### 3.1 Аутентификация пользователей
Реализована система аутентификации с использованием стандартных возможностей Laravel:

- **Регистрация**: Пользователи могут зарегистрироваться через форму регистрации.
- **Вход**: Пользователи могут войти в систему, используя свои учетные данные.
- **Выход**: Пользователи могут выйти из системы.

#### Маршруты для аутентификации:
```php
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister']);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'storeLogin']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
```

#### Представления:
- `resources/views/auth/register.blade.php` — форма регистрации.
- `resources/views/auth/login.blade.php` — форма входа.

---

### 3.2 Авторизация пользователей
Реализована система авторизации для защиты доступа к ресурсам:

- **Личный кабинет**: Доступен только авторизованным пользователям.
- **Маршрут**:
  ```php
  Route::get('/dashboard', function () {
      return view('dashboard');
  })->middleware('auth')->name('dashboard');
  ```

#### Представление:
- `resources/views/dashboard.blade.php` — страница личного кабинета.

---

### 3.3 Роли пользователей
Добавлена поддержка ролей (`admin` и `user`) для управления доступом к ресурсам:

- **Добавление роли**:
  Колонка `role` добавлена в таблицу `users` с возможными значениями `admin` и `user`.

- **Проверка роли**:
  Метод `isAdmin()` в модели `User.php`:
  ```php
  public function isAdmin()
  {
      return $this->role === 'admin';
  }
  ```

- **Права доступа**:
  Настроены права доступа с использованием `Gate`:
  ```php
  Gate::define('view-polls', function ($user) {
      return $user->isAdmin();
  });
  ```

- **Маршрут для администраторов**:
  ```php
  Route::get('/polls', [PollController::class, 'index'])->middleware('auth')->name('polls.index');
  ```

#### Представление:
- `resources/views/polls/index.blade.php` — список опросов.

---

### 3.4 Создание опросов
Пользователи могут создавать опросы с вопросами и вариантами ответов:

- **Методы контроллера**:
  ```php
  public function store(Request $request)
  {
      $validated = $request->validate([
          'question' => 'required|string|max:255',
          'options' => 'required|array|min:2',
          'options.*' => 'required|string|max:255',
      ]);

      $poll = auth()->user()->polls()->create(['question' => $validated['question']]);

      foreach ($validated['options'] as $optionText) {
          $poll->options()->create(['text' => $optionText]);
      }

      return response()->json($poll->load('options'), 201);
  }
  ```

- **Маршрут**:
  ```php
  Route::post('/polls', [PollController::class, 'store']);
  ```

---

### 3.5 Голосование
Пользователи могут голосовать за варианты ответов в опросах:

- **Методы контроллера**:
  ```php
  public function store(Request $request, Option $option)
  {
      $user = auth()->user();

      if ($user->votes()->where('option_id', $option->id)->exists()) {
          return response()->json(['message' => 'You have already voted for this poll.'], 400);
      }

      $vote = $user->votes()->create(['option_id' => $option->id]);
      $option->increment('votes');

      return response()->json(['message' => 'Your vote has been recorded.'], 201);
  }
  ```

- **Маршрут**:
  ```php
  Route::post('/votes/{option}', [VoteController::class, 'store']);
  ```

---

### 3.6 Защита от CSRF-атак
- В каждой форме добавлен токен CSRF (`@csrf`).
- Пример формы выхода:
  ```blade
  <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit">Выйти</button>
  </form>
  ```

---

## 4. Технические детали

### 4.1 База данных
- **Таблицы**:
  - `users`: Хранит информацию о пользователях.
  - `polls`: Хранит опросы, созданные пользователями.
  - `options`: Хранит варианты ответов для опросов.
  - `votes`: Хранит голоса пользователей.

- **Миграции**:
  - Создание таблицы `polls`:
    ```php
    Schema::create('polls', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('question');
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
    ```

  - Создание таблицы `options`:
    ```php
    Schema::create('options', function (Blueprint $table) {
        $table->id();
        $table->foreignId('poll_id')->constrained()->onDelete('cascade');
        $table->string('text');
        $table->integer('votes')->default(0);
        $table->timestamps();
    });
    ```

  - Создание таблицы `votes`:
    ```php
    Schema::create('votes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('option_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
    ```

---

## 5. Контрольные вопросы

### 5.1 Какие готовые решения для аутентификации предоставляет Laravel?
Laravel предоставляет пакеты Breeze, Fortify, Jetstream для реализации аутентификации.

### 5.2 Какие методы аутентификации пользователей вы знаете?
- Через сессию (стандартный `Auth`).
- API-токены (Passport, Sanctum).
- OAuth (через Laravel Socialite).

### 5.3 Чем отличается аутентификация от авторизации?
- **Аутентификация**: Проверка личности пользователя (логин/пароль).
- **Авторизация**: Проверка прав доступа к ресурсам (например, роли пользователей).

### 5.4 Как обеспечить защиту от CSRF-атак в Laravel?
- Использовать `@csrf` в формах.
- Проверять CSRF-токен в запросах.

