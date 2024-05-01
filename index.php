<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cropper.js Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
</head>

<body>

    <form action="insert.php" method="post">
        <input type="file" id="inputImage" accept="image/*">
        <input type="text" name="nama">
        <input type="text" id="fileUploaded" name="foto">
        <div>
            <canvas id="outputImage"></canvas>
            <img id="resultImage" src="" alt="Cropped Image">
        </div>
        <div>
            <button type="button" id="cropButton">Crop Image</button>
        </div>

        <button class="btn btn-success" type="submit">Kirim</button>
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        function handleFileSelect(event) {
            const input = event.target;
            if (!input.files || !input.files[0]) {
                return;
            }

            console.log(input);

            const reader = new FileReader();
            reader.onload = function(e) {
                const image = new Image();
                image.onload = function() {
                    const canvas = document.getElementById('outputImage');
                    const ctx = canvas.getContext('2d');
                    canvas.width = image.width;
                    canvas.height = image.height;
                    ctx.drawImage(image, 0, 0, image.width, image.height);

                    // Destroy previous Cropper instance if exists
                    if (window.cropper) {
                        window.cropper.destroy();
                    }

                    const cropper = new Cropper(canvas, {
                        zoomable: true,
                        rotatable: true,
                        movable: true,
                        cropBoxResizable: true
                    });

                    $('#cropButton').on('click', function() {
                        const croppedCanvas = cropper.getCroppedCanvas();
                        // Convert cropped canvas to a Blob object
                        croppedCanvas.toBlob(function(blob) {
                            // Create FormData object
                            const formData = new FormData();
                            // Append cropped image to FormData object
                            formData.append('croppedImage', blob, 'cropped_image.png');

                            // Send cropped image to backend PHP using jQuery AJAX
                            $.ajax({
                                url: 'image_tmp.php',
                                method: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {
                                    $('#fileUploaded').val(response);
                                    // You can handle the response here if needed
                                    $('#resultImage').attr('src', response);
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error uploading image:', error);
                                }
                            });
                        });
                    });
                };
                image.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }

        $('#inputImage').on('change', handleFileSelect);
    </script>
</body>

</html>