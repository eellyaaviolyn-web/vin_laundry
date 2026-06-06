            <footer>
                <hr>
                <p>&copy; <?= date('Y') ?> LaundryPro - Aplikasi Manajemen Laundry Terpercaya</p>
            </footer>
            </div>
            </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
// Auto hide alert after 3 seconds
setTimeout(function() {
    $('.alert').fadeOut('slow');
}, 3000);

// Tooltip
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});
            </script>
            </body>

            </html>