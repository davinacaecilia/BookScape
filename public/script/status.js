document.querySelectorAll('.status-cell').forEach(cell => {
  cell.addEventListener('click', () => {
    // Kalau sudah ada dropdown, jangan bikin lagi
    if (cell.querySelector('select')) return;

    const currentStatusSpan = cell.querySelector('.status');
    const currentStatus = currentStatusSpan.textContent.trim();

    // Buat dropdown pilihan status
    const select = document.createElement('select');
    const statuses = ['Pending', 'Process', 'Completed', 'Canceled'];

    statuses.forEach(status => {
      const option = document.createElement('option');
      option.value = status.toLowerCase();
      option.textContent = status;
      if (status.toLowerCase() === currentStatus.toLowerCase()) {
        option.selected = true;
      }
      select.appendChild(option);
    });

    // Ganti span status dengan dropdown
    cell.innerHTML = '';
    cell.appendChild(select);
    select.focus();

    // Ketika pilih status baru
    select.addEventListener('change', () => {
      const newStatus = select.value;
      // Ganti kembali jadi span dengan kelas sesuai status baru
      const newSpan = document.createElement('span');
      newSpan.className = 'status ' + newStatus;
      newSpan.textContent = select.options[select.selectedIndex].text;

      cell.innerHTML = '';
      cell.appendChild(newSpan);
    });

    // Kalau dropdown hilang fokus (blur) tapi belum ganti, kembalikan status lama
    select.addEventListener('blur', () => {
      if (cell.querySelector('select')) {
        cell.innerHTML = '';
        cell.appendChild(currentStatusSpan);
      }
    });
  });
});
