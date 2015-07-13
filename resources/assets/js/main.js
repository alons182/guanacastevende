;(function($){

    var btnMenu = $('#btn-menu'),
        btnSearch = $('#btn-search'),
        menu = $('.header__menu'),
        categories = $('.products__categories'),
        topSearch = $('.top'),
        btnEditSlug = $('.btn-edit-slug'),
        gallery = $('#gallery'),
        infoBox = $('#InfoBox');

    $('.alert').delay(3000).fadeOut(300);
    $('#categories').select2();
    $('#tags').select2();
    btnMenu.on('click', function(){
        menu.toggle();

    });
    btnSearch.on('click', function(){
        if($(this).hasClass('open')) {
            topSearch.slideDown();
            $(this).removeClass('open');
        }
        else {
            $(this).addClass('open');
            topSearch.slideUp();
        }

    });

    menu.find(".parent").hoverIntent({
        over: function() {
            $(this).find(">.header__submenu").slideDown(200 );
        },
        out:  function() {
            $(this).find(">.header__submenu").slideUp(200);
        },
        timeout: 200

    });
    categories.find(".parent").hoverIntent({
        over: function() {
            $(this).find(">.products__categories__submenu").slideDown(200 );
        },
        out:  function() {
            $(this).find(">.products__categories__submenu").slideUp(200);
        },
        timeout: 200

    });


    $("input[name='option_id']").on('click', checkOnlyOne);
    $("input[name='tags[]']").on('click', checkOnlyOne);
    function checkOnlyOne()
    {
        // in the handler, 'this' refers to the box clicked on
        var $box = $(this);
        if ($box.is(":checked")) {
            // the name of the box is retrieved using the .attr() method
            // as it is assumed and expected to be immutable
            var group = "input:checkbox[name='" + $box.attr("name") + "']";
            // the checked state of the group/box on the other hand will change
            // and the current value is retrieved using .prop() method
            $(group).prop("checked", false);
            $box.prop("checked", true);
        } else {
            $box.prop("checked", false);
        }
    }

    $("input[name='payment_method']").on('click', function(){

        if($(this).data('method')=== 'card')
        {
            $('.payment__method__paypal').slideUp();
            $('.payment__method__card').slideDown();
        }else{
            $('.payment__method__paypal').slideDown();
            $('.payment__method__card').slideUp();
        }
    });

    // SMOOTH ANCHOR SCROLLING
    var $root = $('html, body');
    $('a.anchor').click(function(e) {
        var href = $.attr(this, 'href');
        if (typeof($(href)) != 'undefined' && $(href).length > 0) {
            var anchor = '';

            if (href.indexOf("#") != -1) {
                anchor = href.substring(href.lastIndexOf("#"));
            }

            if (anchor.length > 0) {
                console.log($(anchor).offset().top);
                console.log(anchor);
                $root.animate({
                    scrollTop: $(anchor).offset().top
                }, 500, function() {
                    window.location.hash = anchor;
                });
                e.preventDefault();
            }
        }
    });

    // Forms with ajax process
    $('form[data-remote]').on('submit', function(e){
        var form =$(this);
        var method = form.find('input[name="_method"]').val() || 'POST';
        var url = form.prop('action');
        form.find('.loader').show();
        $.ajax({
            type: method,
            url: url,
            data: form.serialize(),
            success: function(){
                var message = form.data('remote-success-message');
                form.find('.loader').hide();
                if(message)
                {

                    $('.response').removeClass('message-error').addClass('message-success').html(message).fadeIn(300).delay(4500).fadeOut(300);
                }
            },
            error:function(){
                form.find('.loader').hide();
                $('.response').removeClass('message-success').addClass('message-error').html('Whoops, looks like something went wrong.').fadeIn(300).delay(4500).fadeOut(300);

            }
        });

        limpiaForm(form);

        e.preventDefault();
    });

    $('input[data-confirm], button[data-confirm]').on('click', function(e){
        var input = $(this);

        input.prop('disabled','disabled');

        if(! confirm(input.data('confirm'))){
            e.preventDefault();
        }
    });

    function limpiaForm(miForm) {

        // recorremos todos los campos que tiene el formulario
        $(":input", miForm).each(function() {
            var type = this.type;
            var tag = this.tagName.toLowerCase();
            //limpiamos los valores de los campos…
            if (type == 'text' || type == 'password'  || type == 'email' || tag == 'textarea')
                this.value = "";
            // excepto de los checkboxes y radios, le quitamos el checked
            // pero su valor no debe ser cambiado
            else if (type == 'checkbox' || type == 'radio')
                this.checked = false;
            // los selects le ponesmos el indice a -
            else if (tag == 'select')
                this.selectedIndex = -1;
        });
    }


    $(window).load(function() {

        resizes();

     });

     $(window).resize(resizes);

     function resizes()
     {



         if(getWindowWidth() > 640){

             $( ".products__item" ).each(function( index ) {

                 if($( this ).find('img').height() < $( this ).height())
                 {
                     $( this ).find('img').height($( this ).height());
                 }
             });



        }else{
             $('.products__item').find('img').height('auto');
         }



         }


    btnEditSlug.on('click',function(){
        $('input[name="slug"]').prop( "readOnly", null );
    });

    //gallery
    var photos = 0,
        inputsPhotos = $("#inputs_photos");
    $("#add_input_photo").on('click', function (e) {
        photos++;

        inputsPhotos.append('<div><strong>Foto' + photos + ': </strong>'+
        '<input type="file" name="new_photo_file[]" size="45" /></div><br />');

    });
    function deletePhoto()
    {
        var btn_delete = $(this),
            url = "/photos/" + btn_delete.attr("data-imagen");

        $.post(url,{_token: $('input[name=_token]').val()}, function(data){
            btn_delete.parent().fadeOut("slow");
        });
    }

    $("#UploadButton").ajaxUpload({
        url : "/photos",
        name: "file",
        data: {id: $('input[name=product_id]').val(), _token: $('input[name=_token]').val() },
        onSubmit: function() {
            infoBox.html('Uploading ... ');
        },
        onComplete: function(result) {

            infoBox.html('Uploaded succesfull!');

            var photos = jQuery.parseJSON(result);


            fillPhotosInfo(photos);

            gallery.find('li').find('.delete').on('click',deletePhoto);


        }
    });

    gallery.find('li').find('.delete').on('click',deletePhoto);

    function photoTemplate(photo)
    {

        var templateHtml = $.trim( $('#photoTemplate').html() );

        var template = Handlebars.compile( templateHtml );

        return template(photo);

    }


    function fillPhotosInfo(jsonData) {
        if (jsonData.error) {
            return onError();
        }

        var html = photoTemplate(jsonData);

        (gallery.length === 0) ? gallery.html( html ) : gallery.prepend(html);

        gallery.find('li').eq(0).hide().show("slow");

    }


    $('.product__img__link').magnificPopup({
        type: 'image',
        mainClass: 'mfp-with-zoom', // this class is for CSS animation below

        zoom: {
            enabled: true, // By default it's false, so don't forget to enable it

            duration: 300, // duration of the effect, in milliseconds
            easing: 'ease-in-out', // CSS transition easing function

            // The "opener" function should return the element from which popup will be zoomed in
            // and to which popup will be scaled down
            // By defailt it looks for an image tag:
            opener: function(openerElement) {
                // openerElement is the element on which popup was initialized, in this case its <a> tag
                // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        }
    });
    // This will create a single gallery from all elements that have class "gallery-item"
    $('.product__media__gallery__link').magnificPopup({
        type: 'image',
        gallery:{
            enabled:true
        },
        mainClass: 'mfp-with-zoom', // this class is for CSS animation below

        zoom: {
            enabled: true, // By default it's false, so don't forget to enable it

            duration: 300, // duration of the effect, in milliseconds
            easing: 'ease-in-out', // CSS transition easing function

            // The "opener" function should return the element from which popup will be zoomed in
            // and to which popup will be scaled down
            // By defailt it looks for an image tag:
            opener: function(openerElement) {
                // openerElement is the element on which popup was initialized, in this case its <a> tag
                // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        }
    });
    $('#gallery a').magnificPopup({
        type: 'image',
        gallery:{
            enabled:true
        },
        mainClass: 'mfp-with-zoom', // this class is for CSS animation below

        zoom: {
            enabled: true, // By default it's false, so don't forget to enable it

            duration: 300, // duration of the effect, in milliseconds
            easing: 'ease-in-out', // CSS transition easing function

            // The "opener" function should return the element from which popup will be zoomed in
            // and to which popup will be scaled down
            // By defailt it looks for an image tag:
            opener: function(openerElement) {
                // openerElement is the element on which popup was initialized, in this case its <a> tag
                // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        }
    });


    //review
    $('#new-review').autosize({append: "\n"});

    var reviewBox = $('#post-review-box');
    var newReview = $('#new-review');
    var openReviewBtn = $('#open-review-box');
    var closeReviewBtn = $('#close-review-box');
    var ratingsField = $('#ratings-hidden');

    openReviewBtn.click(function(e)
    {
        reviewBox.slideDown(400, function()
        {
            $('#new-review').trigger('autosize.resize');
            newReview.focus();
        });
        openReviewBtn.fadeOut(100);
        closeReviewBtn.show();
    });

    closeReviewBtn.click(function(e)
    {
        e.preventDefault();
        reviewBox.slideUp(300, function()
        {
            newReview.focus();
            openReviewBtn.fadeIn(200);
        });
        closeReviewBtn.hide();

    });

    $('.starrr').on('starrr:change', function(e, value){
        ratingsField.val(value);
    });




})(jQuery);

function getScrollerWidth() {
    var scr = null;
    var inn = null;
    var wNoScroll = 0;
    var wScroll = 0;

    // Outer scrolling div
    scr = document.createElement('div');
    scr.style.position = 'absolute';
    scr.style.top = '-1000px';
    scr.style.left = '-1000px';
    scr.style.width = '100px';
    scr.style.height = '50px';
    // Start with no scrollbar
    scr.style.overflow = 'hidden';

    // Inner content div
    inn = document.createElement('div');
    inn.style.width = '100%';
    inn.style.height = '200px';

    // Put the inner div in the scrolling div
    scr.appendChild(inn);
    // Append the scrolling div to the doc
    document.body.appendChild(scr);

    // Width of the inner div sans scrollbar
    wNoScroll = inn.offsetWidth;
    // Add the scrollbar
    scr.style.overflow = 'auto';
    // Width of the inner div width scrollbar
    wScroll = inn.offsetWidth;

    // Remove the scrolling div from the doc
    document.body.removeChild(
        document.body.lastChild);

    // Pixel width of the scroller
    return (wNoScroll - wScroll);
}

function getWindowHeight() {
    var windowHeight=0;
    if (typeof(window.innerHeight)=='number') {
        windowHeight=window.innerHeight;
    } else {
        if (document.documentElement && document.documentElement.clientHeight) {
            windowHeight = document.documentElement.clientHeight;
        } else {
            if (document.body && document.body.clientHeight) {
                windowHeight=document.body.clientHeight;
            }
        }
    }
    return windowHeight;
}

function getWindowWidth() {
    var windowWidth=0;
    if (typeof(window.innerWidth)=='number') {
        windowWidth=window.innerWidth;
    } else {
        if (document.documentElement && document.documentElement.clientWidth) {
            windowWidth = document.documentElement.clientWidth;
        } else {
            if (document.body && document.body.clientWidth) {
                windowWidth=document.body.clientWidth;
            }
        }
    }
    return windowWidth;
}


