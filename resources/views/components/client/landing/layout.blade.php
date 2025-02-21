@extends('welcome')

@section('content')
    <x-client.components.nav></x-client.components.nav>
    <!-- Add padding to prevent content from hiding under fixed nav -->
    <div class="pt-16">
        <x-client.landing.hero></x-client.landing.hero>
        <x-client.landing.feature-stats></x-client.landing.feature-stats>
    </div>
    <x-client.components.footer></x-client.components.footer>
@endsection
