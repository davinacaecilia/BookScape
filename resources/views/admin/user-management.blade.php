<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet' />
	<!-- My CSS -->
	<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
	<link rel="stylesheet" href="{{ asset('css/pagination.css') }}" />
	<title>Product Management</title>
</head>

<body>

	@include('partial.sidebar')

	<section id="content">

		<!-- NAVBAR -->
		@include('partial.navbar')
		
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
								<td style="padding: 10px; border: 1px solid #ccc; font-family: monospace; font-size: 0.85rem;">
									{{ $user->password }}
								</td>
								<td style="padding: 10px; border: 1px solid #ccc;">{{ $user->user_level}}</td>
								<td style="padding: 10px; border: 1px solid #ccc;">{{ $user->created_at }}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

		</main>
	</section>

	<!-- Pagination di paling bawah -->
	<div id="pagination" class="pagination-container"></div>

    <script>
        window.paginationData = {
            currentPage: {{ $users->currentPage() }},
            lastPage: {{ $users->lastPage() }},
            baseUrl: "{{ url()->current() }}",
            query: @json(request()->except('page'))
        };
    </script>

	<form id="logout-form-admin" action="{{ route('logout') }}" method="POST" style="display: none;">
		@csrf
	</form>

	<script>
		function confirmAdminLogout() {
			if (confirm('Are You Sure Want to Log Out?')) {
				document.getElementById('logout-form-admin').submit();
			}
		}
	</script>

	<script src="{{ asset('script/script.js') }}"></script>
	<script src="{{ asset('script/pagination.js') }}"></script>
</body>

</html>