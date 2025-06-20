document.addEventListener('DOMContentLoaded', function () {
  const container = document.getElementById("pagination");
  if (!container || !window.paginationData) return;

  const { currentPage, lastPage, baseUrl, query } = window.paginationData;

  function buildURL(page) {
    const params = new URLSearchParams(query);
    params.set('page', page);
    return `${baseUrl}?${params.toString()}`;
  }

  function createButton(label, page, isActive = false, disabled = false) {
    const btn = document.createElement("button");
    btn.textContent = label;

    if (isActive) btn.classList.add("active");
    if (disabled) {
      btn.disabled = true;
    } else {
      btn.onclick = () => {
        window.location.href = buildURL(page);
      };
    }

    return btn;
  }

  function renderPagination() {
    container.innerHTML = "";

    if (lastPage <= 1) return;

    container.appendChild(createButton("« First", 1, false, currentPage === 1));
    container.appendChild(createButton("‹ Prev", currentPage - 1, false, currentPage === 1));

    const range = 1;
    let start = currentPage - range;
    let end = currentPage + range;

    if (start < 1) {
      end += 1 - start;
      start = 1;
    }

    if (end > lastPage) {
      start -= end - lastPage;
      end = lastPage;
      if (start < 1) start = 1;
    }

    for (let i = start; i <= end; i++) {
      container.appendChild(createButton(i, i, i === currentPage));
    }

    container.appendChild(createButton("Next ›", currentPage + 1, false, currentPage === lastPage));
    container.appendChild(createButton("Last »", lastPage, false, currentPage === lastPage));
  }

  renderPagination();
});
