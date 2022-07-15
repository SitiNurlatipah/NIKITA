/* MIT License */
/* Copyright (c) 2019 Maykheld (http://www.maykheld.com) */
jQuery.fn.extend({
    WAFloatBox: function () {
        var a = $(this)
        a.prepend(`
        <a href="#" class="myk-btn" data-toggle="tooltip" data-placement="right" title="Hubungi kami jika butuh bantuan">
        <img src="assets/images/wa-icon.png" class="myk-wa-icon">
        </a>

        <div class="myk-panel"></div>
        `)


        var b = $(".myk-panel")
        b.append(`
        <div class="myk-panelhead">
            <span class="myk-close">x</span>
                <img src="assets/images/wa-icon.png" class="myk-wa-icon" width="30px">
            <h2 class="myk-paneltitle">Questions? </h2>
        </div>
        <div class="myk-panelbody"></div>
        `)

        $('.myk-item').each(function(){
        //this wrapped in jQuery will give us the current .letter-q div
        $('.myk-panelbody').append(`
        <a target='_blank' href="https://wa.me/${$(this).data('wanumber')}?text=Selamat%20Siang%20Bu/Pak%20${$(this).data('waname')}" class="myk-list">
            <img src="${$(this).data('waava')}" class="myk-ava">
            <div class="myk-number">
                <p class="myk-who"><b>${$(this).data('wadivision')}</b></p>
                <p class="myk-name">${$(this).data('waname')}</p>
            </div>
        </a>
        `)


    });

    // trigger 
    $(".myk-btn").click(function(){
    $(".myk-panel").toggleClass("myk-show");
    });
    $(".myk-close").click(function(){
    $(".myk-panel").toggleClass("myk-show");
    });

    }
});



