 <header class="header">
    <div class="header-left">
      <a href="{{ route('home') }}" class="back-link">
        <i class="bx bx-arrow-back back-icon"></i>
      </a>
      <span class="category-title">Preview Book</span>
    </div>

    <div class="header-right">
      <div class="header-right">
        <div class="header-right-inner">
          <div class="search-bar">
            <form action="{{ route('product.library') }}" method="GET">
              <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books or authors...">
              <button type="submit"><i class='bx bx-search'></i></button>
            </form>
          </div>
        </div>
        
        <div class="nav-icons">
          <a href="{{ route('product.cart') }}" class="shopping-cart"> <i class='bx bx-cart'></i></a>
          <a href="profile" class="profile-icon"> <i class='bx bx-user-circle'></i></a>
        </div>
      </div>
    </div>
    </div>
  </header>
