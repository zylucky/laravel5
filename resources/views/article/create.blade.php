@extends('layouts.app')
@section('content')
<h1>create</h1>
<form action="/article" method="post">
    {{ csrf_field() }}
    <label for="">title</label>
    <input type="text" name="title">
    <label for="">content</label>
    <input type="text" name="content">

    <button>submit</button>
</form>
@stop