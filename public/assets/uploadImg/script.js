document.addEventListener('DOMContentLoaded', function () {
    function setupImagePreview(inputId, imgId, nameId) {
        const input = document.getElementById(inputId);
        const img = document.getElementById(imgId);
        const name = document.getElementById(nameId);

        if (!input || !img || !name) return;

        input.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    img.src = event.target.result;
                    const fileSize = (file.size / 1024).toFixed(2);
                    name.textContent = `${file.name} - ${fileSize} KB`;
                };
                reader.readAsDataURL(file);
            } else {
                name.textContent = '';
            }
        });
    }

    setupImagePreview('inputGambarCreate', 'imgCreatePreview', 'imgCreateName');
    setupImagePreview('inputGambarCreate2', 'imgCreatePreview2', 'imgCreateName2');
    // Untuk edit, inisialisasi semua ID unik
    const editPreviews = document.querySelectorAll('[id^=inputGambarEdit]');
    editPreviews.forEach((input) => {
        const token = input.id.replace('inputGambarEdit', '');
        setupImagePreview(
            `inputGambarEdit${token}`,
            `imgEditPreview${token}`,
            `imgEditName${token}`
        );
    });
});
