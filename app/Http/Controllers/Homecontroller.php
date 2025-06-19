<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $featuredBooks = [
            [
                'title' => 'The Midnight Library',
                'author' => 'Matt Haig',
                'cover' => asset('img/books/book1.jpg'),
                'rating' => 4.5
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'cover' => asset('img/books/book2.jpg'),
                'rating' => 5.0
            ],
            [
                'title' => 'Dune',
                'author' => 'Frank Herbert',
                'cover' => asset('img/books/book3.jpg'),
                'rating' => 4.0
            ]
        ];

        $categories = [
            ['icon' => 'bx-book-open', 'name' => 'Fiction'],
            ['icon' => 'bx-brain', 'name' => 'Psychology'],
            ['icon' => 'bx-rocket', 'name' => 'Sci-Fi'],
            ['icon' => 'bx-history', 'name' => 'History'],
            ['icon' => 'bx-heart', 'name' => 'Romance'],
            ['icon' => 'bx-ghost', 'name' => 'Horror']
        ];

        return view('home', compact('featuredBooks', 'categories'));
    }

}