const fileInput = document.getElementById('image');
const emptyDisplay = document.getElementById('empty');
const fileDisplay = document.getElementById('filled');
const fileNameDisplay = document.getElementById('file-name');
const form = document.getElementById('form');
const submitBtn = document.getElementById('submitBtn');
const preview = document.getElementById('preview');

let isSubmitting = false;

if (fileInput){    
    fileInput.addEventListener('change', function () {
        if (this.files.length > 0) {
            if (fileNameDisplay){
                fileNameDisplay.textContent = "Selected: " + this.files[0].name;
            }
            if(preview){
                const file = this.files[0];
                preview.src = URL.createObjectURL(file);
            }
            fileDisplay.classList.remove('hidden');
            emptyDisplay.classList.add('hidden');
        }
    });
}

// Disable button while uploading
form.addEventListener('submit', function () {
    console.log("running");
    if (isSubmitting) {
        e.preventDefault();
        return;
    }

    isSubmitting = true;

    submitBtn.disabled = true;
    submitBtn.innerText = "Uploading...";
    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
});