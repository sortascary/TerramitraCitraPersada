const items = document.querySelectorAll('[data-carousel-item]');
let index = 0;

document.querySelector('[data-carousel-next]').onclick = () => {
  items[index].classList.add('hidden');
  index = (index + 1) % items.length;
  items[index].classList.remove('hidden');
};

document.querySelector('[data-carousel-prev]').onclick = () => {
  items[index].classList.add('hidden');
  index = (index - 1 + items.length) % items.length;
  items[index].classList.remove('hidden');
};