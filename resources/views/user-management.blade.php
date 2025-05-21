<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet' />
	<!-- My CSS -->
	<link rel="stylesheet" href="{{ asset('css/style.css') }}" />

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
					<h1>User List</h1>
					<ul class="breadcrumb">
						<li><a href="#">Users</a></li>
					</ul>
				</div>
			</div>

			<div class="table-container" style="padding: 2rem;">
				<table style="width: 100%; border-collapse: collapse;">
					<thead>
						<tr style="background-color: #f2f2f2;">
							<th style="padding: 10px; border: 1px solid #ccc;">ID</th>
							<th style="padding: 10px; border: 1px solid #ccc;">Name</th>
							<th style="padding: 10px; border: 1px solid #ccc;">Email</th>
							<th style="padding: 10px; border: 1px solid #ccc;">Hash Password</th>
							<th style="padding: 10px; border: 1px solid #ccc;">User Level</th>
							<th style="padding: 10px; border: 1px solid #ccc;">Registered At</th>
						</tr>
					</thead>
					<tbody>
						@foreach($users as $user)
							<tr>
								<td style="padding: 10px; border: 1px solid #ccc;">{{ $user->id }}</td>
								<td style="padding: 10px; border: 1px solid #ccc;">{{ $user->name }}</td>
								<td style="padding: 10px; border: 1px solid #ccc;">{{ $user->email }}</td>
								<td
									style="padding: 10px; border: 1px solid #ccc; font-family: monospace; font-size: 0.85rem;">
									{{ $user->password }}
								</td>
								<td style="padding: 10px; border: 1px solid #ccc;">{{ $user->user_level}}</td>
								<td style="padding: 10px; border: 1px solid #ccc;">{{ $user->created_at->format('d M Y') }}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

		</main>
	</section>

</body>
<script src="{{ asset('script/script.js') }}"></script>

</html>