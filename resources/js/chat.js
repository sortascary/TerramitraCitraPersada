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
const replyPreview = document.getElementById('replyPreview');
const pollModal = document.getElementById('pollModal');
const pollQuestion = document.getElementById('pollQuestion');
const pollOptions = document.getElementById('pollOptions');
const addPollOption = document.getElementById('addPollOption');
const cancelPoll = document.getElementById('cancelPoll');
const submitPoll = document.getElementById('submitPoll');
const pollAnonymous = document.getElementById('pollAnonymous');
const menu = document.getElementById("messageMenu");

let activeMessageId = null;
let isOpen = false;
let isAttachmentsOpen = false;
let currentForumId = null;
let stream = null;
let replyID = null;
let selectedFiles = [];
let selectedFile = null;

if (cameraButton){

    cameraButton.addEventListener('click', () => {
        video.classList.toggle('opacity-50');
        setTimeout(() => {
            video.classList.toggle('opacity-50');
        }, 400);
        cameraCanvas.width = video.videoWidth;
        cameraCanvas.height = video.videoHeight;
        
        cameraCanvas.getContext("2d").drawImage(video, 0, 0, cameraCanvas.width, cameraCanvas.height);
        let image_data_url = cameraCanvas.toDataURL("image/jpeg", 1.0);

        cameraCanvas.toBlob((blob) => {
            const file = new File([blob], `photo_${Date.now()}.jpg`, { type: 'image/jpeg' });
            selectedFiles.push(file);
            renderPreview();
        }, 'image/jpeg', 1.0);
    });
}

window.downloadFile = function(url, filename) {
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

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

if(attachmentToggle){
    attachmentToggle.addEventListener('click', () => {
        attachmentMenu.classList.toggle('hidden');
    })

}

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

    forums.forEach(forum => {
        const lastMessage = forum.message;
        const initials = forum.name.split(' ').map(w => w.charAt(0).toUpperCase()).join('');
        const imageHTML = forum.image
            ? `<img src="/storage/${forum.image}" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">`
            : `<div class="rounded-circle bg-stone-500 flex items-center justify-center text-white" style="width: 80px; height: 80px;"><h2 class="m-0">${initials}</h2></div>`;
            
        const dateObj = new Date(forum.message?.created_at);
        const time = dateObj.toLocaleDateString([], { day:"numeric", month:"numeric", year:"numeric" });

        forumListContainer.innerHTML += `
            <div class="forum-item bg-white flex p-3 items-center border-y-2 border-black cursor-pointer"
                 data-id="${forum.id}" data-name="${forum.name}">
                <div class="flex-shrink-0" style="width: 80px; height: 80px;">${imageHTML}</div>
                <div class="ml-2 text-black w-full">
                    <h4>${forum.name}</h4>
                    <div class="text-stone-500 flex justify-between">
                    ${forum.message? 
                        `<div class="m-0">${forum.message.user?.name?? '[Deleted User]'}: ${forum.message.message?? 'File'}</div>
                        <div class="m-0">${time}</div>`
                        : ''}
                    </div>
                </div>
            </div>`;
    });

    forumListContainer.classList.remove('hidden');
}

if (forumListContainer){
    forumListContainer.addEventListener('click', async (e) => {
        const forumItem = e.target.closest('.forum-item');
        if (!forumItem) return;
    
        const forumId = forumItem.dataset.id;
        const forumName = forumItem.dataset.name;
    
        await openChat(forumId, forumName);
    });

}

