@extends('layouts.auth')

@section('title')
    Masuk - UMKM Universitas Gunadarma
@endsection

@section('content')

    <div class="page-content page-auth">
        <div class="section-store-auth" data-aos="fade-up">
            <div class="container">
                <div class="row align-items-center justify-content-center row-login">
                    <div class="col-10 col-md-4 col-lg-5">
                        <div class="card shadow">
                            <div class="card-header bg-dark">
                                <h2 class="text-center text-white mt-2"><strong>Masuk</strong></h2>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input id="email" 
                                                type="email" 
                                                class="form-control rounded-0 @error('email') is-invalid @enderror"
                                                name="email" 
                                                value="{{ old('email') }}" 
                                                required
                                                autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input id="password" 
                                                type="password" 
                                                class="form-control rounded-0 @error('password') is-invalid @enderror" 
                                                name="password"
                                                required>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-dark btn-block mt-4 rounded-0">Masuk</button>
                                    <small class="btn btn-block" style="font-size: 13px; color: #aaa; cursor: text;">
                                            Belum punya akun? <a href="{{ route('register') }}" style="text-decoration: none; color: black;">Daftar</a>
                                    </small>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection
