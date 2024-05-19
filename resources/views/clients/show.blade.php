@extends('layouts.app')

@section('content')
<div class="container-fluid max-w-screen-2xl mx-auto">
    <client-show :client='@json($client)'/>
</div>
@endsection