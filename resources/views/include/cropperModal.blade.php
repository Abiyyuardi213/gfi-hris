<!-- Cropper.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">

<!-- Initial CSS for Cropper Modal -->
<style>
    .img-container {
        max-height: 500px;
        display: block;
    }

    .img-container img {
        max-width: 100%;
        display: block;
    }
</style>

<!-- Modal Crop -->
<div class="modal fade" id="cropperModal" tabindex="-1" role="dialog" aria-labelledby="cropperModalLabel" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropperModalLabel">Potong Gambar (1:1)</h5>
                <button type="button" class="close cancel-crop" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <img id="imageToCrop" src="" alt="Picture">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cancel-crop" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="cropImageBtn">Potong & Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Cropper.js JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<script>
    $(document).ready(function() {
        let cropper;
        let $inputImage = $('.crop-image-input');
        let $modal = $('#cropperModal');
        let $image = $('#imageToCrop');
        let currentInput = null; // To store which input triggered the modal

        // Trigger saat input file berubah
        $inputImage.on('change', function(e) {
            let files = e.target.files;

            // Validate if it is an image
            if (files && files.length > 0) {
                let file = files[0];

                if (!file.type.startsWith('image/')) {
                    alert('Mohon pilih file gambar.');
                    return;
                }

                currentInput = this; // Save the input element

                let reader = new FileReader();
                reader.onload = function(evt) {
                    $image.attr('src', evt.target.result);
                    $modal.modal('show');
                };
                reader.readAsDataURL(file);

                // Reset value sementara agar bisa pilih file yg sama jika dicancel
                // TAPI: Jika kita reset di sini, file hilang. Kita reset nanti kalau cancel.
            }
        });

        // Saat modal muncul, inisialisasi Cropper
        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper($image[0], {
                aspectRatio: 1 / 1, // 1:1 Aspect Ratio
                viewMode: 1,
                autoCropArea: 1,
            });
        }).on('hidden.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });

        // Tombol Crop ditekan
        $('#cropImageBtn').on('click', function() {
            if (cropper) {
                let canvas = cropper.getCroppedCanvas({
                    width: 1080,
                    height: 1080,
                });

                canvas.toBlob(function(blob) {
                    // Buat File baru dari Blob
                    let fileName = 'cropped_image.jpg';
                    let newFile = new File([blob], fileName, {
                        type: 'image/jpeg',
                        lastModified: new Date().getTime()
                    });

                    // Update input file dengan file baru
                    let dataTransfer = new DataTransfer();
                    dataTransfer.items.add(newFile);
                    currentInput.files = dataTransfer.files;

                    // (Opsional) Update preview jika ada
                    // let previewId = $(currentInput).data('preview');
                    // if (previewId) {
                    //     $('#' + previewId).attr('src', URL.createObjectURL(newFile));
                    // }

                    $modal.modal('hide');
                    alert('Gambar berhasil dipotong dan siap diupload.');
                }, 'image/jpeg', 0.9);
            }
        });

        // Handle tombol Cancel/Batal
        $('.cancel-crop').on('click', function() {
            // Jika user cancel, kita bisa clear input atau biarkan file asli.
            // Usually better to let them keep original or clear it if they meant to cancel upload.
            // For now, let's just clear it to avoid accidental upload of uncropped huge image if they panic.
            if (currentInput) {
                $(currentInput).val('');
            }
        });
    });
</script>
