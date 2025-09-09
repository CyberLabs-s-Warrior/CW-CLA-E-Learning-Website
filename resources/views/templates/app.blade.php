<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <meta name="color-scheme" content="light dark">
  <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)">
  <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)">
  <meta name="title" content="AdminLTE v4 | Dashboard">
  <meta name="author" content="ColorlibHQ">
  <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard">
  <meta name="keywords" content="admin dashboard, bootstrap 5, adminlte">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Dashboard')</title>

  {{-- ⬇️ penting: render semua @push('styles') dari view --}}
  @stack('styles')
  {{-- opsional: jika ada section khusus head --}}
  @yield('head')
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">

  <div class="app-wrapper">
    @include('templates.header')
    @include('templates.sidebar')

    <main class="app-main">
      @yield('content')
    </main>

    @include('templates.footer')
  </div>

  {{-- script dari stack --}}
  @stack('scripts')
  {{-- kalau ada section scripts spesifik halaman --}}
  @yield('scripts')

  {{-- SweetAlert2 (pakai defer supaya tidak block) --}}
  <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
