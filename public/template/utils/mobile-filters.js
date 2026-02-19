document.addEventListener('DOMContentLoaded', () => {
  const body = document.body;
  const filterModal = document.getElementById('filterModal');
  const sortModal = document.getElementById('sortModal');
  const openFilterBtn = document.getElementById('openFilter');
  const openSortBtn = document.getElementById('openSort');

  const openModal = (targetModal) => {
    targetModal.style.display = 'flex';
    body.classList.add('modal-open');
  };

  const closeAllModals = () => {
    document.querySelectorAll('.modal-overlay').forEach((modal) => {
      modal.style.display = 'none';
    });
    body.classList.remove('modal-open');
  };

  openFilterBtn.addEventListener('click', () => openModal(filterModal));

  openSortBtn.addEventListener('click', () => openModal(sortModal));

  document.querySelectorAll('.close-modal, .apply-btn').forEach((btn) => {
    btn.addEventListener('click', closeAllModals);
  });

  window.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal-overlay')) {
      closeAllModals();
    }
  });
});

const rangeInput = document.getElementById('discountRange');
const rangeValueDisplay = document.getElementById('rangeValue');

if (rangeInput) {
  rangeInput.addEventListener('input', (e) => {
    const val = e.target.value;
    rangeValueDisplay.innerText = `${val}%`;

    const progress = (val / rangeInput.max) * 100;
    rangeInput.style.background = `linear-gradient(to right, #ff6b00 ${progress}%, #eee ${progress}%)`;
  });

  const initialProgress = (rangeInput.value / rangeInput.max) * 100;
  rangeInput.style.background = `linear-gradient(to right, #ff6b00 ${initialProgress}%, #eee ${initialProgress}%)`;
}
