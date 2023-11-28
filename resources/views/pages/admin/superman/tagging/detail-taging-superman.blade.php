<style>
  .account-settings .user-profile {
      margin: 0 0 1rem 0;
      padding-bottom: 1rem;
      text-align: center;
  }
  .account-settings .user-profile .user-avatar {
      margin: 0 0 1rem 0;
  }
  .account-settings .user-profile .user-avatar img {
      width: 90px;
      height: 90px;
      -webkit-border-radius: 100px;
      -moz-border-radius: 100px;
      border-radius: 100px;
  }
  .account-settings .user-profile h5.user-name {
      margin: 0 0 0.5rem 0;
  }
  .account-settings .user-profile h6.user-email {
      margin: 0;
      font-size: 0.8rem;
      font-weight: 400;
      color: #9fa8b9;
  }
  .account-settings .about {
      margin: 2rem 0 0 0;
      text-align: center;
  }
  .account-settings .about h5 {
      margin: 0 0 15px 0;
      color: #007ae1;
  }
  .account-settings .about p {
      font-size: 0.825rem;
  }
  .form-control {
      border: 1px solid #cfd1d8;
      -webkit-border-radius: 2px;
      -moz-border-radius: 2px;
      border-radius: 2px;
      font-size: .825rem;
      background: #ffffff;
      color: #2e323c;
  }
  
  .card {
      background: #ffffff;
      -webkit-border-radius: 5px;
      -moz-border-radius: 5px;
      border-radius: 5px;
      border: 0;
      margin-bottom: 1rem;
  }

  /* .modal-header {
    padding:9px 15px;
    border-bottom:1px solid #eee;
    background-color: #0480be;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
     border-top-left-radius: 5px;
     border-top-right-radius: 5px;
 } */
  p {
    font-size: 14px;
  }

  .col-form-label {
    font-size: 14px;
  }

  hr {
    margin-top: 8px;
    margin-bottom : 8px;
  }
  </style>
