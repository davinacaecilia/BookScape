<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Pengguna</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="{{ asset('user/profile.css') }}">
</head>

<body>
  <div class="home-container">
    <!-- Background -->
    <img class="home-bg-image" src="{{ asset('img/books-library-shelves-138556-1280-x-720-10.png') }}" alt="Background">
    <div class="home-overlay"></div>

    <!-- Navigation -->
    <nav class="home-nav">
      <div class="logo">
        <i class='bx bx-book-reader'></i>
        <span>BOOKSCAPE</span>
      </div>
      <div class="nav-links">
        <a href="{{ route ('home') }}">Home</a>
        <a href="/browse">Books</a>
        <a href="/categories">Categories</a>
        <a href="/profile" class="active">Profile</a>
      </div>
    </nav>

    <!-- Profile Content -->
    <div class="profile-page">
      <div class="profile-container">
        <div class="profile-header">
          <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="Profile"
            class="profile-avatar">
          <h1 class="profile-name">{{ $user->name }}</h1>
          <p class="profile-email">{{ $user->email }}</p>
        </div>

        <div class="profile-body">
          <div class="profile-section">
            <h2 class="profile-section-title">Informasi Pribadi</h2>
            <div class="profile-info">
              <div class="info-group">
                <span class="info-label">Nama Lengkap:</span>
                <div class="info-value">{{ $user->name }}</div>
              </div>
              <div class="info-group">
                <span class="info-label">Email:</span>
                <div class="info-value">{{ $user->email }}</div>
              </div>
              <div class="info-group">
                <span class="info-label">No. Telepon:</span>
                <div class="info-value">{{ $user->primaryAlamat?->phone ?? '' }}</div>
              </div>
              <div class="info-group">
                <span class="info-label">Alamat:</span>
                <div class="info-value">{{ $user->primaryAlamat?->address ?? '' }}</div>
              </div>
            </div>

            <button class="edit-btn" onclick="toggleEditForm()">
              <i class="fas fa-edit"></i> Edit Profile
            </button>

            {{-- Form Edit --}}
            <div class="edit-form" id="editForm" style="display: none;">
              {{-- Arahkan ke rute update profil bawaan Breeze --}}
              <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                {{-- Input untuk data User --}}
                <div class="form-group">
                  <label for="name">Nama Lengkap</label>
                  <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                {{-- Input Alamat & Telepon Utama --}}
                <div class="form-group">
                  <label for="phone">Nomor Telepon</label>
                  <input type="tel" name="phone" value="{{ old('phone', $user->primaryAlamat?->phone) }}">
                </div>
                <div class="form-group">
                  <label for="address">Alamat</label>
                  <input type="text" name="address" value="{{ old('address', $user->primaryAlamat?->address) }}">
                </div>

                <div class="form-actions">
                  <button type="submit" class="save-btn">Simpan Perubahan</button>
                  <button type="button" class="cancel-btn" onclick="toggleEditForm()">Batal</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="home-footer">
      <div class="footer-content">
        <div class="footer-bottom">
          <p>&copy; {{ date('Y') }} BookScape. All rights reserved.</p>

          <div class="contact-links">
            <a href="mailto:info@bookscape.com" class="contact-item">
              <i class='bx bx-envelope'></i>
              <span>info@bookscape.com</span>
            </a>
            <a href="tel:+1234567890" class="contact-item">
              <i class='bx bx-phone'></i>
              <span>+1 (234) 567-890</span>
            </a>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <script>
    function toggleEditForm() {
      const form = document.getElementById('editForm');
      form.style.display = form.style.display === 'block' ? 'none' : 'block';

      // Reset error messages when form is closed
      if (form.style.display === 'none') {
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(msg => msg.textContent = '');
      }
    }

    // Close dropdown when clicking outside
    window.onclick = function (event) {
      if (!event.target.matches('.profile-icon')) {
        const dropdowns = document.getElementsByClassName('profile-dropdown');
        for (let i = 0; i < dropdowns.length; i++) {
          const openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }
  </script>
</body>

</html>