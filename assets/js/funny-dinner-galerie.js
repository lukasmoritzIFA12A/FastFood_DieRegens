 document.querySelectorAll('.rating .fa-star').forEach(star => {
    star.addEventListener('click', function() {
        let rating = this.getAttribute('data-rating');
        document.querySelectorAll('.rating .fa-star').forEach(s => {
            s.classList.remove('selected');
        });
        this.classList.add('selected');
        this.previousElementSibling?.classList.add('selected');
        this.nextElementSibling?.classList.remove('selected');
    });
});

    function setOrderDetails(details) {
    document.getElementById('orderDetails').innerText = details;
}