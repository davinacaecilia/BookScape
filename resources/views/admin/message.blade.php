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
					<h1>Message</h1>
					<ul class="breadcrumb">
						<li><a href="#">Message</a></li>
					</ul>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>User Messages</h3>
					</div>
					<table>
						<thead>
							<tr>
								<th>Name</th>
								<th>Username</th>
								<th>Message</th>
								<th>Reply</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>John Doe</td>
								<td>@johndoe</td>
								<td>Hello, I need help with my order!</td>
								<td>
								<div class="reply-box">
									<input type="text" class="reply-input" placeholder="Type your reply here...">
									<button class="btn-reply">Send</button>
								</div>
							</td>
							</tr>
							<tr>
								<td>Jane Smith</td>
								<td>@janesmith</td>
								<td>Can I change my delivery date?</td>
							<td>
								<div class="reply-box">
									<input type="text" class="reply-input" placeholder="Type your reply here...">
									<button class="btn-reply">Send</button>
								</div>
							</td>
							</tr>
							<tr>
								<td>Mark Taylor</td>
								<td>@marktaylor</td>
								<td>Where is my refund?</td>
								<td>
									<div class="reply-box">
										<input type="text" class="reply-input" placeholder="Type your reply here...">
										<button class="btn-reply">Send</button>
									</div>
								</td>
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
</html>
