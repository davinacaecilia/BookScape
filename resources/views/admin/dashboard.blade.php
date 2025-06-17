<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="{{ asset('css/style.css') }}" />

	<title>Dashboard</title>
</head>

<body>

	@include('partial.sidebar')

	<section id="content">
		@include('partial.navbar')

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li><a href="#">Dashboard</a></li>
					</ul>
				</div>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-calendar-check'></i>
					<span class="text">
						<h3>1020</h3>
						<p>Orders</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group'></i>
					<span class="text">
						<h3>{{ $userCount }}</h3>
						<p>Users</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-dollar-circle'></i>
					<span class="text">
						<h3>IDR 6000.000k</h3>
						<p>Products</p>
					</span>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Recent Orders</h3>
					</div>
					<table>
						<thead>
							<tr>
								<th>Order ID</th>
								<th>Username</th>
								<th>Book Orders</th>
								<th>Total Order</th>
								<th class="right-text">Shipping Address</th>
								<th>Order Date</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>#ORD001</td>
								<td>igundw_</td>
								<td>Harry Poteer <br> Romeo Juliet</td>
								<td>Rp 150.000</td>
								<td>Jl. Merdeka No. 1, Bandung</td>
								<td>15-12-2024</td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>#ORD002</td>
								<td>arlo</td>
								<td>Atomic Habits</td>
								<td>Rp 120.000</td>
								<td>Jl. Sudirman No. 10, Jakarta</td>
								<td>16-12-2024</td>
								<td><span class="status process">Process</span></td>
							</tr>
							<tr>
								<td>#ORD003</td>
								<td>anggun_amu</td>
								<td>The Psychology of Money</td>
								<td>Rp 180.000</td>
								<td>Jl. Cinta Abadi No. 7, Yogyakarta</td>
								<td>17-12-2024</td>
								<td><span class="status completed">Completed</span></td>
							</tr>
							<tr>
								<td>#ORD004</td>
								<td>igundw_</td>
								<td>Start With Why</td>
								<td>Rp 200.000</td>
								<td>Jl. Kenangan Lama No. 3, Surabaya</td>
								<td>18-12-2024</td>
								<td><span class="status canceled">Canceled</span></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->


<!-- Pagination di paling bawah -->
	<div id="pagination" class="pagination-container"></div>

	<script src="{{ asset('script/script.js') }}"></script>
	<script src="{{ asset('script/pagination.js') }}"></script>
</body>
</html>