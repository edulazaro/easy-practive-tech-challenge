@extends('layouts.app')

@section('content')
<div class="container max-w-screen-2xl mx-auto">
    <clients-list :clients='@json($clients)'></clients-list>
</div>
@endsection