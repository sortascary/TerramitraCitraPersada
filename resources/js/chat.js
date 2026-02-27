const floatButton = document.querySelector('.fab');
const closeButton = document.querySelector('.closeChat');
const chatOverlay = document.querySelector('.overlay-forum');
const forumListContainer = document.getElementById('forumList');
const chatListContainer = document.getElementById('chatList');
const backButton = document.getElementById('backChat');
const forumHeader = document.getElementById('forumHeader');
const attachmentToggle = document.getElementById('attachmentToggle');
const attachmentMenu = document.getElementById('attachmentMenu');
const messageInputContainer = document.getElementById('messageInput');
const messageInput = document.getElementById('messageData');
const chatForm = document.getElementById('chatForm');
const forumIdInput = document.getElementById('forum_id');
const CameraMenu = document.getElementById('CameraMenu');
const video = document.getElementById('video');
const fileInput = document.getElementById('fileInput');
const imageInput = document.getElementById('imageInput');
const backAttachment = document.getElementById('backAttachment');
const cameraButton = document.getElementById('cameraButton');
const cameraCanvas = document.getElementById('cameraCanvas');
const menu = document.getElementById("messageMenu");

let activeMessageId = null;
let isOpen = false;
let isAttachmentsOpen = false;
let currentForumId = null;
let stream = null;

cameraButton.addEventListener('click', () => {
    video.classList.toggle('opacity-50');
    setTimeout(() => {
        video.classList.toggle('opacity-50');
    }, 400);
    cameraCanvas.width = video.videoWidth;
    cameraCanvas.height = video.videoHeight;
    
    cameraCanvas.getContext("2d").drawImage(video, 0, 0, cameraCanvas.width, cameraCanvas.height);
    let image_data_url = cameraCanvas.toDataURL("image/jpeg", 1.0);

    //download
    const downloadLink = document.createElement("a");
    downloadLink.href = image_data_url
    downloadLink.download = "selfie.jpeg"
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.appendChild(downloadLink);
})

floatButton.addEventListener('click', () => {
    if (!isOpen) {
        chatOverlay.classList.remove('hidden');
        fetchForums();
        isOpen = true;
    } else {
        chatOverlay.classList.add('hidden');
        isOpen = false;
    }
});

closeButton.addEventListener('click', () => {
    chatOverlay.classList.add('hidden');
    isOpen = false;
});

attachmentToggle.addEventListener('click', () => {
    attachmentMenu.classList.toggle('hidden');
})

async function fetchForums() {
    currentForumId = null;
    forumIdInput.value = null;
    forumListContainer.innerHTML = '';
    chatListContainer.classList.add('hidden');
    messageInputContainer.classList.add('hidden');
    backButton.classList.add('hidden');
    forumHeader.textContent = "Chats";

    const res = await fetch('/Forum', { headers: { 'Accept': 'application/json' } });
    const forums = (await res.json()).data;
    console.log(forums);

    forums.forEach(forum => {
        const lastMessage = forum.message;
        const initials = forum.name.split(' ').map(w => w.charAt(0).toUpperCase()).join('');
        const imageHTML = forum.image
            ? `<img src="/storage/${forum.image}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">`
            : `<div class="rounded-circle bg-stone-500 flex items-center justify-center text-white" style="width: 80px; height: 80px;"><h2 class="m-0">${initials}</h2></div>`;

        forumListContainer.innerHTML += `
            <div class="forum-item bg-white flex p-3 items-center border-y-2 border-black cursor-pointer"
                 data-id="${forum.id}" data-name="${forum.name}">
                <div class="flex-shrink-0" style="width: 80px; height: 80px;">${imageHTML}</div>
                <div class="ml-2 text-black w-full">
                    <h4>${forum.name}</h4>
                    <div class="text-stone-500 flex justify-between">
                        <div class="m-0">${forum.message.user?.name?? '[Deleted User]'}: ${forum.message.message}</div>
                        <div class="m-0">20/20/2026</div>
                    </div>
                </div>
            </div>`;
    });

    forumListContainer.classList.remove('hidden');
}

forumListContainer.addEventListener('click', async (e) => {
    const forumItem = e.target.closest('.forum-item');
    if (!forumItem) return;

    const forumId = forumItem.dataset.id;
    const forumName = forumItem.dataset.name;

    await openChat(forumId, forumName);
});

backButton.addEventListener('click', fetchForums);

async function openChat(forumId, forumName) {
    currentForumId = forumId;
    forumIdInput.value = forumId;
    forumHeader.textContent = forumName;

    forumListContainer.classList.add('hidden');
    chatListContainer.classList.remove('hidden');
    messageInputContainer.classList.remove('hidden');
    backButton.classList.remove('hidden');

    await fetchMessages(); // load messages immediately
    chatListContainer.scrollTop = chatListContainer.scrollHeight;
}

async function fetchMessages() {
    if (!currentForumId) return;

    const res = await fetch(`/Forum/${currentForumId}`);
    const messages = (await res.json()).data;

    console.log(messages);

    renderMessages(messages);
}

