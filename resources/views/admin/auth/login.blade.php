@extends('layouts.store')
@section('title', 'Đăng nhập quản trị')
@section('content')
<section class="container-page grid min-h-[68vh] place-items-center py-16">
    <div class="w-full max-w-md border border-stone-300 bg-white p-7 sm:p-10">
        <p class="eyebrow">{{ $storeSettings->shop_name }} · Quản trị</p><h1 class="mt-3 font-display text-4xl">Chào mừng trở lại.</h1><p class="mt-3 text-sm leading-6 text-stone-600">Đăng nhập để quản lý sản phẩm và danh mục.</p>
        @if($errors->any())<p class="mt-5 text-sm text-red-700" role="alert">{{ $errors->first() }}</p>@endif
        <form class="mt-7 space-y-5" method="POST" action="{{ route('admin.login.store') }}">@csrf
            <label class="block"><span class="eyebrow">Địa chỉ email</span><input class="form-control mt-2" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus></label>
            <label class="block"><span class="eyebrow">Mật khẩu</span><input class="form-control mt-2" type="password" name="password" autocomplete="current-password" required></label>
            <label class="flex items-center gap-2 text-sm text-stone-600"><input type="checkbox" name="remember" value="1" class="border-stone-400 text-ink focus:ring-ink"> Ghi nhớ đăng nhập</label>
            <button class="button-primary w-full">Đăng nhập</button>
        </form>
    </div>
</section>
@endsection