<section style="background-color: #eee;">
  <div class="container">
    <div class="row">
      <div class="col-sm-4 pr-0">
        <div class="card">
          <div class="card-body text-center">
            <img src="{{ asset('assets/images/tpm.png') }}" alt="avatar"
              class="rounded-circle img-fluid" style="width: 150px;">
            <h5 class="my-3">White Tag</h5>
            <p class="text-muted mb-1">No : {{$data->no_taging}}</p>
            <p class="text-muted mb-1">Year : {{$data->tahun}}</p>
            <p class="text-muted mb-4">Period : {{$data->periode}}</p>
            <!-- <div class="d-flex justify-content-center mb-2">
              <button type="button" class="btn btn-primary">Follow</button>
              <button type="button" class="btn btn-outline-primary ms-1">Message</button>
            </div> -->
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Full Name</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{$data->name}}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Circle Group</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{$data->name_cg}}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Competency</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">{{$data->training_module}}</p>
              </div>
            </div>
            <!-- <hr> -->
            <!-- <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Mobile</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">(098) 765-4321</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0">Address</p>
              </div>
              <div class="col-sm-9">
                <p class="text-muted mb-0">Bay Area, San Francisco, CA</p>
              </div>
            </div> -->
          </div>
        </div>
        <div class="card">
          <div class="card-body">
          <!-- <p class="mb-4"><span class="text-primary font-italic me-1">assigment</span> Project Status
                </p> -->
              <div class="row">
                <div class="col-md-7">
                <div class="col-sm-12 rounded border d-flex mb-2">
                  <label class="col-form-label pl-1 col-sm-7">Existing</label>
                  <div>
                      @php
                          switch($data->actual){
                            case 0:
                              $existingUrl = asset('assets/images/point/0.png');
                            break;
                            case 1:
                              $existingUrl = asset('assets/images/point/1.png');
                            break;
                            case 2:
                              $existingUrl = asset('assets/images/point/2.png');
                            break;
                            case 3:
                              $existingUrl = asset('assets/images/point/3.png');
                            break;
                            case 4:
                              $existingUrl = asset('assets/images/point/4.png');
                            break;
                            case 5:
                              $existingUrl = asset('assets/images/point/5.png');
                            break;
                            default:
                              $existingUrl = "";
                            break;
                          }
                      @endphp
                      <img class="col-sm-5" style="max-width:60px;height:50px;padding:5px" src="{{$existingUrl}}">
                  </div>
                </div>
                <div class="col-sm-12 rounded border d-flex mb-2">
                  <label class="col-form-label pl-1 col-sm-7">Target</label>
                  <div>
                    @php
                      switch($data->target){
                        case 0:
                          $targetUrl = asset('assets/images/point/0.png');
                        break;
                        case 1:
                          $targetUrl = asset('assets/images/point/1.png');
                        break;
                        case 2:
                          $targetUrl = asset('assets/images/point/2.png');
                        break;
                        case 3:
                          $targetUrl = asset('assets/images/point/3.png');
                        break;
                        case 4:
                          $targetUrl = asset('assets/images/point/4.png');
                        break;
                        case 5:
                          $targetUrl = asset('assets/images/point/5.png');
                        break;
                        default:
                          $targetUrl = "";
                        break;
                      }
                    @endphp
                      <img class="col-sm-5" style="max-width:60px;height:50px;padding:5px" src="{{$targetUrl}}">
                  </div>
                </div>
                </div>
                <div class="col-md-5">
                    <div class="col-sm-12 rounded border mb-2 d-flex">
                    <label class="col-sm-7 col-form-label">Value</label>
                    <div class="col-sm-5 m-auto">
                      <p>{{$data->actual}}</p>
                    </div>
                  </div>
                  <div class="col-sm-12 rounded border mb-2 d-flex">
                  <label class="col-sm-7 col-form-label">Value</label>
                    <div class="col-sm-5 m-auto">
                      <p>{{$data->target}}</p>
                    </div>
                </div>
                </div>
                <!-- <div class="col-md-7">
                    <div class="col-sm-12 rounded border mb-2 d-flex">
                    <label class="col-sm-5 col-form-label">Date Open</label>
                    <div class="col-sm-7 m-auto">
                      <p>{{$data->date_open}}</p>
                    </div>
                  </div>
                  <div class="col-sm-12 rounded border mb-2 d-flex">
                  <label class="col-sm-5 col-form-label">Due Date</label>
                    <div class="col-sm-7 m-auto">
                      <p>{{$data->due_date}}</p>
                    </div>
                </div>
                </div> -->
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                <div class="row">
                <div class="col-sm-5">
                  <p class="mb-0">Learning Method</p>
                </div>
                <div class="col-sm-7">
                  <p class="text-muted mb-0">{{$data->learning_method}}</p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-5">
                  <p class="mb-0">Trainer</p>
                </div>
                <div class="col-sm-7">
                  <p class="text-muted mb-0">{{$data->trainer}}</p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-5">
                  <p class="mb-0">Date Plan Implementation</p>
                </div>
                <div class="col-sm-7">
                  <p class="text-muted mb-0">{{$data->date_plan_implementation}}</p>
                </div>
              </div>
              <!-- <hr> -->
              <!-- <div class="row">
                <div class="col-sm-5">
                  <p class="mb-0">Notes Learning Implementation</p>
                </div>
                <div class="col-sm-7">
                  <p class="text-muted mb-0">{!! $data->notes_learning_implementation !!}</p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-5">
                  <p class="mb-0">Date Closed</p>
                </div>
                <div class="col-sm-7">
                  <p class="text-muted mb-0">{{$data->date_closed}}</p>
                </div>
              </div> -->
            </div>
                <div class="col-sm-6">
                <!-- <div class="row">
                <div class="col-sm-5">
                  <p class="mb-0">Training Hours</p>
                </div>
                <div class="col-sm-7">
                  <p class="text-muted mb-0">{{$data->start}} S/d {{$data->finish}} WIB</p>
                </div>
              </div>
              <hr> -->
              <div class="row">
                <div class="col-sm-5">
                  <p class="mb-0">Date Verified</p>
                </div>
                <div class="col-sm-7">
                  <p class="text-muted mb-0">{{$data->date_verified}}</p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-5">
                  <p class="mb-0">Verified By</p>
                </div>
                <div class="col-sm-7">
                  <p class="text-muted mb-0">{{$data->verified_by}}</p>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-5">
                  <p class="mb-0">Result</p>
                </div>
                <div class="col-sm-7">
                @php
                          switch($data->result_score){
                            case 0:
                              $scoreUrl = asset('assets/images/point/0.png');
                            break;
                            case 1:
                              $scoreUrl = asset('assets/images/point/1.png');
                            break;
                            case 2:
                              $scoreUrl = asset('assets/images/point/2.png');
                            break;
                            case 3:
                              $scoreUrl = asset('assets/images/point/3.png');
                            break;
                            case 4:
                              $scoreUrl = asset('assets/images/point/4.png');
                            break;
                            case 5:
                              $scoreUrl = asset('assets/images/point/5.png');
                            break;
                            default:
                              $scoreUrl = "";
                            break;
                          }
                        @endphp
                        <img style="width:45px;height:45px;padding:5px" src="{{$scoreUrl}}" alt="">
                  <!-- <p class="text-muted mb-0">{{$data->training_module_group}}</p> -->
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-5">
                  <p class="mb-0">Notes For Result</p>
                </div>
                <div class="col-sm-7">
                  <p class="text-muted mb-0">{!!$data->notes_for_result!!}</p>
                </div>
              </div>
                </div>
              </div>
            </div>
          </div>
        </div>              
      </div>
  </div>
