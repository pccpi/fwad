<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = [
            ['id' => 1, 'title' => 'Первая задача', 'status' => 'выполнено'],
            ['id' => 2, 'title' => 'Вторая задача', 'status' => 'в процессе']
        ];

        return view('tasks.index', compact('tasks'));
    }

    public function show($id)
    {
        $task = ['id' => $id, 'title' => "Задача $id", 'status' => 'ожидание'];
        return view('tasks.show', compact('task'));
    }
}
