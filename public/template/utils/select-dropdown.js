const allSelects = document.querySelectorAll('.custom-select');

allSelects.forEach((select) => {
  const header = select.querySelector('.select-header');

  header.addEventListener('click', (e) => {
    e.stopPropagation();

    allSelects.forEach((other) => {
      if (other !== select) {
        other.classList.remove('active');
      }
    });

    select.classList.toggle('active');
  });
});

document.addEventListener('click', () => {
  allSelects.forEach((select) => select.classList.remove('active'));
});

const resetBtn = document.querySelector('.reset-filters');
resetBtn.addEventListener('click', () => {
  allSelects.forEach((select) => {
    const checkboxes = select.querySelectorAll("input[type='checkbox']");
    checkboxes.forEach((cb) => (cb.checked = false));
  });
});
