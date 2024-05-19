@extends('layouts.app')

@section('content')
<div class="container-fluid max-w-screen-2xl mx-auto">
    <clients-list :clients='@json($clients)'></clients-list>
</div>
@endsection