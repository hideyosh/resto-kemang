/**
 * Reservation Page Functionality
 */
export function initReservation() {
    const form = document.getElementById('reservationForm');
    if (form) {
        form.addEventListener('submit', handleReservationSubmit);
    }
}

/**
 * Handle reservation form submission
 */
async function handleReservationSubmit(e) {
    e.preventDefault();

    const form = e.target;
    const numberOfGuests = form.number_of_guests.value;
    const reservationDate = form.reservation_date.value;

    // Basic validation for required reservation fields
    if (!numberOfGuests || numberOfGuests < 1 || numberOfGuests > 20) {
        Swal.fire({
            icon: 'warning',
            title: 'Validation Error',
            text: 'Number of guests must be between 1 and 20.',
        });
        return;
    }

    if (!reservationDate) {
        Swal.fire({
            icon: 'warning',
            title: 'Validation Error',
            text: 'Please select a date and time for your reservation.',
        });
        return;
    }

    const data = {
        number_of_guests: parseInt(numberOfGuests),
        reservation_date: reservationDate,
        notes: form.notes.value || null,
    };

    try {
        const response = await fetch('/api/reservations', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]')?.value,
            },
            body: JSON.stringify(data),
        });

        const responseText = await response.text();

        if (!response.ok) {
            console.error('Response status:', response.status);
            console.error('Response body:', responseText);

            let errorMessage = 'An error occurred while booking your reservation.';
            try {
                const errorData = JSON.parse(responseText);
                if (errorData.message) {
                    errorMessage = errorData.message;
                } else if (errorData.errors) {
                    const errors = Object.entries(errorData.errors)
                        .map(([field, messages]) => {
                            const fieldLabel = field
                                .replace(/_/g, ' ')
                                .replace(/^\w/, c => c.toUpperCase());
                            return `${fieldLabel}: ${Array.isArray(messages) ? messages[0] : messages}`;
                        })
                        .join('\n');
                    errorMessage = errors;
                }
            } catch (parseError) {
                console.error('Failed to parse error response:', parseError);
            }

            Swal.fire({
                icon: 'error',
                title: 'Reservation Failed',
                text: errorMessage,
            });
            return;
        }

        const responseData = JSON.parse(responseText);

        Swal.fire({
            icon: 'success',
            title: 'Reservation Confirmed!',
            text: 'Your table reservation has been booked successfully.',
        }).then(() => {
            form.reset();
            window.location.href = '/';
        });
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Connection Error',
            text: error.message || 'Failed to connect to the server. Please try again.',
        });
    }
}
