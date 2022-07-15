@push('style')
    <style>
        .bs-tooltip-auto[x-placement^=right] .arrow::before,
        .bs-tooltip-right .arrow::before {
            border-right-color: #f00; /* Red */
        }
    </style>
@endpush
<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2022. Premium <a href="https://www.soultechonoly88.blogspot.com/" target="_blank">Human Capital</a> PT Kalbe Morinaga Indonesia. All rights reserved.</span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
    </div>
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Build by <a href="https://www.soultechonoly88.blogspot.com/" target="_blank">Rezzz</a></span>
    </div>
    <div class="myk-wa">
        <div class="myk-item" data-wanumber="6281224015960" data-waname="Setyo Dewi Utari" data-wadivision="HRD SPV" data-waava="{{ asset('assets/images/faces/sdu.jpg') }}"></div>
        <div class="myk-item" data-wanumber="6283817260288" data-waname="Rezki Ramadhan" data-wadivision="Admin Technical" data-waava="{{ asset('assets/images/faces/rra.jpg') }}"></div>
        <!-- few more whatsapp accounts -->
    </div>
</footer>

<script src="{{ asset('assets/wa-floating/js/wafloatbox-0.2.js') }}"></script>
<script>
$(document).ready(function(){
    $(".myk-wa").WAFloatBox();

    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
})
});
</script>