if(backButton){
    backButton.addEventListener('click', fetchForums);

}

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

        const reply = msg.message_reply 
            ? `<div class="bg-[#F1ECEC] flex-flex-col text-stone-500 p-2.5 mt-2 ">
                <p class="text-base/4 truncate">${msg.message_reply.user?.name}</p>
                <p class="mb-0 text-base/4 text-wrap">${msg.message_reply.message}</p>
            </div>` 
            : '';

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

        const pollHTML = msg.poll ? (() => {

        const totalVotes = msg.poll.reduce((sum, o) => sum + o.votes_count, 0);
        const userVoted = msg.poll.some(o => o.user_voted);

        const optionsHTML = msg.poll.map(option => {
                const percent = totalVotes > 0 ? Math.round((option.votes_count / totalVotes) * 100) : 0;
                const votersHTML = !msg.poll.anonymous && option.voters?.length > 0
                    ? `<div class="text-xs text-gray-400 mt-1">${option.voters.map(v => v.name).join(', ')}</div>`
                    : '';

                return `
                    <button type="button" class="vote-btn w-full text-left rounded-lg overflow-hidden border ${option.user_voted ? 'border-blue-500' : 'border-gray-200'} mb-2" 
                        data-poll-id="${msg.id}" data-option-id="${option.id}">
                        <div class="relative p-2">
                            <div class="absolute inset-0 bg-stone-500 transition-all" style="width: ${percent}%"></div>
                            <div class="relative flex justify-between text-sm">
                                <span>${option.option}</span>
                                <span>${percent}%</span>
                            </div>
                        </div>
                        ${votersHTML}
                    </button>`;
            }).join('');

            return `
                <div class="mt-2 w-full">
                    ${optionsHTML}
                    <p class="text-xs text-gray-400">${totalVotes} vote${totalVotes !== 1 ? 's' : ''}</p>
                </div>`;
        })() : '';

        const images = msg.files.length > 0 ? 
        msg.files.map(file => file.type == 'image'?
            `
            <div class="relative">
                <div class="absolute inset-0 z-10 bg-gray-900/50 reveal transition-opacity duration-300 rounded-lg flex items-center justify-center">
                    <button onclick="downloadFile('/storage/${file.file}', '${file.name}')" class="inline-flex items-center justify-center rounded-full h-10 w-10 bg-white/30 hover:bg-white/50">
                        <svg class="w-5 h-5 shrink-0 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/></svg>
                    </button>
                </div>
                <img src="/storage/${file.file}" class="rounded-lg max-w-full h-auto" />
            </div>
        ` : `
            <div class="flex items-start my-2.5 bg-neutral-tertiary rounded-base bg-[#1f1b1b] p-2">
                <div class="me-1.5">
                    <span class="flex items-center gap-2 text-sm font-medium text-heading pb-2">
                        <svg fill="none" aria-hidden="true" class="w-5 h-5 shrink-0" viewBox="0 0 20 21">
                            <g clip-path="url(#clip0_3173_1381)">
                                <path fill="#E2E5E7" d="M5.024.5c-.688 0-1.25.563-1.25 1.25v17.5c0 .688.562 1.25 1.25 1.25h12.5c.687 0 1.25-.563 1.25-1.25V5.5l-5-5h-8.75z"/>
                                <path fill="#B0B7BD" d="M15.024 5.5h3.75l-5-5v3.75c0 .688.562 1.25 1.25 1.25z"/>
                                <path fill="#CAD1D8" d="M18.774 9.25l-3.75-3.75h3.75v3.75z"/>
                                <path fill="#F15642" d="M16.274 16.75a.627.627 0 01-.625.625H1.899a.627.627 0 01-.625-.625V10.5c0-.344.281-.625.625-.625h13.75c.344 0 .625.281.625.625v6.25z"/>
                                <path fill="#fff" d="M3.998 12.342c0-.165.13-.345.34-.345h1.154c.65 0 1.235.435 1.235 1.269 0 .79-.585 1.23-1.235 1.23h-.834v.66c0 .22-.14.344-.32.344a.337.337 0 01-.34-.344v-2.814zm.66.284v1.245h.834c.335 0 .6-.295.6-.605 0-.35-.265-.64-.6-.64h-.834zM7.706 15.5c-.165 0-.345-.09-.345-.31v-2.838c0-.18.18-.31.345-.31H8.85c2.284 0 2.234 3.458.045 3.458h-1.19zm.315-2.848v2.239h.83c1.349 0 1.409-2.24 0-2.24h-.83zM11.894 13.486h1.274c.18 0 .36.18.36.355 0 .165-.18.3-.36.3h-1.274v1.049c0 .175-.124.31-.3.31-.22 0-.354-.135-.354-.31v-2.839c0-.18.135-.31.355-.31h1.754c.22 0 .35.13.35.31 0 .16-.13.34-.35.34h-1.455v.795z"/>
                                <path fill="#CAD1D8" d="M15.649 17.375H3.774V18h11.875a.627.627 0 00.625-.625v-.625a.627.627 0 01-.625.625z"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_3173_1381">
                                <path fill="#fff" d="M0 0h20v20H0z" transform="translate(0 .5)"/>
                                </clipPath>
                            </defs>
                        </svg>
                        ${file.name}
                    </span>
                    <span class="flex text-xs font-normal text-heading gap-2">
                        ${(file.size / 1024 / 1024).toFixed(1)} MB
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="self-center" width="3" height="4" viewBox="0 0 3 4" fill="none">
                            <circle cx="1.5" cy="2" r="1.5" fill="#6B7280"/>
                        </svg>
                        ${file.name.split('.').pop().toUpperCase()}
                    </span>
                </div>
                <div class="inline-flex self-center items-center">
                    <button onclick="downloadFile('/storage/${file.file}', '${file.name}')" class="text-heading bg-neutral-tertiary box-border border border-transparent hover:bg-neutral-quaternary focus:ring-4 focus:ring-neutral-quaternary font-medium leading-5 rounded-base p-2 focus:outline-none" type="button">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01"/></svg>
                    </button>
                </div>
            </div>
        `
    ).join('') 
        : '';

        const bubbleHTML = msg.user?.id == window.authUserId
            ? `
               <div class="flex my-2 message relative self-end justify-end">
                    <button class="MessageMenuIconButton text-body inline-flex self-center items-end hover:text-heading bg-neutral-primary box-border border border-transparent hover:bg-neutral-tertiary rounded-base p-1.5" data-id="${msg.id}" data-owner="${msg.user?.id}" data-message="${msg.message}" data-username="${msg.user?.name ?? '[Deleted User]'}" type="button">
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="3" d="M12 6h.01M12 12h.01M12 18h.01"/></svg>
                    </button>
                    <div class="inline-flex flex-col max-w-[70%] bg-[#474747] leading-1.5 p-3 rounded-tr-none rounded-br-lg self-end rounded-bl-lg rounded-tl-lg">
                        <div class="flex items-center space-x-1.5 rtl:space-x-reverse">
                            <span class="text-sm text-heading flex">${usernameHTML}</span>
                        </div>
                        ${reply}
                        <p class="text-sm py-2.5 mb-0">${msg.message?? ''}</p>
                        <div class="group relative w-fit">
                            ${pollHTML}
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
                        ${reply}
                        <p class="text-sm py-2.5 mb-0">${msg.message}</p>
                        <div class="group relative w-fit">
                            ${images}
                        </div>
                        <span class="text-sm self-end">${time}</span>
                    </div>
                    <button class="MessageMenuIconButton text-body inline-flex self-center items-center hover:text-heading bg-neutral-primary box-border border border-transparent hover:bg-neutral-tertiary rounded-base p-1.5" data-id="${msg.id}" data-owner="${msg.user?.id}" data-message="${msg.message}" data-username="${msg.user?.name ?? '[Deleted User]'}" type="button">
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
            pollModal.classList.remove('hidden');
            attachmentMenu.classList.add('hidden');
        }
    });
});

if (backAttachment){
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

}

document.addEventListener("click", function (e) {

    const btn = e.target.closest(".MessageMenuIconButton");

    if (btn) {
        e.stopPropagation();

        activeMessageId = btn.dataset.id;

        const rect = btn.getBoundingClientRect();

        const deleteOption = document.getElementById('deleteOption');
        if (btn.dataset.owner == window.authUserId || window.authUserRole == "Admin") {
            deleteOption.classList.remove('hidden');
        } else {
            deleteOption.classList.add('hidden');
        }

        menu.style.top = `${rect.bottom + window.scrollY}px`;
        menu.style.left = `${rect.left + window.scrollX}px`;

        menu.classList.remove("hidden");
        return;
    }

    if (!e.target.closest("#messageMenu")) {
        menu.classList.add("hidden");
    }
});

document.querySelector('#messageMenu .reply-btn').addEventListener('click', () => {
    const btn = document.querySelector(`.MessageMenuIconButton[data-id="${activeMessageId}"]`);
    const message = btn?.dataset.message ?? '';
    const username = btn?.dataset.username ?? '';

    replyID = activeMessageId;

    replyPreview.innerHTML = ``;
    replyPreview.innerHTML = `
        <div>
            <div class="flex">${username}</div>
            <div class="m-0">${message}</div>
        </div>
        <button type="button" class="removeReply rounded-full w-6 h-6 text-xs flex self-start justify-center">&times;</button>
    `;

    replyPreview.classList.remove('hidden');
    menu.classList.add("hidden");
});

document.addEventListener('click', function (e) {
    if (e.target.closest('#replyPreview .removeReply')) {
        replyID = null;
        replyPreview.classList.add('hidden');
        console.log('Reply cleared');
    }
});

document.querySelector('#messageMenu .delete-btn').addEventListener('click', async () => {
    menu.classList.add("hidden");
    if (!activeMessageId) return;

    const res = await fetch(`/Forum/DeleteMessage/${activeMessageId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        }
    });

    const data = await res.json();
    if (data.success) {
        renderMessages(data.data);
    }
});

