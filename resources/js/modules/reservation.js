/**
 * Reservation Page Functionality
 */
export function initReservation() {
    const form = document.getElementById('reservationForm');
    if (form) {
        form.addEventListener('submit', handleReservationSubmit);
    }

    // Set minimum date to now (no past reservation)
    const dateInput = document.querySelector('input[name="reservation_date"]');
    if (dateInput) {
        const now = new Date();
        const iso = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0,16);
        dateInput.min = iso;
    }
}

/**
 * Handle reservation form submission
 */
async function handleReservationSubmit(e) {
    e.preventDefault();

    // prevent double submit via flag and disable submit button
    const submitBtn = e.target.querySelector('button[type="submit"]');
    if (submitBtn?.dataset.submitting === '1') return;
    if (submitBtn) {
        submitBtn.dataset.submitting = '1';
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }

    const form = e.target;
    const numberOfGuests = form.number_of_guests.value;
    const reservationDate = form.reservation_date.value;

    // Basic validation for required reservation fields
    if (!numberOfGuests || numberOfGuests < 1 || numberOfGuests > 20) {
        showToast('Number of guests must be between 1 and 20.', 'warning');
        resetSubmitBtn();
        return;
    }

    if (!reservationDate) {
        showToast('Please select a date and time for your reservation.', 'warning');
        resetSubmitBtn();
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

            showToast(errorMessage, 'error');
            return;
        }

        const responseData = JSON.parse(responseText);

        showToast('Reservation confirmed!', 'success');
        form.reset();
        window.location.href = '/';
    } catch (error) {
        console.error('Error:', error);
        showToast(error.message || 'Failed to connect to the server. Please try again.', 'error');
    }
    finally {
        resetSubmitBtn();
    }
}

function resetSubmitBtn() {
    const form = document.getElementById('reservationForm');
    const submitBtn = form?.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.dataset.submitting = '0';
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    }
}

function showToast(message, type = 'info') {
    // Re-use SweetAlert if available for nicer toast, otherwise fallback to simple DOM toast
    if (window.Swal && Swal.fire) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: type,
            title: message,
            showConfirmButton: false,
            timer: 2000,
        });
        return;
    }

    const notification = document.createElement('div');
    notification.className = `fixed top-20 right-6 px-6 py-3 rounded-lg shadow-lg ${type === 'success' ? 'bg-green-500 text-white' : type === 'warning' ? 'bg-yellow-400 text-black' : 'bg-red-500 text-white'}`;
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 2500);
}
