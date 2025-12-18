@extends('layouts.app_admin2')
@section('title')
SIMAK - Input Mahasiswa
@endsection
@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
  <li class="breadcrumb-item"><a href="{{ route('mahasiswa.index') }}">Master Mahasiswa</a></li>
  <li class="breadcrumb-item active">Input Mahasiswa</li>
@endsection

@section('css')
<link href="{{asset('/assets/plugins/wizard/steps.css')}}" rel="stylesheet">

<link href="{{asset('/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">
@endsection

@section('content')
<!-- Validation wizard -->
<div class="row" id="validation">
    <div class="col-12">
        <div class="card wizard-content">
            <div class="card-body">
                <h4 class="card-title">Input Data Mahasiswa Baru</h4>
                <h6 class="card-subtitle">Masukkan data mahasiswa dengan baik dan benar sesuai dengan format</h6>
                <form action="{{ route('mahasiswa.store') }}" class="validation-wizard wizard-circle floating-labels">
                    @csrf
                    <!-- Step 1 -->
                    <h6>Data Pribadi</h6>
                    <section>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group m-t-20">
                          
                                    <input type="text" class="form-control" id="nik" name="nik" required="" >
                                    <span class="bar"></span>
                                    <label for="" class="control-label">NIK</label>
                                      
                                  </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-t-20">
                  
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required="" >
                                    <span class="bar"></span>
                                    <label for="" class="control-label">Nama Lengkap</label>
                                  
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group m-t-20 focus">
                  
                                
                                        <input type="text" class="form-control" 
                                        id="mdate">
                                        <span class="bar"></span>
                                        <label for="" class="control-label">Tanggal Lahir</label>
                                  
                              </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wphoneNumber2">Phone Number :</label>
                                    <input type="tel" class="form-control" id="wphoneNumber2"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wlocation2"> Select City : <span class="danger">*</span> </label>
                                    <select class="custom-select form-control required" id="wlocation2" name="location">
                                        <option value="">Select City</option>
                                        <option value="India">India</option>
                                        <option value="USA">USA</option>
                                        <option value="Dubai">Dubai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wdate2">Date of Birth :</label>
                                    <input type="date" class="form-control" id="wdate2"> </div>
                            </div>
                        </div>
                    </section>
                    <!-- Step 2 -->
                    <h6>Data Studi</h6>
                    <section>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jobTitle2">Company Name :</label>
                                    <input type="text" class="form-control required" id="jobTitle2">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="webUrl3">Company URL :</label>
                                    <input type="url" class="form-control required" id="webUrl3" name="webUrl3"> </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="shortDescription3">Short Description :</label>
                                    <textarea name="shortDescription" id="shortDescription3" rows="6" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Step 3 -->
                    <h6>Data Tempat Tinggal</h6>
                    <section>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wint1">Interview For :</label>
                                    <input type="text" class="form-control required" id="wint1"> </div>
                                <div class="form-group">
                                    <label for="wintType1">Interview Type :</label>
                                    <select class="custom-select form-control required" id="wintType1" data-placeholder="Type to search cities" name="wintType1">
                                        <option value="Banquet">Normal</option>
                                        <option value="Fund Raiser">Difficult</option>
                                        <option value="Dinner Party">Hard</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="wLocation1">Location :</label>
                                    <select class="custom-select form-control required" id="wLocation1" name="wlocation">
                                        <option value="">Select City</option>
                                        <option value="India">India</option>
                                        <option value="USA">USA</option>
                                        <option value="Dubai">Dubai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wjobTitle2">Interview Date :</label>
                                    <input type="date" class="form-control required" id="wjobTitle2">
                                </div>
                                <div class="form-group">
                                    <label>Requirements :</label>
                                    <div class="m-b-10">
                                        <label class="custom-control custom-radio">
                                            <input id="radio3" name="radio" type="radio" class="custom-control-input">
                                            <span class="custom-control-label">Employee</span>
                                        </label>
                                        <label class="custom-control custom-radio">
                                            <input id="radio4" name="radio" type="radio" class="custom-control-input">
                                            <span class="custom-control-label">Contract</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Step 4 -->
                    <h6>Data Keluarga</h6>
                    <section>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="behName1">Behaviour :</label>
                                    <input type="text" class="form-control required" id="behName1">
                                </div>
                                <div class="form-group">
                                    <label for="participants1">Confidance</label>
                                    <input type="text" class="form-control required" id="participants1">
                                </div>
                                <div class="form-group">
                                    <label for="participants1">Result</label>
                                    <select class="custom-select form-control required" id="participants1" name="location">
                                        <option value="">Select Result</option>
                                        <option value="Selected">Selected</option>
                                        <option value="Rejected">Rejected</option>
                                        <option value="Call Second-time">Call Second-time</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="decisions1">Comments</label>
                                    <textarea name="decisions" id="decisions1" rows="4" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Rate Interviwer :</label>
                                    <div class="c-inputs-stacked">
                                        <label class="inline custom-control custom-checkbox block">
                                            <input type="checkbox" class="custom-control-input"><span class="custom-control-label ml-0">1 star</span> </label>
                                        <label class="inline custom-control custom-checkbox block">
                                            <input type="checkbox" class="custom-control-input"><span class="custom-control-label ml-0">2 star</span> </label>
                                        <label class="inline custom-control custom-checkbox block">
                                            <input type="checkbox" class="custom-control-input"><span class="custom-control-label ml-0">3 star</span> </label>
                                        <label class="inline custom-control custom-checkbox block">
                                            <input type="checkbox" class="custom-control-input"><span class="custom-control-label ml-0">4 star</span> </label>
                                        <label class="inline custom-control custom-checkbox block">
                                            <input type="checkbox" class="custom-control-input"><span class="custom-control-label ml-0">5 star</span> </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- vertical wizard -->
@endsection

@section('js')
<script src="{{asset('/assets/plugins/moment/min/moment.min.js')}}"></script>
<script src="{{asset('/assets/plugins/wizard/jquery.steps.min.js')}}"></script>
<script src="{{asset('/assets/plugins/wizard/jquery.validate.min.js')}}"></script>
<script src="{{asset('/assets/plugins/wizard/steps.js')}}"></script>
<script src="{{asset('/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script type="text/javascript">
    $('#mdate').bootstrapMaterialDatePicker({ weekStart: 0, time: false });
</script>
@endsection