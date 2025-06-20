  <header class="header">
    <div class="header-left">
      <a href="{{ route('home') }}" class="back-link">
        <i class="bx bx-arrow-back back-icon"></i>
      </a>
      <span class="category-title">Library</span>
    </div>
    <div class="header-right">
      <div class="header-right">
        <div class="header-right-inner">
          <div class="category-dropdown">
            <button class="category-button" id="categoryToggle">
              Categories <span class="arrow" id="arrow">&#9660;</span>
            </button>
            <div class="category-menu" id="categoryMenu">
              <a href="{{ route('product.library') }}" class="{{ request('genre') == null ? 'active-genre' : '' }}">All</a>
              @foreach ($genres as $genre)
                <a href="{{ route('product.library', ['genre' => $genre->genre]) }}"
                class="{{ request('genre') == $genre->genre ? 'active-genre' : '' }}">{{ $genre->genre }}</a>
              @endforeach
            </div>
          </div>
          
          <div class="search-bar">
            <form action="{{ route('product.library') }}" method="GET">
              <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books or authors...">
              <button type="submit"><i class='bx bx-search'></i></button>
            </form>
          </div>
        </div>
        <div class="nav-icons">
          <a href="{{ route('product.cart') }}" class="shopping-cart"> <i class='bx bx-cart'></i></a>
          <a href="profile" class="profile-icon"><i class='bx bx-user-circle'></i></a>
        </div>
      </div>
    </div>
  </header>
