@extends('layouts.app')

@section('title', 'Задача ' . $task['id'])

@section('content')
    <h1>{{ $task['title'] }}</h1>
    <p>Статус: {{ $task['status'] }}</p>
    <a href="{{ route('tasks.index') }}">Назад к списку задач</a>
@endsection
