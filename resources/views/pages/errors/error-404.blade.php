@extends('layouts.fullscreen-layout')

@section('content')
@php
    $currentYear = date('Y');
@endphp
  <div class="relative flex flex-col items-center justify-center min-h-screen p-6 overflow-hidden z-1">
      {{-- common grid shape --}}
      <x-common.common-grid-shape />
      <!-- Centered Content -->
      <div class="mx-auto w-full max-w-[242px] text-center sm:max-w-[472px]">
          <h1 class="mb-8 font-bold text-gray-800 text-title-md xl:text-title-2xl">
              ERROR
          </h1>

          <img src="/images/error/404.svg" alt="404" class="dark:hidden" />
          <img src="/images/error/404-dark.svg" alt="404" class="hidden" />

          <p class="mt-10 mb-6 text-base text-gray-700 sm:text-lg">
              We can't seem to find the page you are looking for!
          </p>

          <a href="/"
              class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3.5 text-sm font-medium text-gray-700 shadow-theme-xs hover:bg-gray-50 hover:text-gray-800">
              Back to Home Page
          </a>
      </div>
      <!-- Footer -->
      <p class="absolute text-sm text-center text-gray-500 -translate-x-1/2 bottom-6 left-1/2">
          &copy; {{ $currentYear }} - Doli
      </p>
  </div>
@endsection
