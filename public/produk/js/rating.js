document.addEventListener('DOMContentLoaded', () => {
        const starRatings = document.querySelectorAll('input[name="rating"]');
        const reviewTextarea = document.getElementById('reviewText');
        const submitButton = document.getElementById('submitReviewBtn');

        const updateButtonState = () => {
            let isStarSelected = false;
            starRatings.forEach(star => {
                if (star.checked) {
                    isStarSelected = true;
                }
            });

            const isReviewFilled = reviewTextarea.value.trim().length > 0;

            if (isStarSelected && isReviewFilled) {
                submitButton.removeAttribute('disabled');
            } else {
                submitButton.setAttribute('disabled', 'disabled');
            }
        };

        // Event listeners for stars and textarea
        starRatings.forEach(star => {
            star.addEventListener('change', updateButtonState);
        });

        reviewTextarea.addEventListener('input', updateButtonState);

        // Event listener for the submit button
        submitButton.addEventListener('click', (event) => {
            event.preventDefault(); // Mencegah submit form default

            Swal.fire({
                title: 'Ulasan Terkirim!',
                text: 'Terima kasih telah memberikan ulasan. Pendapat Anda sangat berarti bagi kami.',
                icon: 'success',
                confirmButtonText: 'Oke',
                confirmButtonColor: 'var(--accent-brown)' // Menggunakan variabel CSS untuk warna tombol
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'history'; 
                }
            });
        });

        // Set initial state of the button on page load
        updateButtonState();
    });
