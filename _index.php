<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop Image and Upload with PHP</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
</head>

<body>
    <form action="insert.php" method="post">
        <input type="text" name="name" id="name">
        <input type="text" name="image" id="image">
        <input type="file" id="inputImage" accept="image/*">
        <div>
            <button type="button" id="cropButton">Crop Image</button>
        </div>
        <div>
            <canvas id="outputImage"></canvas>
            <img id="resultImage" src="" alt="Cropped Image">
        </div>
        <input type="submit" value="Insert">
    </form>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cropButton').click(function() {
                // Ambil data hasil cropping
                const croppedCanvas = cropper.getCroppedCanvas();
                const croppedImage = croppedCanvas.toDataURL();

                // Submit data gambar hasil cropping ke image_tmp.php
                $.ajax({
                    url: 'image_tmp.php',
                    type: 'POST',
                    data: {
                        cropped_image: croppedImage
                    },
                    success: function(response) {
                        $('#image').val(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Upload failed:', error);
                    }
                });
            });

            let cropper;

            function handleFileSelect(event) {
                const input = event.target;
                if (!input.files || !input.files[0]) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const image = new Image();
                    image.onload = function() {
                        const canvas = document.getElementById('outputImage');
                        const ctx = canvas.getContext('2d');
                        canvas.width = image.width;
                        canvas.height = image.height;
                        ctx.drawImage(image, 0, 0, image.width, image.height);
                        cropper = new Cropper(canvas, {
                            aspectRatio: 1, // Change the aspect ratio as needed
                            crop(event) {
                                // Handle crop event if needed
                            },
                        });
                    };
                    image.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }

            document.getElementById('inputImage').addEventListener('change', handleFileSelect);
        });
    </script>

</body>

</html>