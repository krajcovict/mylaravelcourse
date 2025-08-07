@props(['title' => '', 'bodyClass' => null, 'footerLinks' => ''])

<x-base-layout :$title :$bodyClass>
    <x-layouts.header />
    {{ $slot }}
    <footer>

    </footer>
</x-base-layout>





