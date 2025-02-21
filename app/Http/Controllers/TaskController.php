<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Models\Category;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $tasks = Task::with('category')->get(); // Загружаем задачи вместе с категориями
    return view('tasks.index', compact('tasks'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    $categories = \App\Models\Category::all(); // Загружаем категории из базы
    return view('tasks.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(CreateTaskRequest $request)
{
    // Создание новой задачи
    Task::create($request->validated());

    // Редирект с флеш-сообщением
    return redirect()->route('tasks.index')->with('success', 'Задача успешно создана!');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
{
    $categories = \App\Models\Category::all();
    return view('tasks.edit', compact('task', 'categories'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(CreateTaskRequest $request, Task $task)
{
    $task->update($request->validated());

    return redirect()->route('tasks.index')->with('success', 'Задача обновлена!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
{
    $task->delete();

    return redirect()->route('tasks.index')->with('success', 'Задача удалена!');
}

}