addPollOption.addEventListener('click', () => {
    const count = pollOptions.querySelectorAll('.poll-option-input').length + 1;
    if (count > 6) return;
    const div = document.createElement('div');
    div.classList.add('flex', 'gap-2');
    div.innerHTML = `
        <input type="text" placeholder="Option ${count}" class="poll-option-input flex-1 border rounded-lg p-2 text-sm outline-none" />
        <button type="button" class="remove-option text-red-400 text-lg">&times;</button>`;
    pollOptions.appendChild(div);

    div.querySelector('.remove-option').addEventListener('click', () => div.remove());
});

// Cancel
cancelPoll.addEventListener('click', () => {
    pollModal.classList.add('hidden');
    pollQuestion.value = '';
    pollOptions.querySelectorAll('input').forEach(i => i.value = '');
});

submitPoll.addEventListener('click', async () => {
    const question = pollQuestion.value.trim();
    const options = [...pollOptions.querySelectorAll('.poll-option-input')]
        .map(i => i.value.trim())
        .filter(v => v !== '');
    const anonymous = pollAnonymous.checked;

    if (!question || options.length < 2) {
        alert('Please enter a question and at least 2 options.');
        return;
    }

    console.log(
        JSON.stringify({
            forum_id: currentForumId,
            message: question,
            message_type: 'poll',
            poll: { options, anonymous }
        })
    );

    const res = await fetch('/Forum/AddMessage', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            forum_id: currentForumId,
            message: question,
            message_type: 'poll',
            poll: { options, anonymous }
        })
    });

    const data = await res.json();
    if (data.success) {
        pollModal.classList.add('hidden');
        pollQuestion.value = '';
        pollOptions.querySelectorAll('input').forEach(i => i.value = '');
        renderMessages(data.data);
        chatListContainer.scrollTop = chatListContainer.scrollHeight;
    }
});

