# Лабораторная работа №4: Формы и валидация данных в Laravel

## Введение
В данной лабораторной работе я создал **новый чистый проект Laravel**, после чего реализовал формы для добавления и редактирования задач, валидацию данных, защиту от CSRF-атак и кастомное правило проверки запрещенных слов.

---

##  Инструкции по запуску проекта

1. **Создать новый Laravel-проект**:
   ```bash
   composer create-project laravel/laravel task-manager
   ```
2. **Перейти в папку проекта**:
   ```bash
   cd task-manager
   ```
3. **Настроить .env** (обновить параметры подключения к базе данных):
   ```env
   DB_DATABASE=task_manager
   DB_USERNAME=root
   DB_PASSWORD=
   ```
4. **Создать и запустить миграции**:
   ```bash
   php artisan migrate
   ```
5. **Заполнить базу тестовыми данными**:
   ```bash
   php artisan db:seed --class=CategorySeeder
   ```
6. **Запустить локальный сервер**:
   ```bash
   php artisan serve
   ```
7. **Открыть проект в браузере**:  
    `http://127.0.0.1:8000`

---

##  Описание лабораторной работы

###  Реализовано:
 Форма для добавления задачи с выпадающим списком категорий  
 Валидация данных на сервере через `CreateTaskRequest`  
 Флеш-сообщения при успешном добавлении/обновлении задач  
 Возможность редактирования и удаления задач  
 Защита форм от CSRF  
 Кастомное правило `NoRestrictedWords` для фильтрации запрещенных слов  

---

##  Краткая документация

###  **Маршруты** (`routes/web.php`)
```php
use App\Http\Controllers\TaskController;

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
```

###  **Форма создания задачи (`create.blade.php`)**
```blade
<form action="{{ route('tasks.store') }}" method="POST">
    @csrf
    <label>Название:</label>
    <input type="text" name="title" required>

    <label>Описание:</label>
    <textarea name="description"></textarea>

    <label>Дата выполнения:</label>
    <input type="date" name="due_date" required>

    <label>Категория:</label>
    <select name="category_id">
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>

    <button type="submit">Создать</button>
</form>
```

###  **Кастомное правило `NoRestrictedWords.php`**
```php
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoRestrictedWords implements ValidationRule
{
    protected $restrictedWords = ['дурак', 'плохое', 'запрещено'];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($this->restrictedWords as $word) {
            if (stripos($value, $word) !== false) {
                $fail('Описание содержит запрещенные слова!');
            }
        }
    }
}
```

---

##  Примеры использования
###  **Создание задачи**
1. Перейти на `http://127.0.0.1:8000/tasks/create`  
2. Заполнить форму и нажать "Создать"  
3. Если всё верно, появится сообщение "Задача успешно создана!"   
4. Если данные некорректны, Laravel покажет ошибки   

###  **Редактирование задачи**
1. Перейти на `http://127.0.0.1:8000/tasks`  
2. Нажать "Редактировать" на задаче  
3. Изменить данные и сохранить  

###  **Удаление задачи**
1. Перейти на `http://127.0.0.1:8000/tasks`  
2. Нажать "Удалить"  
3. Подтвердить удаление  
4. Задача исчезнет из списка   

---

##  Контрольные вопросы

1 **Что такое валидация данных и зачем она нужна?**  
 Валидация — это проверка входных данных на корректность перед их обработкой. Она предотвращает ошибки и защищает систему от вредоносных данных.  

2 **Как обеспечить защиту формы от CSRF-атак в Laravel?**  
 В Laravel для защиты от CSRF-атак используется директива `@csrf` в HTML-формах. Она генерирует уникальный токен, который Laravel проверяет при отправке формы.  

3 **Как создать и использовать собственные классы запросов (`Request`) в Laravel?**  
 `Request`-класс создается командой `php artisan make:request CreateTaskRequest`. В нем определяются правила валидации и логика авторизации. В контроллере он используется вместо `Request`.  

4 **Как защитить данные от XSS-атак при выводе в представлении?**  
 Laravel экранирует данные автоматически при использовании `{{ $variable }}`. Для вывода HTML-кода безопасно использовать `{!! $variable !!}` только с проверенными данными.  

---

##  Список использованных источников
- Laravel Documentation: https://laravel.com/docs
- CSRF Protection: https://laravel.com/docs/10.x/csrf
- Validation Rules: https://laravel.com/docs/10.x/validation
