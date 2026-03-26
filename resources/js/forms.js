const fileInput = document.getElementById('image');
const emptyDisplay = document.getElementById('empty');
const fileDisplay = document.getElementById('filled');
const fileNameDisplay = document.getElementById('file-name');
const form = document.getElementById('form');
const submitBtn = document.getElementById('submitBtn');
const preview = document.getElementById('preview');
const togglePass = document.getElementById('passBtn');

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

if (togglePass){
    togglePass.addEventListener('click', function () {
        document.getElementById('password').type = document.getElementById('password').type === 'password' ? 'text' : 'password';
        togglePass.innerHTML = document.getElementById('password').type != 'password' ? 
        `<svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
        </svg> `
        : `<svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
              <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
              <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
            </svg>`;
    })
}