@extends('layouts.app')

@section('title', 'Список задач')

@section('content')
    <h1>Список задач</h1>
    <ul>
        @foreach($tasks as $task)
            <li>
                <a href="{{ route('tasks.show', $task['id']) }}">
                    {{ $task['title'] }} ({{ $task['status'] }})
                </a>
            </li>
        @endforeach
    </ul>
@endsection
