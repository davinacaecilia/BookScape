
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="{{ asset('css/style.css') }}" />
	<link rel="stylesheet" href="{{ asset('css/pagination.css') }}" />


	<title>Orders</title>
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
									<th>Order Date</th>
									<th>Status</th>
									<th></th> 
								</tr>
							</thead>
							<tbody>
								@forelse($orders as $order)
								@if (!$order->items->isEmpty())
							<tr>
								<td>{{ $order->id }}</td>
								<td>{{ $order->user->name ?? 'N/A' }}</td> {{-- Mengambil username dari relasi user --}}
								<td>
									@if($order->items->isEmpty()) {{-- Cek jika tidak ada items --}}
										Tidak ada buku
									@else
										@foreach($order->items as $item)
											{{ $item->buku->judul_buku ?? 'Buku Tidak Ditemukan' }} (x{{ $item->quantity }})<br>
										@endforeach
									@endif
								</td>
								<td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td> {{-- Mengambil total_price dari order --}}
								<td>
									{{-- Alamat pengiriman biasanya disimpan di Order itu sendiri atau relasi terpisah --}}
									{{-- Jika Anda memiliki kolom 'shipping_address' di tabel 'orders', gunakan: --}}
									{{ $order->alamat->address ?? 'Alamat tidak tersedia' }}
									{{-- Jika tidak, Anda perlu menambahkan kolom ini ke tabel orders atau mengambil dari relasi user yang memiliki alamat --}}
								</td>
								<td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y H:i') }}</td> {{-- Mengambil created_at dari order --}}
								<td><span class="status {{ strtolower($order->status) }}">{{ $order->status }}</span></td> {{-- Mengambil status dari order --}}
								<td>
									<a href="{{ route('admin.orders.detail', $order->id) }}" class="btn-detail">Detail</a>
								</td>
							</tr>
							@endif
							@empty
								<tr>
									<td colspan="7" style="text-align: center;">Tidak ada order yang ditemukan.</td> {{-- Sesuaikan colspan --}}
								</tr>
							@endforelse
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

	<script>
        window.paginationData = {
            currentPage: {{ $orders->currentPage() }},
            lastPage: {{ $orders->lastPage() }},
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
