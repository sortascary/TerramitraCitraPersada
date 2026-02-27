const searchInput = document.getElementById('userSearch');
const userItems = document.querySelectorAll('.user-item');

searchInput.addEventListener('keyup', function () {
    const value = this.value.toLowerCase();

    userItems.forEach(item => {
        const name = item.querySelector('.user-name').textContent.toLowerCase();
        const email = item.querySelector('.user-email').textContent.toLowerCase();
        const role = item.querySelector('.user-role').textContent.toLowerCase();

        if (name.includes(value)|| email.includes(value)|| role.includes(value)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
});
