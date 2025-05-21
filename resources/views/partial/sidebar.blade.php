<!-- SIDEBAR -->
<section id="sidebar">
<a href="#" class="brand">
      <i class='bx bx-book-reader' style="margin-left: 8px;"></i>
      <span class="text">
        <span class="octa">Book</span><span class="prime">Scape</span>
      </span>

    </a>
  <ul class="side-menu top">
    <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
      <a href="{{ url('dashboard') }}">
        <i class='bx bxs-dashboard'></i>
        <span class="text">Dashboard</span>
      </a>
    </li>
    <li class="{{ Request::is('orders') ? 'active' : '' }}">
      <a href="{{ url('orders') }}">
        <i class='bx bxs-shopping-bag-alt'></i>
        <span class="text">Orders</span>
      </a>
    </li>
    <li class="{{ Request::is('message') ? 'active' : '' }}">
      <a href="{{ url('message') }}">
        <i class='bx bxs-message-dots'></i>
        <span class="text">Message</span>
      </a>
    </li>
    <li class="{{ Request::is('product-management') ? 'active' : '' }}">
      <a href="{{ url('product-management') }}">
        <i class='bx bxs-cart-add'></i>
        <span class="text">Product Management</span>
      </a>
    </li>
 <li class="{{ Request::is('user-management') ? 'active' : '' }}">
    <a href="{{ url('user-management') }}">
        <i class='bx bx-user'></i>
        <span class="text">User Management</span>
        </a>
    </li>
    <li>
      <a href="{{ url('logout') }}" class="logout">
        <i class='bx bxs-log-out-circle'></i>
        <span class="text">Logout</span>
      </a>
    </li>
  </ul>
</section>
