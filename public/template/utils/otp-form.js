const inputs = document.querySelectorAll('.otp-container input');

inputs.forEach((input, index) => {
  input.addEventListener('input', (e) => {
    const value = e.target.value;

    if (!/^[0-9]$/.test(value)) {
      e.target.value = '';
      return;
    }

    if (value && index < inputs.length - 1) {
      inputs[index + 1].focus();
    }
  });

  input.addEventListener('keydown', (e) => {
    if (e.key === 'Backspace' && !input.value && index > 0) {
      inputs[index - 1].focus();
    }
  });

  input.addEventListener('paste', (e) => {
    e.preventDefault();
    const pasteData = e.clipboardData.getData('text').trim();

    if (!/^\d+$/.test(pasteData)) return;

    pasteData.split('').forEach((char, i) => {
      if (inputs[i]) {
        inputs[i].value = char;
      }
    });

    inputs[Math.min(pasteData.length - 1, inputs.length - 1)].focus();
  });
});
