(() => {
  function addExportButton() {
    const filterBar = document.querySelector('.filter-bar');
    if (!filterBar || document.getElementById('export-stories')) return;
    const button = document.createElement('button');
    button.id = 'export-stories';
    button.type = 'button';
    button.className = 'refresh-btn';
    button.textContent = 'Export CSV';
    button.title = 'Unduh semua cerita sebagai file CSV';
    button.addEventListener('click', () => window.location.assign('export.php'));
    filterBar.append(button);
  }
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', addExportButton, { once: true });
  } else {
    addExportButton();
  }
})();
