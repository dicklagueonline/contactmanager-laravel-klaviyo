@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Load Contacts File') }}</div>

                <div class="card-body">
                    @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <form method="POST" action="{{ route('contact.import.upload') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <div class="custom-file @error('csv') is-invalid @enderror">
                                        <input type="file" class="custom-file-input" name="csv" id="csv" accept=".csv">
                                        <label class="custom-file-label" for="csv">Choose csv file to import</label>
                                    </div>
                                    @error('csv')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group row mb-0 mt-3">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Load File') }}
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
    </div>
</div>
@endsection
