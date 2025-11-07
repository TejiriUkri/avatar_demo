document.addEventListener('DOMContentLoaded', () => {
    const image = document.getElementById('sample-image');
    const uploadInput = document.getElementById('upload-image');
    const cropButton = document.getElementById('crop');
    const form = document.querySelector('form');

    let cropper;

    // Initialize Cropper.js
    if (image) {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            preview: '#above-image',
            autoCropArea: 0.8,
            responsive: true,
            restore: true,
            zoomOnTouch: false,
            zoomOnWheel: false
        });
    }

    // Handle file upload
    uploadInput.addEventListener('change', () => {
        form.submit();
    });

    // Handle crop and save
    cropButton.addEventListener('click', () => {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300
        });

        canvas.toBlob((blob) => {
            const formData = new FormData();
            formData.append('image', blob, 'avatar.jpg');

            fetch('upload.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'download.php';
                } else {
                    alert('Error uploading image. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }, 'image/jpeg', 0.8);
    });
});