function renderMessages(messages) {
    chatListContainer.innerHTML = '';
    let lastDate = null;

    messages.forEach(msg => {
        const dateObj = new Date(msg.created_at);
        const time = dateObj.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const formattedDate = dateObj.toLocaleDateString([], { day: '2-digit', month: 'long', year: 'numeric' });

        // date divider
        if (lastDate !== formattedDate) {
            chatListContainer.innerHTML += `
                <div class="bg-[#D9D9D9] self-center text-center my-2 rounded-full col-5 flex flex-col p-2">
                    <strong class="text-black">${formattedDate}</strong>
                </div>`;
            lastDate = formattedDate;
        }

        const usernameHTML = msg.user
            ? msg.user.role != "User"
                ? `<strong class="text-[#D3D3D3]">${msg.user.name}</strong>
                   <strong class="text-white bg-[#08CB00] px-1 rounded-[5px] mx-1">${msg.user.role}</strong>`
                : `<strong class="text-[#D3D3D3]">${msg.user.name}</strong>`
            : `<strong class="text-[#D3D3D3]">[Deleted User]</strong>`;

        const images = msg.files.length > 0 ? 
        msg.files.map(file => `
            <div class="relative">
                <div class="absolute inset-0 z-10 bg-gray-900/50 reveal transition-opacity duration-300 rounded-lg flex items-center justify-center">
                    <button class="inline-flex items-center justify-center rounded-full h-10 w-10 bg-white/30 hover:bg-white/50 ">
                        <svg class="w-5 h-5 shrink-0 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/></svg>
                    </button>
                </div>
                <img src="/${file.file}" class="rounded-lg max-w-full h-auto" />
            </div>
        `).join('') 
        : '';

        const bubbleHTML = msg.user?.id == window.authUserId
            ? `
               <div class="flex my-2 message relative self-end justify-end">
                    <button class="MessageMenuIconButton text-body inline-flex self-center items-end hover:text-heading bg-neutral-primary box-border border border-transparent hover:bg-neutral-tertiary rounded-base p-1.5" type="button">
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="3" d="M12 6h.01M12 12h.01M12 18h.01"/></svg>
                    </button>
                    <div class="inline-flex flex-col max-w-[70%] bg-[#474747] leading-1.5 p-3 rounded-tr-none rounded-br-lg self-end rounded-bl-lg rounded-tl-lg">
                        <div class="flex items-center space-x-1.5 rtl:space-x-reverse">
                            <span class="text-sm text-heading flex">${usernameHTML}</span>
                        </div>
                        <p class="text-sm py-2.5 mb-0">${msg.message}</p>
                        <div class="group relative w-fit">
                            ${images}
                        </div>
                        <span class="text-sm self-end">${time}</span>
                    </div>
                </div>
               `
            : `<div class="flex items-start my-2 message relative">
                    <div class="flex flex-col w-fit max-w-[70%] bg-[#242424] leading-1.5 p-3 rounded-tr-lg rounded-br-lg rounded-bl-lg rounded-tl-none">
                        <div class="flex items-center space-x-1.5 rtl:space-x-reverse">
                            <span class="text-sm text-heading">${usernameHTML}</span>
                        </div>
                        <p class="text-sm py-2.5 mb-0">${msg.message}</p>
                        <div class="group relative w-fit">
                            ${images}
                        </div>
                        <span class="text-sm self-end">${time}</span>
                    </div>
                    <button class="MessageMenuIconButton text-body inline-flex self-center items-center hover:text-heading bg-neutral-primary box-border border border-transparent hover:bg-neutral-tertiary rounded-base p-1.5" type="button">
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="3" d="M12 6h.01M12 12h.01M12 18h.01"/></svg>
                    </button>
                </div>`;

        chatListContainer.innerHTML += bubbleHTML;
    });
}

document.querySelectorAll('.attachmentOption').forEach(option => {
    option.addEventListener('click', async () => {

        const type = option.dataset.type;
        attachmentMenu.classList.add('hidden');

        if (type == 'file') {
            fileInput.accept = "*";
            fileInput.click();
        }

        if (type == 'image') {
            imageInput.accept = "image/*";
            imageInput.click();
        }

        if (type == 'camera') {
            CameraMenu.classList.remove("hidden");
            backAttachment.classList.remove("hidden");
            attachmentToggle.classList.add("hidden");
            if (!stream) {
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
                video.play();
            }
        }

        if (type === 'poll') {
            alert("Open poll creation modal here");
        }
    });
});

backAttachment.addEventListener('click', () => {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        video.srcObject = null;
        stream = null;
    }
    CameraMenu.classList.add("hidden");
    backAttachment.classList.add("hidden");
    attachmentToggle.classList.remove("hidden");
})

document.addEventListener("click", function (e) {

    const btn = e.target.closest(".MessageMenuIconButton");

    if (btn) {
        e.stopPropagation();

        activeMessageId = btn.dataset.id;

        const rect = btn.getBoundingClientRect();

        menu.style.top = `${rect.bottom + window.scrollY}px`;
        menu.style.left = `${rect.left + window.scrollX}px`;

        menu.classList.remove("hidden");
        return;
    }

    // Close when clicking outside
    if (!e.target.closest("#messageMenu")) {
        menu.classList.add("hidden");
    }
});

chatForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const message = messageInput.value.trim();
    if (!message || !currentForumId) return;

    const res = await fetch(`/Forum/AddMessage`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ forum_id: currentForumId, message })
    });

    const data = await res.json();
    messageInput.value = '';
    if (data.success) {
        renderMessages(data.data);
        chatListContainer.scrollTop = chatListContainer.scrollHeight;
    }
});

// setInterval(() => {
//     if (currentForumId) fetchMessages();
// }, 1000);