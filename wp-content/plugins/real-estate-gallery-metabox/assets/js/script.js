jQuery(document).ready(function($) {
    var mediaUploader;

    $(document).on('click', '.custom-gallery-upload', function(e) {
        e.preventDefault();

        var button = $(this);
        var container = button.closest('.custom-gallery-container');
        var imageList = container.find('.custom-gallery-list');
        var imageInput = button.siblings('.custom-gallery-image-input');

        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media({
            title: 'Upload Images',
            button: {
                text: 'Select Images'
            },
            multiple: true // Allow multiple image selection
        });

        // When images are selected, add their URLs to the corresponding input fields
        mediaUploader.on('select', function() {
            var attachments = mediaUploader.state().get('selection').toArray();
            var imageUrls = attachments.map(function(attachment) {
                return attachment.attributes.url;
            });

            imageUrls.forEach(function(url) {
                var newImageInput = $('<li>', {
                    class: 'custom-gallery-item'
                }).append(
                    $('<img>', {
                        src: url,
                        class: 'custom-gallery-image-preview'
                    }),
                    $('<input>', {
                        type: 'hidden',
                        name: 'gallery_images[]',
                        value: url
                    }),
                    $('<a>', {
                        href: '#',
                        class: 'button custom-gallery-remove',
                        text: 'Remove'
                    }).click(function(e) {
                        e.preventDefault();
                        $(this).closest('.custom-gallery-item').remove();
                    })
                );

                imageList.append(newImageInput);
            });
        });

        mediaUploader.open();
    });

    $(document).on('click', '.custom-gallery-remove', function(e) {
        e.preventDefault();
        $(this).closest('.custom-gallery-item').remove();
    });
});