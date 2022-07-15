@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <h4 class="alert-heading">Berhasil</h4>
    <div class="alert-body">
        {{ $message }}
    </div>
    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
</div>
@elseif ($message = Session::get('failed'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <h4 class="alert-heading">Perhatian !</h4>
    <div class="alert-body">
        {{ $message }}
    </div>
    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
</div>
@elseif (count($errors) > 0)
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <h4 class="alert-heading">Perhatian !</h4>
    <div class="alert-body">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
</div>
@endif