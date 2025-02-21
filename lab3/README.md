# Лабораторная работа №3: Основы работы с базами данных в Laravel

## Инструкции по запуску проекта

1. **Установите Laravel** с помощью Composer:
   ```bash
   composer create-project laravel/laravel:^10 todo-app
   ```

2. **Перейдите в папку проекта**:
   ```bash
   cd todo-app
   ```

3. **Настройте файл окружения .env для работы с базой данных**:
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=todo_app
   ```

4. **Запустите миграции для создания таблиц в базе данных**:
   ```bash
   php artisan migrate
   ```

5. **Запустите сервер Laravel**:
   ```bash
   php artisan serve
   ```
   Откройте в браузере [http://127.0.0.1:8000](http://127.0.0.1:8000).


---

## Краткая документация к проекту

### **Создание моделей и миграций**
1. **Модель `Category`** (Категория задачи)
   ```bash
   php artisan make:model Category -m
   ```
   
2. **Миграция для таблицы `categories`**
   ```php
   Schema::create('categories', function (Blueprint $table) {
       $table->id();
       $table->string('name');
       $table->text('description')->nullable();
       $table->timestamps();
   });
   ```

3. **Модель `Task`** (Задача)
   ```bash
   php artisan make:model Task -m
   ```
   
4. **Миграция для таблицы `tasks`**
   ```php
   Schema::create('tasks', function (Blueprint $table) {
       $table->id();
       $table->string('title');
       $table->text('description')->nullable();
       $table->foreignId('category_id')->constrained();
       $table->timestamps();
   });
   ```

5. **Модель `Tag`** (Теги для задач)
   ```bash
   php artisan make:model Tag -m
   ```
   
6. **Миграция для таблицы `tags`**
   ```php
   Schema::create('tags', function (Blueprint $table) {
       $table->id();
       $table->string('name');
       $table->timestamps();
   });
   ```

7. **Создание промежуточной таблицы `task_tag`** (Связь многие ко многим между задачами и тегами)
   ```bash
   php artisan make:migration create_task_tag_table
   ```
   ```php
   Schema::create('task_tag', function (Blueprint $table) {
       $table->foreignId('task_id')->constrained()->onDelete('cascade');
       $table->foreignId('tag_id')->constrained()->onDelete('cascade');
   });
   ```

---

## Связи между моделями

1. **Модель `Category` (Категория может иметь много задач)**
   ```php
   public function tasks() {
       return $this->hasMany(Task::class);
   }
   ```

2. **Модель `Task` (Задача принадлежит категории и имеет много тегов)**
   ```php
   public function category() {
       return $this->belongsTo(Category::class);
   }

   public function tags() {
       return $this->belongsToMany(Tag::class);
   }
   ```

3. **Модель `Tag` (Тег может быть прикреплен ко многим задачам)**
   ```php
   public function tasks() {
       return $this->belongsToMany(Task::class);
   }
   ```

---

## Фабрики и сиды

1. **Создайте фабрики для моделей `Category`, `Task`, `Tag`**
   ```bash
   php artisan make:factory CategoryFactory --model=Category
   php artisan make:factory TaskFactory --model=Task
   php artisan make:factory TagFactory --model=Tag
   ```

2. **Создайте сидеры для тестовых данных**
   ```bash
   php artisan db:seed
   ```

---

## Контроллеры и представления

1. **Обновите контроллер `TaskController` для работы с БД**
   ```php
   public function index() {
       $tasks = Task::with(['category', 'tags'])->get();
       return view('tasks.index', compact('tasks'));
   }
   ```

2. **Обновите представления для работы с полученными данными**
   ```blade
   @foreach($tasks as $task)
       <h2>{{ $task->title }}</h2>
       <p>Категория: {{ $task->category->name }}</p>
       <p>Теги: @foreach($task->tags as $tag) {{ $tag->name }} @endforeach</p>
   @endforeach
   ```

---

## Контрольные вопросы и ответы

1. **Что такое миграции и для чего они используются?**  
   Миграции в Laravel — это механизм для управления структурой базы данных с помощью кода. Они позволяют версионировать изменения в БД, упрощают развёртывание и поддержку проекта.

2. **Что такое фабрики и сиды, и как они упрощают процесс разработки и тестирования?**  
   Фабрики позволяют автоматически генерировать тестовые данные для моделей, а сиды заполняют базу заранее подготовленными значениями. Это ускоряет тестирование и разработку.

3. **Что такое ORM? В чем различия между паттернами `DataMapper` и `ActiveRecord`?**  
   ORM (Object-Relational Mapping) — это способ работы с БД через объекты. В Laravel используется `Eloquent ORM`, который использует паттерн `ActiveRecord` (каждый объект модели соответствует записи в БД). `DataMapper` же отделяет логику БД от моделей.

4. **В чем преимущества использования ORM по сравнению с прямыми SQL-запросами?**  
   - Упрощает работу с БД, снижая количество SQL-кода.  
   - Позволяет писать код в объектно-ориентированном стиле.  
   - Поддерживает защиту от SQL-инъекций.  
   - Автоматически обрабатывает связи между таблицами.

5. **Что такое транзакции и зачем они нужны при работе с базами данных?**  
   Транзакции позволяют выполнить несколько SQL-операций как одно целое. Если одна из операций не удалась, все изменения откатываются. Это полезно для целостности данных (например, при банковских переводах).
