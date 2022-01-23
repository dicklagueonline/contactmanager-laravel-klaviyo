@extends('layouts.app')

@section('content')
    <contacts user-data-id="{{ auth()->user()->id }}"></contacts>
@endsection
