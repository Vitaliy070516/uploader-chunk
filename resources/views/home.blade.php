@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('File Uploads') }}</div>

                <div class="card-body">
                    <attachment-form></attachment-form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
