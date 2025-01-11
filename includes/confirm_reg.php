<?php

# Registration Confirmation Modal #
echo '
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Registration successful</h5>
                <button type="button" class="close" aria-label="Close">✕</button>
            </div>
            <div class="modal-body">
                Thank you! You are now registered.
            </div>
            <div class="modal-footer">
                <a href="../public/login.php" class="btn btn-dark">Login</a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var modal = new bootstrap.Modal(document.getElementById("cartModal"));
        modal.show();
    });
</script>
';

?> 