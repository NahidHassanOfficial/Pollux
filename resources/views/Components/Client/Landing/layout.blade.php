@extends('welcome')

@section('content')
    <x-client.components.nav></x-Client.components.nav>
    <!-- Add padding to prevent content from hiding under fixed nav -->
    <div class="pt-16">
        <x-Client.Landing.hero></x-Client.Landing.hero>
        <x-Client.Landing.feature-stats></x-Client.Landing.feature-stats>
    </div>
    <x-client.components.footer></x-Client.components.footer>
@endsection
