@extends('layouts.master')

@section('title', 'Ubah Password')

@section('content')
<!-- BEGIN: Content-->
<div class="content-wrapper">

    <!-- <div class="content-header row">
          <div class="content-header-left col-md-9 col-12 mb-2 mt-1">
            <div class="row breadcrumbs-top">
              <div class="col-12">
                <h2 class="content-header-title float-start mb-0">Dashboard</h2>
                <div class="breadcrumb-wrapper">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-warning" href="index.html"><i data-feather="home"></i></a>
                    </li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
        </div> -->

    <main class="content-body">

        <!-- Statistik -->
        <section class="row">
            <div class="col-6">
                <div class="card">
                    @include('include.alert')
                    <div class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
                        <div class="header-left">
                            <h4 class="card-title">Ubah Password</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('post.password') }}" method="post">
                            @csrf
                            <div class="col-12 mb-2">
                                <label>Password Lama</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password_lama" placeholder="Masukkan Password Anda...">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <label>Password Baru</label>
                                <div class="input-group input-group-merge form-password-toggle">
                                    <input type="password" class="form-control" name="password_baru" placeholder="Masukkan Password baru Anda...">
                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <label>Konfirmasi Password</label>
                                <div class="input-group input-group-merge form-password-toggle">
                                    <input type="password" class="form-control" name="konfirmasi_password" placeholder="Konfirmasi Password baru Anda...">
                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <button class="btn btn-success" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

    </main>
</div>

@endsection