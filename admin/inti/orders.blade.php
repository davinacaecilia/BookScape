<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="{{ asset('css/style.css') }}" />

	<title>Message</title>
</head>
<body>
	@include('partial.sidebar')

	<section id="content">
		@include('partial.navbar')

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Orders</h1>
					<ul class="breadcrumb">
						<li><a href="#">Orders</a></li>
					</ul>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Orders to be Delivered</h3>
					</div>

					<table>
						<thead>
							<tr>
								<th>Order ID</th>
								<th>Username</th>
								<th>Book Orders</th>
								<th>Total Order</th>
								<th class="right-text">Shipping Address</th>
								<th>Delivery Date</th>
								<th>Status</th>
							</tr>
						</thead>
						
						<tbody>
							<tr>
								<td>#ORD001</td>
								<td>igundw_</td>
								<td>Harry Poteer <br> Romeo Juliet</td>
								<td>Rp 150.000</td>
								<td>Jl. Merdeka No. 1, Bandung</td> <!-- Data alamat -->
								<td>15-12-2024</td>
								<td class="status-cell" data-orderid="#ORD001">
									<span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>#ORD002</td>
								<td>arlo</td>
								<td>Atomic Habits</td>
								<td>Rp 120.000</td>
								<td>Jl. Sudirman No. 10, Jakarta</td>
								<td>16-12-2024</td>
								<td class="status-cell" data-orderid="#ORD001">
									<span class="status process">Process</span></td>
							</tr>
							<tr>
								<td>#ORD003</td>
								<td>anggun_amu</td>
								<td>The Psychology of Money</td>
								<td>Rp 180.000</td>
								<td>Jl. Cinta Abadi No. 7, Yogyakarta</td>
								<td>17-12-2024</td>
								<td class="status-cell" data-orderid="#ORD001">
									<span class="status completed">Completed</span></td>
							</tr>
							<tr>
								<td>#ORD004</td>
								<td>igundw_</td>
								<td>Start With Why</td>
								<td>Rp 200.000</td>
								<td>Jl. Kenangan Lama No. 3, Surabaya</td>
								<td>18-12-2024</td>
								<td class="status-cell" data-orderid="#ORD001">
									<span class="status canceled">Canceled</span></td>
							</tr>
						</tbody>
					</table>

				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->

</body>	
<script src="{{ asset('script/script.js') }}"></script>
<script src="{{ asset('script/status.js') }}"></script>
</html>
