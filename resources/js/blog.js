const items = document.querySelectorAll('[data-carousel-item]');
const link = encodeURI(window.location.href);
const msg = encodeURIComponent("Look at this article i found from Terramitra Citra Persada!");
const title = encodeURIComponent(document.querySelector('title').textContent);

const facebook = document.querySelector('.facebook');
const whatsapp = document.querySelector('.whatsapp');
const copy = document.querySelector('.copy');

facebook.href = `https://www.facebook.com/sharer/sharer.php?=${link}`;
whatsapp.href = `https://wa.me/?text=${msg}%20${link}`;

let index = 0;

copy.addEventListener("click", () => {
  navigator.clipboard.writeText(link);
});

document.querySelectorAll('[data-carousel-next]').onclick = () => {
  items[index].classList.add('hidden');
  index = (index + 1) % items.length;
  items[index].classList.remove('hidden');
};

document.querySelectorAll('[data-carousel-prev]').onclick = () => {
  items[index].classList.add('hidden');
  index = (index - 1 + items.length) % items.length;
  items[index].classList.remove('hidden');
};