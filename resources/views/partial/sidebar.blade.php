<section id="sidebar">
    <a href="#" class="brand">
        <i class='bx bx-book-reader' style="margin-left: 8px;"></i>
        <span class="text">
            <span class="octa">Book</span><span class="prime">Scape</span>
        </span>
    </a>
  <ul class="side-menu top">
    <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
      <a href="{{ route('admin.dashboard') }}">
        <i class='bx bxs-dashboard'></i>
        <span class="text">Dashboard</span>
      </a>
    </li>
    <li class="{{ Request::is('orders') ? 'active' : '' }}">
      <a href="{{ route('admin.orders') }}">
        <i class='bx bxs-shopping-bag-alt'></i>
        <span class="text">Orders</span>
      </a>
    </li>
    <li class="{{ Request::routeIs('admin.ratings') ? 'active' : '' }}">
            <a href="{{ route('admin.ratings') }}">
                <i class='bx bxs-star'></i>
                <span class="text">Ratings & Reviews</span>
            </a>
        </li>
    <li class="{{ Request::is('product-management') ? 'active' : '' }}">
      <a href="{{ route('product.management') }}">
        <i class='bx bxs-cart-add'></i>
        <span class="text">Product Management</span>
      </a>
    </li>
 <li class="{{ Request::is('user-management') ? 'active' : '' }}">
    <a href="{{ route('user.management') }}">
        <i class='bx bx-user'></i>
        <span class="text">User Management</span>
        </a>
    </li>
    <li>
      <a href="{{ route('logout') }}" class="logout"  onclick="return confirm('Are You Sure Want to Log Out?');">
        <i class='bx bxs-log-out-circle'></i>
        <span class="text">Logout</span>
      </a>
    </li>
  </ul>
</section>
