@extends('core::layouts.master')

@section('content')
    <div class="flex items-center justify-center fixed start-0 end-0 bottom-0 top-0">
        <div class="transition-colors bg-gray-800 px-6 py-4 shadow-2xl text-center rounded-2xl border-2 border-gray-500">
            <h1>Module: <span class="text-blue-300">{!! config('core.name') !!} {{ currentUser('id') }}</span></h1>
            <div>
                <a href="{{ route('core::livewire.counter') }}" class="text-blue-500 text-[18px] underline">
                    Click to view Livewire example {{ currentUser('id') }}
                </a>
            </div>
        </div>
    </div>
@endsection
