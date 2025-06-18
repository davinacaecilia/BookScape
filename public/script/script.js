// Sidebar menu active class toggle
const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item => {
    const li = item.parentElement;

    item.addEventListener('click', function () {
        allSideMenu.forEach(i => {
            i.parentElement.classList.remove('active');
        });
        li.classList.add('active');

        // Optional: Anda bisa menambahkan ini jika ingin sidebar otomatis tertutup
        // saat di mobile atau layar kecil, atau jika mode 'hide' aktif.
        // if (window.innerWidth < 768 || sidebar.classList.contains('hide')) {
        //     // Tidak melakukan apa-apa, biarkan status 'hide' dipertahankan.
        // }
    });
});

// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

if (menuBar && sidebar) {
    // *** PERUBAHAN BARU 1: Memuat status sidebar dari localStorage saat halaman dimuat ***
    if (localStorage.getItem('sidebarStatus') === 'hide') {
        sidebar.classList.add('hide');
    } else {
        sidebar.classList.remove('hide'); // Pastikan tidak ada kelas 'hide' jika statusnya 'show'
    }

    menuBar.addEventListener('click', function () {
        sidebar.classList.toggle('hide');
        // *** PERUBAHAN BARU 2: Menyimpan status sidebar ke localStorage saat di-toggle ***
        if (sidebar.classList.contains('hide')) {
            localStorage.setItem('sidebarStatus', 'hide');
        } else {
            localStorage.setItem('sidebarStatus', 'show');
        }
    });
}


// SEARCH BUTTON TOGGLE (responsive)
const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

if (searchButton && searchButtonIcon && searchForm) {
    searchButton.addEventListener('click', function (e) {
        if (window.innerWidth < 576) {
            e.preventDefault();
            searchForm.classList.toggle('show');
            if (searchForm.classList.contains('show')) {
                searchButtonIcon.classList.replace('bx-search', 'bx-x');
            } else {
                searchButtonIcon.classList.replace('bx-x', 'bx-search');
            }
        }
    });
}

// Responsive sidebar & search form
// Perhatikan bagian ini, ini bisa jadi penyebab sidebar selalu hide di layar kecil.
// Kita akan sedikit modifikasi agar tidak menimpa status localStorage saat di-resize.
if (window.innerWidth < 768) {
    if (sidebar) {
        // Tambahkan 'hide' hanya jika belum ada di localStorage atau belum pernah di-toggle
        // Jika sudah ada status di localStorage, itu yang diutamakan.
        if (localStorage.getItem('sidebarStatus') === null) { // Hanya set default jika belum ada status
            sidebar.classList.add('hide');
        }
    }
} else if (window.innerWidth > 576) {
    if (searchButtonIcon && searchForm) {
        searchButtonIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }
}

window.addEventListener('resize', function () {
    if (window.innerWidth > 576) {
        if (searchButtonIcon && searchForm) {
            searchButtonIcon.classList.replace('bx-x', 'bx-search');
            searchForm.classList.remove('show');
        }
    }

    // *** PERBAIKAN UNTUK RESIZE DAN SIDEBAR ***
    // Jika layar membesar (> 768px), dan sidebar tersembunyi karena ukuran layar kecil,
    // maka kembalikan ke status dari localStorage.
    // Ini penting agar sidebar tidak "terjebak" dalam mode hide saat beralih dari mobile ke desktop.
    if (window.innerWidth >= 768) { // Asumsi 768px adalah breakpoint desktop
        if (localStorage.getItem('sidebarStatus') === 'hide') {
            sidebar.classList.add('hide');
        } else {
            sidebar.classList.remove('hide');
        }
    }
});


// DARK MODE TOGGLE
const switchMode = document.getElementById('switch-mode');

if (switchMode) {
    // Load from localStorage
    if (localStorage.getItem('dark-mode') === 'enabled') {
        document.body.classList.add('dark');
        switchMode.checked = true;
    }

    switchMode.addEventListener('change', function () {
        if (this.checked) {
            document.body.classList.add('dark');
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            document.body.classList.remove('dark');
            localStorage.setItem('dark-mode', 'disabled');
        }
    });
}