// Vote
document.addEventListener('click', async (e) => {
    const voteBtn = e.target.closest('.vote-btn');
    if (!voteBtn) return;

    const pollId = voteBtn.dataset.pollId;
    const optionId = voteBtn.dataset.optionId;

    console.log(
        JSON.stringify({
            message_id: pollId,
            option_id: optionId
        })
    );

    const res = await fetch(`/Forum/Poll/Vote`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ message_id: pollId, option_id: optionId })
    });

    const data = await res.json();
    if (data.success) {
        renderMessages(data.data);
    }
});

function renderPreview() {
    const preview = document.getElementById('filePreview');
    preview.innerHTML = '';

    if (selectedFiles.length === 0 && !selectedFile) {
        preview.classList.add('hidden');
        return;
    }

    preview.classList.remove('hidden');

    // Image previews
    selectedFiles.forEach((file, index) => {
        const url = URL.createObjectURL(file);
        preview.innerHTML += `
            <div class="relative">
                <img src="${url}" class="h-16 w-16 object-cover rounded-lg" />
                <button type="button" data-index="${index}" class="removeImage absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 text-xs flex items-center justify-center">&times;</button>
            </div>`;
    });

    // File preview
    if (selectedFile) {
        preview.innerHTML += `
            <div class="relative flex items-center gap-2 bg-gray-100 rounded-lg px-3 py-2">
                <svg class="w-5 h-5 shrink-0 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4v11a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-7Z" clip-rule="evenodd"/></svg>
                <span class="text-xs text-gray-700 max-w-[120px] truncate">${selectedFile.name}</span>
                <button type="button" id="removeFile" class="text-red-500 text-xs font-bold">&times;</button>
            </div>`;
    }

    // Bind remove buttons
    preview.querySelectorAll('.removeImage').forEach(btn => {
        btn.addEventListener('click', () => {
            selectedFiles.splice(parseInt(btn.dataset.index), 1);
            renderPreview();
        });
    });

    const removeFileBtn = preview.querySelector('#removeFile');
    if (removeFileBtn) {
        removeFileBtn.addEventListener('click', () => {
            selectedFile = null;
            fileInput.value = '';
            renderPreview();
        });
    }
}

fileInput.addEventListener('change', () => {
    if (fileInput.files[0]) {
        selectedFile = fileInput.files[0];
        selectedFiles = []; 
        imageInput.value = '';
        renderPreview();
    }
});

imageInput.addEventListener('change', () => {
    if (imageInput.files.length > 0) {
        selectedFiles = Array.from(imageInput.files);
        selectedFile = null; 
        fileInput.value = '';
        renderPreview();
    }
});

if(chatForm){
    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message && selectedFiles.length === 0 && !selectedFile) return;
        if (!currentForumId) return;

        const formData = new FormData();
        formData.append('forum_id', currentForumId);
        formData.append('message', message || '');
        formData.append('message_type', 'text');
        formData.append('_token', document.querySelector('input[name="_token"]').value);

        selectedFiles.forEach((file, i) => {
            formData.append(`attachments[${i}]`, file);
        });

        if (selectedFile) {
            formData.append('attachments[0]', selectedFile);
        }

        if (replyID) {
            formData.append('message_id', replyID);
        }

        const res = await fetch(`/Forum/AddMessage`, {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: formData  
        });

        const data = await res.json();
        messageInput.value = '';
        selectedFiles = [];
        selectedFile = null;
        fileInput.value = '';
        imageInput.value = '';
        replyID = null;

        replyPreview.classList.add('hidden');
        renderPreview();

        if (data.success) {
            renderMessages(data.data);
            chatListContainer.scrollTop = chatListContainer.scrollHeight;
        }
    });
}

// setInterval(() => {
//     if (currentForumId) fetchMessages();
// }, 1000);