</section>














<!-- <div class="container">
  <div class="row gutters">
  <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pl-0">
    <div class="card h-100">
      <div class="card-body">
        <div class="account-settings">
          <div class="user-profile">
            <div class="user-avatar">
          <img src="{{ asset('assets/images/tpm.png') }}" style="height: 180px;width:180px;" class="rounded-circle img-thumbnail m-auto" />
            </div>
            <h5 class="user-name"></h5>
            <h6 class="user-email"></h6>
          </div>
        </div>
        <div class="text-primary mb-3">
          {{-- <h5 class="text-center">Curriculum Finish</h5> --}}
        </div>
        <div class="row">
          <div class="col-12">
              <div class="row mb-0">
                  <label class="col-sm-3 col-form-label">No</label>
                  <div class="col-sm-9 m-auto">
                      <input type="number" value="{{$data->no_taging}}" class="form-control form-control-sm" placeholder="0" disabled>
                  </div>
              </div>
              <div class="row mb-0">
                  <label class="col-sm-3 col-form-label">Year</label>
                  <div class="col-sm-9 m-auto">
                      <input type="text" value="{{$data->year}}" class="form-control form-control-sm"  placeholder="0" disabled>
                  </div>
              </div>
              <div class="row mb-0">
                  <label class="col-sm-3 col-form-label">Period</label>
                  <div class="col-sm-9 m-auto">
                      <input type="text" value="{{$data->period}}" class="form-control form-control-sm"  placeholder="0" disabled>
                  </div>
              </div>
            {{-- <h5 class="user-name"></h5> --}}
          </div>
        </div>
      </div>
      </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8">
      <div class="card h-100">
        <div class="card-body">
          <div class="row gutters mb-3">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <h6 class="mb-2 text-primary">Data Personal</h6>
            </div>
            <div class="col-12">
                <div class="row mb-0">
                    <label class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9 m-auto">
                        <input type="text" value="{{$data->name}}" class="form-control form-control-sm"  placeholder="0" disabled>
                    </div>
                </div>
                <div class="row mb-0">
                    <label class="col-sm-3 col-form-label">Circle Group</label>
                    <div class="col-sm-9 m-auto">
                        <input type="text" value="{{$data->training_module_group}}" class="form-control form-control-sm"  placeholder="0" disabled>
                    </div>
                </div>
                <div class="row mb-0">
                    <label class="col-sm-3 col-form-label">Compentency</label>
                    <div class="col-sm-9 m-auto">
                        <input type="text" value="{{$data->training_module}}" class="form-control form-control-sm"  placeholder="0" disabled>
                    </div>
                </div>
            </div>
          </div>
          <div class="row gutters mb-3">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-12">
              <div class="col-sm-12 rounded border d-flex p-1 mb-2">
                <label class="col-form-label pl-2 mr-5">Existing</label>
                <div>
                    @php
                        switch($data->actual){
                          case 0:
                            $existingUrl = asset('assets/images/point/0.png');
                          break;
                          case 1:
                            $existingUrl = asset('assets/images/point/1.png');
                          break;
                          case 2:
                            $existingUrl = asset('assets/images/point/2.png');
                          break;
                          case 3:
                            $existingUrl = asset('assets/images/point/3.png');
                          break;
                          case 4:
                            $existingUrl = asset('assets/images/point/4.png');
                          break;
                          case 5:
                            $existingUrl = asset('assets/images/point/5.png');
                          break;
                          default:
                            $existingUrl = "";
                          break;
                        }
                    @endphp
                    <img style="max-width:60px;height:50px;padding:5px" src="{{$existingUrl}}">
                </div>
              </div>
              <div class="col-sm-12 rounded border p-1 mb-2 d-flex">
                <label class="col-form-label pl-2 mr-5">Target</label>
                <div>
                  @php
                    switch($data->target){
                      case 0:
                        $targetUrl = asset('assets/images/point/0.png');
                      break;
                      case 1:
                        $targetUrl = asset('assets/images/point/1.png');
                      break;
                      case 2:
                        $targetUrl = asset('assets/images/point/2.png');
                      break;
                      case 3:
                        $targetUrl = asset('assets/images/point/3.png');
                      break;
                      case 4:
                        $targetUrl = asset('assets/images/point/4.png');
                      break;
                      case 5:
                        $targetUrl = asset('assets/images/point/5.png');
                      break;
                      default:
                        $targetUrl = "";
                      break;
                    }
                  @endphp
                    <img style="max-width:60px;height:50px;padding:5px" src="{{$targetUrl}}">
                </div>
            </div>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-12">
              <div class="col-sm-12 rounded border p-1 mb-2 d-flex">
                <label class="col-sm-5 col-form-label">Date Open</label>
                <div class="col-sm-7 m-auto">
                    <input type="text" value="{{$data->date_open}}" class="form-control form-control-sm"  placeholder="0" disabled>
                </div>
              </div>
              <div class="col-sm-12 rounded border p-1 mb-2 d-flex">
                <label class="col-sm-5 col-form-label">Due Date</label>
                <div class="col-sm-7 m-auto">
                    <input type="text" value="{{$data->due_date}}" class="form-control form-control-sm"  placeholder="0" disabled>
                </div>
            </div>
            </div>
          </div>
          <div class="row gutters">
              <div class="col-12">
                  <div class="row mb-0">
                      <label class="col-sm-3 col-form-label">Learning Method</label>
                      <div class="col-sm-9 m-auto">
                          <input type="text" value="{{$data->learning_method}}" class="form-control form-control-sm"  placeholder="0" disabled>
                      </div>
                  </div>
                  <div class="row mb-0">
                      <label class="col-sm-3 col-form-label">Trainer</label>
                      <div class="col-sm-9 m-auto">
                          <input type="text" value="{{$data->trainer}}" class="form-control form-control-sm"  placeholder="0" disabled>
                      </div>
                  </div>
                  <div class="row mb-0">
                      <label class="col-sm-3 col-form-label">Date Plan Implementation</label>
                      <div class="col-sm-9 m-auto">
                          <input type="text" value="{{$data->date_plan_implementation}}" class="form-control form-control-sm"  placeholder="0" disabled>
                      </div>
                  </div>
                  <div class="row mb-0">
                      <label class="col-sm-3 col-form-label">Notes Learning Implementation</label>
                      <div class="col-sm-9 m-auto">
                        <textarea class="form-control form-control-sm" rows="5" disabled>{!!$data->notes_learning_implementation!!}</textarea>
                      </div>
                  </div>
                  <div class="row mb-0">
                      <label class="col-sm-3 col-form-label">Date Closed</label>
                      <div class="col-sm-9 m-auto">
                          <input type="text" value="{{$data->date_closed}}" class="form-control form-control-sm"  placeholder="0" disabled>
                      </div>
                  </div>
                  <div class="row mb-0">
                      <label class="col-sm-3 col-form-label">Training Hours</label>
                      <div class="col-sm-4 m-auto">
                          <input type="text" value="{{$data->start}}" class="form-control form-control-sm"  placeholder="0" disabled>
                      </div>
                      <div class="col-sm-1 m-auto px-0 text-center">
                          -
                      </div>
                      <div class="col-sm-4 m-auto">
                          <input type="text" value="{{$data->finish}}" class="form-control form-control-sm"  placeholder="0" disabled>
                      </div>
                  </div>
              </div>
          </div>
          <div class="row gutters">
            <div class="col-sm-12">
                <div class="row mb-0">
                    <label class="col-sm-3 col-form-label">Date Verified</label>
                    <div class="col-sm-9 m-auto">
                        <input type="text" value="{{$data->date_verified}}" class="form-control form-control-sm"  placeholder="0" disabled>
                    </div>
                </div>
                <div class="row mb-0">
                    <label class="col-sm-3 col-form-label">Verified By</label>
                    <div class="col-sm-9 m-auto">
                        <input type="text" value="{{$data->verified_by}}" class="form-control form-control-sm"  placeholder="0" disabled>
                    </div>
                </div>
                <div class="row mb-0">
                    <label class="col-sm-3 col-form-label">Result Score</label>
                    <div class="col-md-9">
                      @php
                        switch($data->result_score){
                          case 0:
                            $scoreUrl = asset('assets/images/point/0.png');
                          break;
                          case 1:
                            $scoreUrl = asset('assets/images/point/1.png');
                          break;
                          case 2:
                            $scoreUrl = asset('assets/images/point/2.png');
                          break;
                          case 3:
                            $scoreUrl = asset('assets/images/point/3.png');
                          break;
                          case 4:
                            $scoreUrl = asset('assets/images/point/4.png');
                          break;
                          case 5:
                            $scoreUrl = asset('assets/images/point/5.png');
                          break;
                          default:
                            $scoreUrl = "";
                          break;
                        }
                      @endphp
                        <img style="width:45px;height:45px;padding:5px" src="{{$scoreUrl}}" alt="">
                    </div>
                </div>
                <div class="row mb-0">
                    <label class="col-sm-3 col-form-label">Notes For Result</label>
                    <div class="col-sm-9 m-auto">
                        <textarea class="form-control form-control-sm" rows="5" disabled>{!!$data->notes_for_result!!}</textarea>
                    </div>
                </div>
            </div>
          </div> 
        </div>
      </div>
    </div>
    
  </div>
</div> -->

