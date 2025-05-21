<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet' />
	<!-- My CSS -->
	<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
	<link rel="stylesheet" href="{{ asset('css/product-management.css') }}" />

	<title>Product Management</title> 
</head>
<body>

	@include('partial.sidebar')

	<section id="content">
		
		<!-- NAVBAR -->
<nav>
	<i class='bx bx-menu'></i>
	<a href="#" class="nav-link">Categories</a>
	<form action="#">
		<div class="form-input">
			<input type="search" placeholder="Search...">
			<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
		</div>
	</form>
	<input type="checkbox" id="switch-mode" hidden>
	<label for="switch-mode" class="switch-mode"></label>
	<a href="#" class="notification">
		<i class='bx bxs-bell'></i>
		<span class="num">8</span>
	</a>
	<a href="#" class="profile">
	</a>
</nav>


			<main>		
				<div class="head-title">
					<div class="left">
						<h1>Manage Products</h1>
						<p>Manage Products</p>
					</div>
					<div class="right">
						<a href="{{ route('product.create') }}" class="btn-add">
							<i class='bx bx-plus'></i> Add Product
						</a>
					</div>
				</div>

			<!-- PRODUCT LIST -->
			<div class="product-list">
				@foreach ($products as $product)
				<div class="product">
						<img src="{{ $product['cover'] }}" alt="{{ $product['title'] }}" />
						<h4>{{ $product['title'] }}</h4>
						<p>Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
						<div class="action-buttons">
							<form action="{{ route('product.edit', $loop->iteration) }}" method="GET">
								<button type="submit" class="btn-update">
										<i class='bx bx-update'></i> Edit
								</button>
							</form>

					<!-- bagian Tombol Delete-->
							<form action="{{ route('product.destroy', $loop->iteration) }}" method="POST" class="delete-form" onsubmit="return confirmDelete(event)">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn-delete">Delete</button>
						</form>
					</div>
				</div>
				@endforeach
		</div>
		</main>
	</section>

</body>
<script src="{{ asset('script/script.js') }}"></script>
<script src="{{ asset('script/delet.js"></script>
</html>