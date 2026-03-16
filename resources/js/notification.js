async function fetchNotifications() {
    const res = await fetch('/Forum/notifications', {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
    });
    
    if (!res.ok) return;

    const data = await res.json();
    
    console.log(data);

    const count = data.unread_count;
    const notifCount = document.getElementById('notifCount');

    // update badge
    if (count > 0) {
        notifCount.textContent = count > 99 ? '99+' : count;
        notifCount.classList.remove('hidden');
    } else {
        notifCount.classList.add('hidden');
    }

}

// Echo
if (window.Echo && window.authUserId) {
    window.Echo.private(`App.Models.User.${window.authUserId}`)
        .notification((notification) => {
            // update badge immediately
            fetchNotifications();

            // browser push notification
            if (Notification.permission === 'granted') {
                new Notification(notification.forum_name, {
                    body: `${notification.sender}: ${notification.message}`,
                    icon: '/favicon.ico'
                });
            }
        });
}

// request browser notification permission
if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
}

// fetch on load and every 30 seconds as fallback
fetchNotifications();
setInterval(fetchNotifications, 7000);