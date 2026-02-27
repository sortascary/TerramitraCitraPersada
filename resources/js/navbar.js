const burger = document.querySelector('.hamburger');
const close = document.querySelector('.closeNav');
const sidebar = document.querySelector('.sidebar');

const itemsM = document.querySelector('[dropdown-items-mobile]');
const items = document.querySelector('[dropdown-items]');

let isDropdownOpen = false;
let isOpen = false;

burger.addEventListener('click', () => {
    if (!isOpen){
        sidebar.style.display = "block";
        isOpen = true;
    } else if (isOpen){
        sidebar.style.display = "none";
        isOpen = false;
    }
});

close.addEventListener('click', () => {
    if (!isOpen){
        sidebar.style.display = "block";
        isOpen = true;
    } else if (isOpen){
        sidebar.style.display = "none";
        isOpen = false;
    }
});

document.querySelector('[dropdown]').onclick = () => {
    if (isDropdownOpen){
        items.classList.add('hidden');
        isDropdownOpen = false;
    } else{
        items.classList.remove('hidden');
        isDropdownOpen = true;
    }
};

document.querySelector('[dropdownM]').onclick = () => {
    if (isDropdownOpen){
        itemsM.classList.add('hidden');
        isDropdownOpen = false;
    } else{
        itemsM.classList.remove('hidden');
        isDropdownOpen = true;
    }
};