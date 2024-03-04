jQuery(document).ready(function($) {
    $('#galleryImages').on('change',function(){
        if($(this).val()!==''){
            $(this).next('label').html('<span class="text-success">Дабавлено!</span>');
        }else{
            $(this).next('label').html('Другие фотографии');
        }
    })
    
    $('#featuredImage').on('change',function(){
        if($(this).val()!==''){
            $(this).next('label').html('<span class="text-success">Дабавлено!</span>');
        }else{
            $(this).next('label').html('Главное изображение');
        }
    })
    
    $('#real_estate_form').submit(function(e) {
        e.preventDefault();
        var requiredFields = ['#title', '#content', '#cities_option', '#area', '#living-area', '#floor', '#price', '#address', '#property_type', '#featuredImage'];
        var isValid = true;
        requiredFields.forEach(function(field) {
            if ($(field).val() == '') {
                $(field).css('box-shadow', '0 0 5px 1px #ff0000');
                isValid = false;
            } else {
                $(field).css('box-shadow', '');
            }
        });

        if (!isValid) {
            $('#response_message').html('<span class="text-danger">Please fill out all required fields.</span>');
            return;
        }

        let postTitle = $('#title').val();
        let content = $('#content').val();
        let city = $('#cities_option').val();
        let area = $('#area').val();
        let livingArea = $('#living-area').val();
        let floor = $('#floor').val();
        let price = $('#price').val();
        let address = $('#address').val();
        let property_type = $('#property_type').val();
        let featuredImage = $('#featuredImage')[0].files[0];
        let featuredImageName = '';
        let featuredImageDataName = '';
        let featuredImageDataUrl = '';

        if (featuredImage) {
            featuredImageName = featuredImage.name;
            featuredImageDataName = featuredImage.type;

            let reader = new FileReader();
            reader.onload = function(event) {
                featuredImageDataUrl = event.target.result;
                sendDataToServer();
            };
            reader.readAsDataURL(featuredImage);
        } else {
            sendDataToServer(null);
        }

        let galleryImages = $('#galleryImages')[0].files;
        let galleryImageNames = [];
        let galleryImageDataNames = [];
        let galleryImageDataUrls = [];

        for (let i = 0; i < galleryImages.length; i++) {
            galleryImageNames.push(galleryImages[i].name);
            galleryImageDataNames.push(galleryImages[i].type);
            let reader = new FileReader();
            reader.onload = function(event) {
                galleryImageDataUrls.push(event.target.result);
                if (galleryImageDataUrls.length === galleryImages.length) {
                    sendDataToServer();
                }
            };
            reader.readAsDataURL(galleryImages[i]);
        }
        
        function sendDataToServer() {
            if (featuredImageDataUrl !== '' && galleryImageDataUrls.length === galleryImages.length) {
                $.ajax({
                    type: 'POST',
                    url: ajax.url,
                    data: {
                        action: 'create_real_estate_post',
                        post_title: postTitle,
                        content: content,
                        city: city,
                        area: area,
                        livingArea: livingArea,
                        floor: floor,
                        price: price,
                        address: address,
                        property_type: property_type,
                        featured_image_name: featuredImageName,
                        featuredImageDataName: featuredImageDataName,
                        featured_image_data_url: featuredImageDataUrl, 
                        gallery_image_names: galleryImageNames,
                        galleryImageDataNames: galleryImageDataNames,
                        gallery_image_data_urls: galleryImageDataUrls
                    },
                    success: function(response) {
                        $('#response_message').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        $('#response_message').html('<span class="text-danger">An error occurred. Please try again later.</span>');
                    }
                });
            }
        }
    });
});
