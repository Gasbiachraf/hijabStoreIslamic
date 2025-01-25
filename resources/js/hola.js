document.addEventListener('DOMContentLoaded', () => {
    // Get the form
    const form = document.getElementById('checkout-form');

    // Listen for the form submission event
    form.addEventListener('submit', () => {
        // Loop through all `span` elements with IDs starting with "modal-quantity2-"
        document.querySelectorAll('[id^="modal-quantity2-"]').forEach(span => {
            const variantId = span.id.split('-')[2]; // Extract variant ID
            const sizeId = span.id.split('-')[3];    // Extract size ID

            // Generate the corresponding hidden input ID
            const hiddenInputId = `input-quantity2-${variantId}-${sizeId}`;

            // Get the hidden input
            const hiddenInput = document.getElementById(hiddenInputId);

            // If the hidden input exists, update its value with the span's content
            if (hiddenInput) {
                hiddenInput.value = span.textContent.trim(); // Update value
            }
        });
    });
});
