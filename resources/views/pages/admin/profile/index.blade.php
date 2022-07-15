@extends('layouts.master')

@section('title', 'Profile')
@section('content')
<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
          <div class="card-body">
              <p class="card-title">Profile</p>
              <div class="row">
                <div class="col-12">
                  @include('pages.admin.member.detail',["user"=>$user,"counting"=>$counting])
                </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection