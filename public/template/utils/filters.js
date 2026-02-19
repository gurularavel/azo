
document.addEventListener('DOMContentLoaded', () => {
  const filterButtons = document.querySelectorAll('.filter-toggle');

  filterButtons.forEach(button => {
    button.addEventListener('click', (e) => {
      e.stopPropagation();
      const dropdown = button.nextElementSibling;

      
      document.querySelectorAll('.filter-dropdown').forEach(d => {
        if (d !== dropdown) {
          d.classList.add('hidden');
          d.previousElementSibling.classList.remove('border-primary');
        }
      });

      
      dropdown.classList.toggle('hidden');
      button.classList.toggle('border-primary');
    });
  });

  
  document.addEventListener('click', () => {
    document.querySelectorAll('.filter-dropdown').forEach(d => {
      d.classList.add('hidden');
      d.previousElementSibling.classList.remove('border-primary');
    });
  });

  
  document.querySelectorAll('.filter-dropdown').forEach(d => {
    d.addEventListener('click', (e) => e.stopPropagation());
  });
});
