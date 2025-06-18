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
                            {{-- Data Review Statis --}}
                            <tr>
                                <td>The Midnight Library</td>
                                <td>Matt Haig</td> {{-- Data Author --}}
                                <td>Alice Wonderland</td>
                                <td>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    (5/5)
                                </td>
                                <td>Buku ini luar biasa! Ide ceritanya segar dan sangat menggugah pikiran. Benar-benar wajib dibaca.</td>
                                <td>10 June 2025</td>
                                <td>
                                    <a href="#" class="btn-delete" style="color: red;" onclick="return confirm('Are You Sure Want to Delete This Comment?');">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Atomic Habits</td>
                                <td>James Clear</td> {{-- Data Author --}}
                                <td>Bob The Builder</td>
                                <td>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bx-star'></i>
                                    (4/5)
                                </td>
                                <td>Sangat praktis dan mudah diaplikasikan. Membantu mengubah kebiasaan kecil menjadi lebih baik.</td>
                                <td>08 June 2025</td>
                                <td>
                                    <a href="#" class="btn-delete" style="color: red;" onclick="return confirm('Are You Sure Want to Delete This Comment?');">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Sapiens: A Brief History of Humankind</td>
                                <td>Yuval Noah Harari</td> {{-- Data Author --}}
                                <td>Charlie Chaplin</td>
                                <td>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bx-star'></i>
                                    (4/5)
                                </td>
                                <td>Buku yang sangat informatif dan membuka wawasan. Terkadang agak padat, tapi isinya sangat berbobot.</td>
                                <td>05 June 2025</td>
                                <td>
                                    <a href="#" class="btn-delete" style="color: red;" onclick="return confirm('Are You Sure Want to Delete This Comment?');">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>The Psychology of Money</td>
                                <td>Morgan Housel</td> {{-- Data Author --}}
                                <td>Diana Prince</td>
                                <td>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    (5/5)
                                </td>
                                <td>Pendekatan yang unik dan relevan tentang keuangan. Sangat direkomendasikan untuk siapa pun.</td>
                                <td>01 June 2025</td>
                                <td>
                                    <a href="#" class="btn-delete" style="color: red;" onclick="return confirm('Are You Sure Want to Delete This Comment?');">Delete</a>
                                </td>
                            </tr>
                            <tr>
                                <td>Dune</td>
                                <td>Frank Herbert</td> {{-- Data Author --}}
                                <td>Eve Harrington</td>
                                <td>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bxs-star'></i>
                                    <i class='bx bx-star'></i>
                                    <i class='bx bx-star'></i>
                                    (3/5)
                                </td>
                                <td>Dunia yang imajinatif, tapi alurnya terkadang lambat dan bahasanya cukup kompleks.</td>
                                <td>28 May 2025</td>
                                <td>
                                    <a href="#" class="btn-delete" style="color: red;" onclick="return confirm('Are You Sure Want to Delete This Comment?');">Delete</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </section>

    <div id="pagination" class="pagination-container"></div>

    <script src="{{ asset('script/script.js') }}"></script>
    <script src="{{ asset('script/pagination.js') }}"></script>
</body>
</html>