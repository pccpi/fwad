# Лабораторная работа №2: HTTP-запросы и шаблонизация в Laravel

## Инструкции по запуску проекта

1. **Установите Laravel** с помощью Composer:
   ```bash
   composer create-project laravel/laravel:^10 todo-app
   ```

2. **Перейдите в папку проекта**:
   ```bash
   cd todo-app
   ```

3. **Настройте файл окружения .env**:
   ```ini
   APP_NAME=ToDoApp
   APP_ENV=local
   APP_DEBUG=true
   APP_URL=http://localhost:8000
   ```

4. **Затем выполните команду для генерации ключа приложения:**
   ```bash
   php artisan key:generate
   ```

5. **Запустите сервер Laravel**:
   ```bash
   php artisan serve
   ```
   Откройте в браузере [http://127.0.0.1:8000](http://127.0.0.1:8000).

## Описание лабораторной работы

Цель работы — изучение HTTP-запросов в Laravel и шаблонизации с использованием Blade.  
В рамках работы разработано приложение "To-Do App для команд", которое позволяет управлять задачами внутри команды.

## Краткая документация к проекту

### **Маршруты (`routes/web.php`)**
```php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;

Route::get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/{id}', [TaskController::class, 'show'])->where('id', '[0-9]+')->name('tasks.show');
```

### **Контроллеры**
#### `HomeController`
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return view('home');
    }

    public function about() {
        return view('about');
    }
}
```

#### `TaskController`
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() {
        $tasks = [
            ['id' => 1, 'title' => 'Первая задача', 'status' => 'выполнено'],
            ['id' => 2, 'title' => 'Вторая задача', 'status' => 'в процессе']
        ];
        return view('tasks.index', compact('tasks'));
    }

    public function show($id) {
        $task = ['id' => $id, 'title' => "Задача $id", 'status' => 'ожидание'];
        return view('tasks.show', compact('task'));
    }
}
```

## Примеры использования

### **Скриншоты интерфейса**
*(Добавить изображения главной страницы, списка задач, страницы задачи)*

### **Фрагменты кода**
#### `resources/views/layouts/app.blade.php`
```html
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('tasks.index') }}">Список задач</a>
            <a href="{{ url('/about') }}">О нас</a>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
```

## Ответы на контрольные вопросы

1. **Что такое ресурсный контроллер в Laravel и какие маршруты он создает?**  
   Ресурсный контроллер — это контроллер, который автоматически создает маршруты для всех операций CRUD (`index`, `show`, `create`, `store`, `edit`, `update`, `destroy`).

2. **Объясните разницу между ручным созданием маршрутов и использованием ресурсного контроллера.**  
   - Ручное создание маршрутов требует явного объявления каждого маршрута.
   - `Route::resource('tasks', TaskController::class);` автоматически создает все маршруты CRUD.

3. **Какие преимущества предоставляет использование анонимных компонентов Blade?**  
   - Упрощение кода  
   - Повторное использование шаблонов  
   - Лучшая организация кода  

4. **Какие методы HTTP-запросов используются для выполнения операций CRUD?**  
   - `GET` — чтение (index, show)  
   - `POST` — создание (store)  
   - `PUT/PATCH` — обновление (update)  
   - `DELETE` — удаление (destroy)  
