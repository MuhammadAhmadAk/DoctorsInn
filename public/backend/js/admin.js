/* DoctorsInn Admin Panel JavaScript */

document.addEventListener('DOMContentLoaded', function () {
    // 1. Sidebar Mobile Toggle
    const toggleBtn = document.querySelector('.sidebar-toggle-btn');
    const sidebar = document.querySelector('.admin-sidebar');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('show');
        });

        // Close sidebar on outer click on mobile
        document.addEventListener('click', function (e) {
            if (window.innerWidth <= 991) {
                if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                    sidebar.classList.remove('show');
                }
            }
        });
    }

    // 2. Keyboard shortcut to focus search: Ctrl + / or Command + /
    const navSearchInput = document.querySelector('.nav-search input');
    if (navSearchInput) {
        document.addEventListener('keydown', function (e) {
            if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                e.preventDefault();
                navSearchInput.focus();
            }
        });
    }

    // 3. Universal Admin Datatable Pagination Engine
    initAdminDataTablePagination();
});

function buildPageList(current, total) {
    if (total <= 7) {
        return Array.from({ length: total }, function (_, idx) { return idx + 1; });
    }
    if (current <= 3) {
        return [1, 2, 3, '...', total - 2, total - 1, total];
    }
    if (current >= total - 2) {
        return [1, 2, '...', total - 2, total - 1, total];
    }
    return [1, '...', current - 1, current, current + 1, '...', total];
}

