@extends('layouts.master')

@section('title', 'CEME CHAMPION')

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card height-card" >
                <div class="card-body">
                    <h4 class="card-title">CEME</h4>
                    <div class="row">
                        <div class="col-6">
                            <h5>Competent Champion</h4>
                            <canvas id="pieChart"></canvas>
                        </div>
                        <!-- <div class="col-6">
                            <h5>Multiskill Employee</h4>
                            <canvas id="pieChart2"></canvas>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Competent Champion</h4>
                    <span style="font-size: 14px;"><div class="mr-1 mt-1 mb-0 bg-warning" style="display:inline-block; width:15px; height:15px; border-radius: 50%; "></div><i>Indicate as Competent Employee</i></span>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table table table-sm table-striped table-hover mt-1"
                                    id="tblcompetent" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th style="width:10%">Name</th>
                                            <th style="width:10%">NIK</th>
                                            <th style="width:10%">CG</th>
                                            <th style="width:10%">Department</th>
                                            <th>Avr</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    {{-- Modal --}}
    
@endsection
@push('style')
    {{-- <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">
    <style>
        .select2-selection__rendered {
            line-height: 50px !important;
        }

        .select2-container .select2-selection--single {
            height: 48px !important;
        }

    </style>
@endpush
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet"  href="{{asset('assets/css/datatables/jquery.dataTables.min.css') }}" type="text/css"/>
    <link href="{{asset('assets/css/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@push('script')
    <script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{asset('assets/vendors/datatables.net/export-table-data.js')}}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/jszip.min.js') }}" type="text/javascript"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            // initDatatable();
            cemeTable();
            $('[data-toggle="tooltip"]').tooltip({
                animation: true,
                placement: "top",
                trigger: "hover focus"
            });
        });
        function cemeTable() {
            @if(Auth::user()->peran_pengguna == '1')
            var buttons = [
                'copy', 'csv',
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];

                        var count = 0;
                        var skippedHeader = false;
                        $('row c[r^="B"]', sheet).each(function() {
                            if (skippedHeader) {
                                var isWarning = $('tbody tr:eq(' + parseInt(count) + ')').hasClass('bg-warning');
                                if (isWarning) {
                                    $(this).attr('s', '35'); // Ganti dengan indeks gaya yang sesuai dengan warna yang Anda inginkan
                                }
                                count++;
                            } else {
                                skippedHeader = true;
                            }
                        });
                    }
                },'pdf', 'print',
            ];
            @else
            var buttons = [];
            @endif
            var competenJson = $('#tblcompetent').DataTable({
                ajax: "{{ route('champion.competent.json') }}",
                autoWidth: false,
                serverSide: true,
                processing: true,
                aaSorting: [
                    [0, "desc"]
                ],
                searching: true,
                dom: 'lBfrtip',
                buttons: buttons,
                displayLength: -1,
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                language: {
                    paginate: {
                        // remove previous & next text from pagination
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    },
                    // loadingRecords: "Please wait - loading..."
                    processing: "Please wait - loading..."
  
                },
                scrollX: true,
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'nama_pengguna', name: 'nama_pengguna' },
                    { data: 'nik', name: 'nik' },
                    { data: 'nama_job_title', name: 'nama_job_title' },
                    { data: 'nama_department', name: 'nama_department' },
                    { data: 'rata_nilai', name: 'rata_nilai' },
                ],
                createdRow: function (row, data, dataIndex) {
                    if (data.rata_nilai.indexOf('badge-warning') !== -1) {
                        $(row).addClass('bg-warning');
                    }
                },
            })
        }
        

        
        // chart
        let multiSkill;
        let pieLabel;
        let pieTotalScore;
        let ceme = '{{ request('q') }}';
        $.ajax({
            url:'{{ route('champion.ceme.chartCeme') }}',
            type:'POST',
            dataType:'JSON',
            data:{
                ceme
            },
            async:false,
            success: function(response)
            {
                pieLabel = response.label;
                pieTotalScore = response.totalScore;
            }
        })
        $.ajax({
            url:'{{ route('superman.ceme.chartMe') }}',
            type:'POST',
            dataType:'JSON',
            data:{
                ceme
            },
            async:false,
            success: function(response)
            {
                multiSkill = response;
            }
        })

        var nameMultiSkill = [];
        var totalMultiSkill = [];
        var bgMultiSkill = [];
        var bMultiSkill = [];
        var bgCeme = [];
        var bCeme = [];

        function acakBg(opacity)
        {
            var rx = Math.floor(Math.random() * 256);
            var ry = Math.floor(Math.random() * 256);
            var rz = Math.floor(Math.random() * 256);
            return bgColor = "rgba(" + rx + "," + ry + "," + rz + ","+opacity+")";
        }

        multiSkill.forEach(multi => {
            nameMultiSkill.push(multi.nama_pengguna);
            totalMultiSkill.push(multi.totalSkill);
            bgMultiSkill.push(acakBg(0.5));
            bMultiSkill.push(acakBg(0.7));
        });

        pieLabel.forEach(multi => {
            bgCeme.push(acakBg(0.5));
            bCeme.push(acakBg(0.7));
        });
        var meData = {
                datasets: [{
                data: totalMultiSkill,
                backgroundColor: bgMultiSkill,
                borderColor: '#ffffff',
                }],

                labels: nameMultiSkill
            };

            var doughnutPieData = {
                datasets: [{
                data: pieTotalScore,
                backgroundColor: bgCeme,
                borderColor: '#ffffff',
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: pieLabel
            };
            var doughnutPieOptions = {
                responsive: true,
                animation: {
                animateScale: true,
                animateRotate: true
                }
            };

        if ($("#pieChart").length) {
            var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
            var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: doughnutPieData,
            options: doughnutPieOptions
            });
        }

        if ($("#pieChart2").length) {
            var pieChartCanvas = $("#pieChart2").get(0).getContext("2d");
            var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: meData,
            options: doughnutPieOptions
            });
        }
        
    </script>
@endpush
