;
(function ($) {

    var btnMenu = $('#btn-menu'),
        btnSearch = $('#btn-search'),
        menu = $('.header__menu'),
        categories = $('.products__categories'),
        topSearch = $('.top'),
        btnEditSlug = $('.btn-edit-slug'),
        gallery = $('#gallery'),
        infoBox = $('#InfoBox'),
        filters = $(".filtros");

    $('.currency').maskMoney({
        precision: 0
    });
    
    var $purchaseForm = $('.purchase-form');
    var $terms = $purchaseForm.find('.terms-input #terms');

    $terms.on('click', function(e){
        if ($(this).attr('checked')) {

            $(this).attr('checked', false);
        } else {
            $(this).attr('checked', true);
        }

    });

    $('.btn-execute-payment').on('click', function(e){


        if ($terms.is(":checked")) {
            $purchaseForm.submit();
        }else{
            alert('Acepta los termino y condiciones para continuar');
        }
        e.preventDefault();
    });

    $('.alert').delay(4000).fadeOut(300);

    function submitForm(){
        filters.find('form').submit();
    }
    $('#star').change(submitForm);

    var provincias = $('#state'),
        ubicaciones = window.ubicaciones;

    provincias.empty();


    $.each(ubicaciones, function(index,provincia) {
        provincias.append("<option value='"+ provincia.title +"'>" + provincia.title + "</option>");
    });

    $('input[maxlength]').on('keypress', function(e) {
        var maxlength = $(this).attr('maxlength');
        var val = $(this).val();

        if (val.length > maxlength) {
            return false;
        }
    });


    // $('#categories').select2();
   /* $('.inputfile').each( function()
    {
        var $input	 = $( this ),
            $label	 = $input.next( 'label' ),
            labelVal = $label.html();

        $input.on( 'change', function( e )
        {
            var fileName = '';

            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
            else if( e.target.value )
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
                $label.find( 'span' ).html( fileName );
            else
                $label.html( labelVal );
        });

        // Firefox bug fix
        $input
            .on( 'focus', function(){ $input.addClass( 'has-focus' ); })
            .on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
    });*/
    $("#image").on('change', function () {
        imagePreview(this);
    });
    $("#imageGallery").on('change', function (event) {
        var $input	 = $( this ),
            $label	 = $input.next( 'label' ),
            labelVal = 'Agregar imagenes',
            $output = $('#inputs_photos').find('#result');

            $output.html('');
        if(event.target.files.length > 5) {
            $label.find( 'span' ).html( labelVal );
            alert('Solo se permiten 5 imagenes adicionales');
            return false;
        }
        imagePreviewMultiple();

    });
    var $body = $('body');
    $body.on('change', 'input[name="new_photo_file[]"]', function () {
        imagePreview(this)
    });
    function imagePreviewMultiple() {
        //Check File API support
        if (window.File && window.FileList && window.FileReader) {

            var files = event.target.files; //FileList object
            var output = document.getElementById("result");


            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                //Only pics
                if (!file.type.match('image')) continue;

                var picReader = new FileReader();
                picReader.addEventListener("load", function (event) {
                    var picFile = event.target;
                    var div = document.createElement("div");
                    div.innerHTML = "<img class='thumbnail' src='" + picFile.result + "'" + "title='" + picFile.name + "'/>";
                    output.insertBefore(div, null);
                });
                //Read the image
                picReader.readAsDataURL(file);
            }
        } else {
            console.log("Your browser does not support File API");
        }
    }
    function imagePreview($this)
    {
        if (typeof (FileReader) != "undefined") {

            var image_holder = $("#"+ $($this).data('holder') );
            image_holder.empty();

            var reader = new FileReader();
            reader.onload = function (e) {
                $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image"
                }).appendTo(image_holder);

            };
            image_holder.show();
            reader.readAsDataURL($($this)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }
    }
    $body.on('change', '.rootCategories', function () {

        var $this = $(this);
        var containerId = $this.data('container');
        var $result = $this.next('.select__sub-category');
        var $loader = $('.select__category__loader');
        var $message =  $('.select__category__message');
        $loader.show();
        $.get("/api/v1/categories/" + $(this).val() + "/children",
            /* { option: $(this).val() },*/
            function (result) {
                $loader.hide();
                $message.hide();
                var subcategories = $.map(result.data, function (obj, index) {
                    return {
                        category_id: obj.id,
                        category_name: obj.name,
                        category_children: parseInt(obj.children)
                    }
                });
                subcategories['container'] = containerId + 1;

                if (result.data.length) {
                    var html = categorySelectTemplate(subcategories);
                    $result.html(html);

                } else {
                    $this.attr('name', 'categories[]');
                    $this.find('option').removeClass('selected');
                    $this.find('option[value='+ $this.val()+']').addClass('selected');
                    $message.show();
                }


            });
    });
    function categorySelectTemplate(subcategories) {
        var templateHtml = $.trim($('#selectCategoryTemplate').html());
        var template = Handlebars.compile(templateHtml);

        return template(subcategories);

    }

    $('#tags').select2();
    $("#exp_card").mask("99/99", {
        completed: function () {

        }
    });
    btnMenu.on('click', function () {
        menu.toggle();

    });
    btnSearch.on('click', function () {
        if ($(this).hasClass('open')) {
            topSearch.slideDown();
            $(this).removeClass('open');
        }
        else {
            $(this).addClass('open');
            topSearch.slideUp();
        }

    });


    menu.find(".parent").hoverIntent({
        over: function () {
            $(this).find(">.header__submenu").slideDown(200);
        },
        out: function () {
            $(this).find(">.header__submenu").slideUp(200);
        },
        timeout: 200

    });


   /* $body.hoverIntent({
        over: function () {
            $('.products__categories__ul').slideDown(200);
        },
        out: function () {
            $('.products__categories__ul').slideUp(200);
        },
        selector: '.btn-categories',/*'.products__categories.mobile',
        timeout: 200
    });*/
    $('.btn-categories').on('click',function (e) {

        $('.products__categories__ul').slideToggle(200);
    })

    categories.find(".parent").hoverIntent({
        over: function () {
            $(this).find(">.products__categories__submenu").slideDown(200);
        },
        out: function () {
            $(this).find(">.products__categories__submenu").slideUp(200);
        },
        timeout: 200

    });

     $('.notification').hoverIntent({
        over: function () {
            $(this).find(">.notification-list").slideDown(200);
        },
        out: function () {
            $(this).find(">.notification-list").slideUp(200);
        },
        timeout: 200

    });

    var $optionId =  $("input[name='option_id']");
    $optionId.on('click', checkOnlyOne);
    $optionId.on('click', function () {
        if ($(this).attr('value') == 4) {
            $(this).siblings('.option__tags').find('input[type="checkbox"]').attr('disabled', false);

        } else {
            $('.option__tags').find('input[type="checkbox"]').attr('disabled', true).attr('checked', false);

        }
    });
    $("input[name='tags[]']").on('click', checkOnlyOne);
    function checkOnlyOne() {
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

    $("input[name='payment_method']").on('click', function () {

        if ($(this).data('method') === 'paypal') {
            $('#form-payment').prop('action',$(this).data('route'));
            /*$('.payment__method__paypal').slideUp();
            $('.payment__method__card').slideDown();*/
        } else {
            $('#form-payment').prop('action',$(this).data('route'));
            /*$('.payment__method__paypal').slideDown();
            $('.payment__method__card').slideUp();*/
        }
    });

    // SMOOTH ANCHOR SCROLLING
    var $root = $('html, body');
    $('a.anchor').click(function (e) {
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
                }, 500, function () {
                    window.location.hash = anchor;
                });
                e.preventDefault();
            }
        }
    });

    // Forms with ajax process
    $('form[data-remote]').on('submit', function (e) {
        var form = $(this);
        var btn = $('.btn-favorites');
        var method = form.find('input[name="_method"]').val() || 'POST';
        var url = form.prop('action');
        console.log(url);
        form.find('.loader').show();
        btn.addClass('disabled').attr('disabled', true);
        $.ajax({
            type: method,
            url: url,
            data: form.serialize(),
            success: function (resp) {
                var message = form.data('remote-success-message');
                form.find('.loader').hide();
                if (!resp) {

                    $('.alert').removeClass('message-error').addClass('message-success').html(message).fadeIn(300).delay(4500).fadeOut(300);
                }else {
                    $('.alert').removeClass('message-success').addClass('message-error').html('Oops, A ocurrido un error. Intente más tarde.').fadeIn(300).delay(4500).fadeOut(300);
                }
            },
            error: function () {
                form.find('.loader').hide();
                $('.alert').removeClass('message-success').addClass('message-error').html('Oops, A ocurrido un error. Intente más tarde.').fadeIn(300).delay(4500).fadeOut(300);

            }
        });

        limpiaForm(form);

        e.preventDefault();
    });

    $('input[data-confirm], button[data-confirm]').on('click', function (e) {
        var input = $(this);

        input.prop('disabled', 'disabled');

        if (!confirm(input.data('confirm'))) {
            e.preventDefault();

        }
    });
    $("form[data-confirm]").submit(function () {
        if (!confirm($(this).attr("data-confirm"))) {
            return false;
        }
    });

    function limpiaForm(miForm) {

        // recorremos todos los campos que tiene el formulario
        $(":input", miForm).each(function () {
            var type = this.type;
            var tag = this.tagName.toLowerCase();
            //limpiamos los valores de los campos…
            if (type == 'text' || type == 'password' || type == 'email' || tag == 'textarea')
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


    $(window).load(function () {

        resizes();

    });

    $(window).resize(resizes);

    function resizes() {


        if (getWindowWidth() > 640) {

            $(".products__item").each(function (index) {

                if ($(this).find('img').height() < $(this).height()) {
                    $(this).find('img').height($(this).height());
                }
            });

        } else {
            $('.products__item').find('img').height('auto');
        }

        if (getWindowWidth() < 1024) {
            $('.products__categories').addClass('mobile');

        } else {
            $('.products__categories').removeClass('mobile');
        }


    }


    btnEditSlug.on('click', function () {
        $('input[name="slug"]').prop("readOnly", null);
    });

    //gallery

    var photos = 0,
        inputsPhotos = $("#inputs_photos");
    $("#add_input_photo").on('click', function (e) {
        photos++;
        if (photos < 6) {
            inputsPhotos.prepend('<div>' +
            '<input class="inputfile" id="image-'+ photos +'" type="file" name="new_photo_file[]" data-holder="image-holder-'+  photos +'"  />' +
            '<label for="image-'+ photos +'" ><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg><span>Imagen ' + photos + '</span></label>'+
            '<div id="image-holder-'+ photos +'" class="image-holder"></div>');
        }

    });
    function deletePhoto() {
        var btn_delete = $(this),
            url = "/photos/" + btn_delete.attr("data-imagen");

        $.post(url, {_token: $('input[name=_token]').val()}, function (data) {
            btn_delete.parent().fadeOut("slow");
        });
    }

    $("#UploadButton").ajaxUpload({
        url: "/photos",
        name: "file",
        data: {id: $('input[name=product_id]').val(), _token: $('input[name=_token]').val()},
        onSubmit: function () {
            infoBox.html('Uploading ... ');
        },
        onComplete: function (result) {

            infoBox.html('Uploaded succesfull!');

            var photos = jQuery.parseJSON(result);


            fillPhotosInfo(photos);

            gallery.find('li').find('.delete').on('click', deletePhoto);


        }
    });

    gallery.find('li').find('.delete').on('click', deletePhoto);

    function photoTemplate(photo) {

        var templateHtml = $.trim($('#photoTemplate').html());

        var template = Handlebars.compile(templateHtml);

        return template(photo);

    }


    function fillPhotosInfo(jsonData) {
        if (jsonData.error) {
            return onError();
        }

        var html = photoTemplate(jsonData);

        (gallery.length === 0) ? gallery.html(html) : gallery.prepend(html);

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
            opener: function (openerElement) {
                // openerElement is the element on which popup was initialized, in this case its <a> tag
                // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        }
    });
    // This will create a single gallery from all elements that have class "gallery-item"
    $('.product__media__gallery__link').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        },
        mainClass: 'mfp-with-zoom', // this class is for CSS animation below

        zoom: {
            enabled: true, // By default it's false, so don't forget to enable it

            duration: 300, // duration of the effect, in milliseconds
            easing: 'ease-in-out', // CSS transition easing function

            // The "opener" function should return the element from which popup will be zoomed in
            // and to which popup will be scaled down
            // By defailt it looks for an image tag:
            opener: function (openerElement) {
                // openerElement is the element on which popup was initialized, in this case its <a> tag
                // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        }
    });
    gallery.find('a').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        },
        mainClass: 'mfp-with-zoom', // this class is for CSS animation below

        zoom: {
            enabled: true, // By default it's false, so don't forget to enable it

            duration: 300, // duration of the effect, in milliseconds
            easing: 'ease-in-out', // CSS transition easing function

            // The "opener" function should return the element from which popup will be zoomed in
            // and to which popup will be scaled down
            // By defailt it looks for an image tag:
            opener: function (openerElement) {
                // openerElement is the element on which popup was initialized, in this case its <a> tag
                // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                return openerElement.is('img') ? openerElement : openerElement.find('img');
            }
        }
    });


    //review

    var reviewBox = $('#post-review-box');
    var newReview = $('#new-review');
    var openReviewBtn = $('#open-review-box');
    var closeReviewBtn = $('#close-review-box');
    var ratingsField = $('#ratings-hidden');

    newReview.autosize({append: "\n"});

    openReviewBtn.click(function (e) {
        reviewBox.slideDown(400, function () {
            $('#new-review').trigger('autosize.resize');
            newReview.focus();
        });
        openReviewBtn.fadeOut(100);
        closeReviewBtn.show();
    });

    closeReviewBtn.click(function (e) {
        e.preventDefault();
        reviewBox.slideUp(300, function () {
            newReview.focus();
            openReviewBtn.fadeIn(200);
        });
        closeReviewBtn.hide();

    });

    $('.starrr').on('starrr:change', function (e, value) {
        ratingsField.val(value);
    });

    //reply

    var replyBox = $('.post-reply-box');
    var newReply = $('.new-reply');
    var openReplyBtn = $('.open-reply-box');
    var closeReplyBtn = $('.close-reply-box');
   

    newReply.autosize({append: "\n"});

    openReplyBtn.click(function (e) {
        $(this).siblings(".post-reply-box" ).slideDown(400, function () {
            $('.new-reply').trigger('autosize.resize');
            newReply.focus();
        });

        /*replyBox.slideDown(400, function () {
            $('.new-reply').trigger('autosize.resize');
            newReply.focus();
        });*/
        openReplyBtn.fadeOut(100);
        closeReplyBtn.show();
    });

    closeReplyBtn.click(function (e) {
        e.preventDefault();
        replyBox.slideUp(300, function () {
            newReply.focus();
            openReplyBtn.fadeIn(200);
        });
        closeReplyBtn.hide();

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
    var windowHeight = 0;
    if (typeof(window.innerHeight) == 'number') {
        windowHeight = window.innerHeight;
    } else {
        if (document.documentElement && document.documentElement.clientHeight) {
            windowHeight = document.documentElement.clientHeight;
        } else {
            if (document.body && document.body.clientHeight) {
                windowHeight = document.body.clientHeight;
            }
        }
    }
    return windowHeight;
}

function getWindowWidth() {
    var windowWidth = 0;
    if (typeof(window.innerWidth) == 'number') {
        windowWidth = window.innerWidth;
    } else {
        if (document.documentElement && document.documentElement.clientWidth) {
            windowWidth = document.documentElement.clientWidth;
        } else {
            if (document.body && document.body.clientWidth) {
                windowWidth = document.body.clientWidth;
            }
        }
    }
    return windowWidth;
}


