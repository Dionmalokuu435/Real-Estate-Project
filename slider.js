const slides = document.querySelectorAll(".slide");
const nextBtn = document.querySelector(".slider-btn.next");
const prevBtn = document.querySelector(".slider-btn.prev");

let current = 0;
let timer = null;

function showSlide(i) {
  slides.forEach(s => s.classList.remove("active"));
  slides[i].classList.add("active");
  current = i;
}

function nextSlide() {
  showSlide((current + 1) % slides.length);
}

function prevSlide() {
  showSlide((current - 1 + slides.length) % slides.length);
}

function startAuto() {
  stopAuto();
  timer = setInterval(nextSlide, 4000);
}

function stopAuto() {
  if (timer) clearInterval(timer);
}

if (slides.length) {
  showSlide(0);
  startAuto();
}

if (nextBtn) nextBtn.addEventListener("click", () => { nextSlide(); startAuto(); });
if (prevBtn) prevBtn.addEventListener("click", () => { prevSlide(); startAuto(); });
