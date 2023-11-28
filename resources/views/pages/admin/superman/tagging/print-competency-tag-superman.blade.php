<!DOCTYPE html>
<html lang="en">
<head>
  @include('include.style')
</head>
<style>
  @page {
    size: auto;
    margin-top: 0;
    margin-bottom: 0;
    margin-left: auto;
    margin-right: auto;
  }
  @media print {
    body {
      margin-top: 2cm;
    }
  }
  .input{
    width: 100%;
    align-content: center;
    background-color: #e9ecef;
    margin: auto;
    border: 2px solid #CED4DA;
    -moz-border: 2px solid #CED4DA;
    -webkit-border: 2px solid #CED4DA;
    border-radius: 4px;
    font-size: 0.874rem;
    font-weight: 400;
    line-height: 1.7;
    padding: 0.5rem 0.81rem;
    height: 2.575rem;
    vertical-align: center
  }
  
  .border{

  }
</style>
<body onload="window.print()">
{{-- <body> --}}
  <div class="container">
    <h4 class="text-center">Competency Tag</h4>
    <hr>
    <div class="row">
      <div class="col-12">
        <div class="row p-3">
          <div class="col-3 d-flex">
            <img src="{{ asset('assets/images/tpm.png') }}" alt="Logo TPM" class="m-auto img-thumbnail">
          </div>
          <div class="col-9">
            <div class="row mb-0">
              <label class="col-3 col-form-label">No</label>
              <div class="col-9 m-auto">
                <div class="input">
                  {{$data->no_taging}}
                </div>
              </div>
            </div>
            <div class="row mb-0">
              <label class="col-3 col-form-label">Year</label>
              <div class="col-9 m-auto">
                <div class="input">
                  {{$data->year}}
                </div>
              </div>
            </div>
            <div class="row mb-0">
              <label class="col-3 col-form-label">Period</label>
              <div class="col-9 m-auto">
                <div class="input">
                  {{$data->period}}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row p-3">
          <div class="col-12">
            <div class="row mb-0">
              <label class="col-3 col-form-label">Name</label>
              <div class="col-9 m-auto">
                <div class="input">
                  {{$data->name}}
                </div>
              </div>
            </div>
            <div class="row mb-0">
              <label class="col-3 col-form-label">Circle Group</label>
              <div class="col-9 m-auto">
                <div class="input">
                  {{$data->training_module_group}}
                </div>
              </div>
            </div>
            <div class="row mb-0">
              <label class="col-3 col-form-label">Compentency</label>
              <div class="col-9 m-auto">
                <div class="input">
                  {{$data->training_module}}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row px-3 mb-3">
          <div class="col-12">
            <div class="col-12" style="border: 2px solid #000;border-radius:8px;padding:14px">
              <div class="row">
                <div class="col-6">
                  <div class="my-2">
                    <div class="col-12 d-flex p-1" style="border: 2px solid #000;border-radius:8px">
                      <label class="col-11 col-form-label">Existing</label>
                      <div class="col-1 px-0">
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
                          <img class="img-thumbnail" style="width: 46px;height:46px" src="{{$existingUrl}}" alt="">
                      </div>
                    </div>
                  </div>
                  <div class="my-2">
                    <div class="col-12 p-1 d-flex" style="border: 2px solid #000;border-radius:8px">
                      <label class="col-11 col-form-label">Target</label>
                      <div class="col-1 px-0">
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
                          <img class="img-thumbnail" style="width: 46px;height:46px" src="{{$targetUrl}}" alt="">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-6">
                  <div class="my-2">
                    <div class="col-12 p-1 d-flex" style="border: 2px solid #000;border-radius:8px">
                      <label class="col-5 col-form-label">Date Open</label>
                      <div class="col-7 m-auto">
                        <div class="input">
                          {{$data->date_open}}
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="my-2">
                    <div class="col-12 p-1 d-flex" style="border: 2px solid #000;border-radius:8px">
                      <label class="col-5 col-form-label">Due Date</label>
                      <div class="col-7 m-auto">
                        <div class="input">
                          {{$data->due_date}}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row px-3">
          <div class="col-12">
            <div class="col-12" style="border: 2px solid #000;border-radius:8px;padding:14px">
              <div class="row mb-0 mx-2 d-flex">
                  <label class="col-3 col-form-label">Learning Method</label>
                  <div class="col-9 m-auto">
                    <div class="input">
                      {{$data->learning_method}}
                    </div>
                  </div>
              </div>
              <div class="row mb-0 mx-2 d-flex">
                  <label class="col-3 col-form-label">Trainer</label>
                  <div class="col-9 m-auto">
                    <div class="input">
                      {{$data->trainer}}
                    </div>
                  </div>
              </div>
              <div class="row mb-0 mx-2 d-flex">
                  <label class="col-3 col-form-label">Date Plan Implementation</label>
                  <div class="col-9 m-auto">
                    <div class="input">
                      {{$data->date_plan_implementation}}
                    </div>
                  </div>
              </div>
              <div class="row mb-0 mx-2 d-flex">
                  <label class="col-3 col-form-label">Notes Learning Implementation</label>
                  <div class="col-9 m-auto">
                    <div class="input">
                      {!!$data->notes_learning_implementation!!}
                    </div>
                  </div>
              </div>
              <div class="row mb-0 mx-2 d-flex">
                  <label class="col-3 col-form-label">Date Closed</label>
                  <div class="col-9 m-auto">
                    <div class="input">
                      {{$data->date_closed}}
                    </div>
                  </div>
              </div>
              <div class="row mb-0 mx-2 d-flex">
                  <label class="col-3 col-form-label">Training Hours</label>
                  <div class="col-4 m-auto">
                    <div class="input">
                      {{$data->start}}
                    </div>
                  </div>
                  <div class="col-1 m-auto px-0 text-center">
                      -
                  </div>
                  <div class="col-4 m-auto">
                    <div class="input">
                      {{$data->finish}}
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row p-3">
          <div class="col-12">
              <div class="row mb-0">
                  <label class="col-3 col-form-label">Date Verified</label>
                  <div class="col-9 m-auto">
                    <div class="input">
                      {{$data->date_verified}}
                    </div>
                  </div>
              </div>
              <div class="row mb-0">
                  <label class="col-3 col-form-label">Verified By</label>
                  <div class="col-9 m-auto">
                    <div class="input">
                      {{$data->verified_by}}
                    </div>
                  </div>
              </div>
              <div class="row mb-0">
                  <label class="col-3 col-form-label">Result Score</label>
                  <div class="col-9">
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
                      <img class="img-thumbnail" style="width:45px;height:45px" src="{{$scoreUrl}}" alt="">
                  </div>
              </div>
              <div class="row mb-0">
                  <label class="col-3 col-form-label">Notes For Result</label>
                  <div class="col-9 m-auto">
                    <div class="input">
                      {!!$data->notes_for_result!!}
                    </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>