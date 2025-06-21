<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/pagination.css') }}" />

    <title>Ratings & Reviews</title>
</head>

<body>
    @include('partial.sidebar')

    <section id="content">
        @include('partial.navbar')

        <main style="padding-bottom: 100px;">
            <div class="head-title">
                <div class="left">
                    <h1>Ratings & Reviews</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Ratings & Reviews</a></li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Book Reviews</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Author</th>
                                <th>Reviewer Name</th>
                                <th>Rating</th>
                                <th>Review</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ratings as $rating)
                                <tr>
                                    {{-- Menampilkan Judul Buku melalui relasi --}}
                                    <td>{{ $rating->buku->judul_buku }}</td>

                                    {{-- Menampilkan Penulis Buku melalui relasi --}}
                                    <td>{{ $rating->buku->penulis_buku }}</td>

                                    {{-- Menampilkan Nama User melalui relasi --}}
                                    <td>{{ $rating->user->name }}</td>

                                    {{-- Menampilkan Bintang Rating --}}
                                    <td>
                                        <span style="color: #ffce3d;">
                                            @for ($i = 1; $i <= $rating->rating; $i++)
                                                <i class='bx bxs-star'></i>
                                            @endfor
                                        </span>
                                        ({{ $rating->rating }}/5)
                                    </td>

                                    {{-- Menampilkan Teks Review --}}
                                    <td>{{ $rating->review ?? 'Tidak ada ulasan teks.' }}</td>

                                    {{-- Menampilkan Tanggal dengan format yang bagus --}}
                                    <td>{{ $rating->created_at->format('d M Y') }}</td>

                                    {{-- Tombol Aksi (Delete) --}}
                                    <td>
                                        {{-- Form untuk HAPUS, ini cara yang benar dan aman --}}
                                        <form action="{{ route('ratings.destroy', $rating->id) }}" method="POST"
                                            onsubmit="return confirm('Anda yakin ingin menghapus ulasan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete"
                                                style="background:none; border:none; color:red; cursor:pointer; padding:0;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                {{-- Pesan ini akan muncul jika tidak ada rating sama sekali --}}
                                <tr>
                                    <td colspan="7" style="text-align: center;">Belum ada ulasan yang masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </section>

    <div id="pagination" class="pagination-container"></div>

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