function attachPaginationToTable(table) {
    const tbody = table.querySelector('tbody');
    if (!tbody) return;

    const allRows = Array.from(tbody.querySelectorAll('tr'));
    let currentPage = 1;
    let perPage = parseInt(table.getAttribute('data-per-page') || '10', 10);

    // Create wrapper directly after .table-responsive (or after table)
    const tableWrap = table.closest('.table-responsive') || table;
    const pgWrap = document.createElement('div');
    pgWrap.className = 'adm-pagination-wrap';

    pgWrap.innerHTML =
        '<div class="adm-pagination-bar">' +
            '<div class="adm-pg-left">' +
                '<span>Showing page</span>' +
                '<input type="number" class="adm-pg-input" min="1" value="1" aria-label="Page number">' +
                '<span>of <span class="adm-pg-total">1</span></span>' +
            '</div>' +
            '<div class="adm-pg-center">' +
                '<button type="button" class="adm-pg-nav" data-action="first" title="First Page" aria-label="First Page"><i class="fa-solid fa-angles-left"></i></button>' +
                '<button type="button" class="adm-pg-nav" data-action="prev" title="Previous Page" aria-label="Previous Page"><i class="fa-solid fa-angle-left"></i></button>' +
                '<div class="adm-pg-pages"></div>' +
                '<button type="button" class="adm-pg-nav" data-action="next" title="Next Page" aria-label="Next Page"><i class="fa-solid fa-angle-right"></i></button>' +
                '<button type="button" class="adm-pg-nav" data-action="last" title="Last Page" aria-label="Last Page"><i class="fa-solid fa-angles-right"></i></button>' +
            '</div>' +
            '<div class="adm-pg-right">' +
                '<span>Rows per page</span>' +
                '<select class="adm-pg-select" aria-label="Rows per page">' +
                    '<option value="5">5</option>' +
                    '<option value="10">10</option>' +
                    '<option value="25">25</option>' +
                    '<option value="50">50</option>' +
                '</select>' +
            '</div>' +
        '</div>';

    tableWrap.parentNode.insertBefore(pgWrap, tableWrap.nextSibling);

    const pageInput = pgWrap.querySelector('.adm-pg-input');
    const totalLabel = pgWrap.querySelector('.adm-pg-total');
    const pagesContainer = pgWrap.querySelector('.adm-pg-pages');
    const perPageSelect = pgWrap.querySelector('.adm-pg-select');
    const btnFirst = pgWrap.querySelector('[data-action="first"]');
    const btnPrev = pgWrap.querySelector('[data-action="prev"]');
    const btnNext = pgWrap.querySelector('[data-action="next"]');
    const btnLast = pgWrap.querySelector('[data-action="last"]');

    // Match initial perPage select value
    if ([5, 10, 25, 50].includes(perPage)) {
        perPageSelect.value = String(perPage);
    } else {
        perPage = 10;
        perPageSelect.value = '10';
    }

    // Empty state row helper
    let emptyRow = null;
    function toggleEmptyRow(show) {
        if (show) {
            if (!emptyRow) {
                const colCount = table.querySelectorAll('thead th').length || 6;
                emptyRow = document.createElement('tr');
                emptyRow.className = 'adm-empty-row';
                emptyRow.innerHTML = '<td colspan="' + colCount + '" class="text-center text-muted py-4">No matching records found.</td>';
                tbody.appendChild(emptyRow);
            }
            emptyRow.style.display = '';
        } else if (emptyRow) {
            emptyRow.style.display = 'none';
        }
    }

    function render(goToPage) {
        const activeRows = allRows.filter(function (row) {
            return row.dataset.admFilteredOut !== 'true';
        });

        const totalPages = Math.max(1, Math.ceil(activeRows.length / perPage));
        if (typeof goToPage === 'number') {
            currentPage = goToPage;
        }
        currentPage = Math.min(Math.max(1, currentPage), totalPages);

        const startIdx = (currentPage - 1) * perPage;
        const endIdx = startIdx + perPage;

        allRows.forEach(function (row) {
            row.style.display = 'none';
        });

        activeRows.forEach(function (row, index) {
            if (index >= startIdx && index < endIdx) {
                row.style.display = '';
            }
        });

        toggleEmptyRow(activeRows.length === 0);

        // Sync inputs & buttons
        pageInput.value = currentPage;
        pageInput.max = totalPages;
        totalLabel.textContent = totalPages;

        btnFirst.disabled = currentPage <= 1;
        btnPrev.disabled = currentPage <= 1;
        btnNext.disabled = currentPage >= totalPages;
        btnLast.disabled = currentPage >= totalPages;

        // Render page number pills
        pagesContainer.innerHTML = '';
        buildPageList(currentPage, totalPages).forEach(function (item) {
            if (item === '...') {
                const dots = document.createElement('span');
                dots.className = 'adm-pg-dots';
                dots.textContent = '...';
                pagesContainer.appendChild(dots);
            } else {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'adm-pg-num' + (item === currentPage ? ' active' : '');
                btn.textContent = item;
                btn.addEventListener('click', function () {
                    render(item);
                });
                pagesContainer.appendChild(btn);
            }
        });
    }

    // Event bindings
    btnFirst.addEventListener('click', function () { render(1); });
    btnPrev.addEventListener('click', function () { render(currentPage - 1); });
    btnNext.addEventListener('click', function () { render(currentPage + 1); });
    btnLast.addEventListener('click', function () {
        const activeRows = allRows.filter(function (r) { return r.dataset.admFilteredOut !== 'true'; });
        render(Math.max(1, Math.ceil(activeRows.length / perPage)));
    });

    pageInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const val = parseInt(pageInput.value, 10);
            if (!isNaN(val)) render(val);
        }
    });
    pageInput.addEventListener('change', function () {
        const val = parseInt(pageInput.value, 10);
        render(isNaN(val) ? currentPage : val);
    });

    perPageSelect.addEventListener('change', function () {
        perPage = parseInt(perPageSelect.value, 10) || 10;
        render(1);
    });

    // Expose re-render method for external filters
    table._admPaginate = render;
    table._admRows = allRows;

    render(1);
}

function initAdminDataTablePagination() {
    const tables = Array.from(document.querySelectorAll('.adm-table:not([data-no-paginate="true"])'));
    tables.forEach(attachPaginationToTable);

    // Connect global top navbar search if the page has a single paginated datatable
    const navSearch = document.querySelector('.admin-navbar .nav-search input');
    if (navSearch && tables.length === 1) {
        const targetTable = tables[0];
        navSearch.addEventListener('input', function () {
            const query = navSearch.value.trim().toLowerCase();
            (targetTable._admRows || []).forEach(function (row) {
                const text = row.textContent.toLowerCase();
                row.dataset.admFilteredOut = (query && !text.includes(query)) ? 'true' : 'false';
            });
            if (typeof targetTable._admPaginate === 'function') {
                targetTable._admPaginate(1);
            }
        });
    }
}
