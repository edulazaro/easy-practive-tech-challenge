@extends('layouts.app')

@section('content')
<div class="max-w-screen-2xl mx-auto">
    <client-show :client='@json($client)'/>
</div>
@endsection