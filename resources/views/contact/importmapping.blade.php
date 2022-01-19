@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Import Contact') }}</div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('contact.import.process') }}">
                        @csrf

                        <input type="hidden" name="import_file_data_id" value="{{ $import_file_data->id }}" />

                        @foreach($contact_fields as $field => $label)
                        <div class="form-group row">
                            <label for="{{ $field }}" class="col-md-4 col-form-label text-md-right">{{ __($label) }}</label>

                            <div class="col-md-6">
                                <select name="{{ $field }}" class="custom-select custom-select-sm @error($field) is-invalid @enderror">
                                    @foreach($import_column_headers as $header)
                                    <option value="{{ $header }}">{{ $header }}</option>
                                    @endforeach
                                </select>

                                @error($field)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        @endforeach

                        <div class="form-group row mb-0 mt-3">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Import') }}
                                </button>
                                <a href="{{ route('contact.index') }}" class="btn btn-secondary">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
