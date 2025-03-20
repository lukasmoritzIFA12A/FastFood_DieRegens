document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".star");
    let rating = 0;

    stars.forEach(star => {
        star.addEventListener("click", function () {
            rating = this.getAttribute("data-value");
            alert(rating);

            // Alle Sterne zurücksetzen
            stars.forEach(s => s.classList.remove("active"));

            // Aktive Sterne färben
            for (let i = 0; i < rating; i++) {
                stars[i].classList.add("active");
            }
        });
    });
});

document.getElementById("star1").addEventListener("click", function () {
    if (this.classList.contains("bi-star-fill")) {
        this.classList.remove("bi-star-fill");
        this.classList.add("bi-star");
        document.getElementById("star1Fill").style.display = "none";
        document.getElementById("star1Empty").style.display = "";

    } else {
        this.classList.remove("bi-star");
        this.classList.add("bi-star-fill");
        document.getElementById("star1Fill").style.display = "";
        document.getElementById("star1Empty").style.display = "none";
    }
});

document.getElementById("star2").addEventListener("click", function () {
    this.setAttribute("stroke", this.getAttribute("stroke") === "black" ? "red" : "black");
});

document.getElementById("star3").addEventListener("click", function () {
    this.setAttribute("stroke", this.getAttribute("stroke") === "black" ? "red" : "black");
});

document.getElementById("star4").addEventListener("click", function () {
    this.setAttribute("stroke", this.getAttribute("stroke") === "black" ? "red" : "black");
});

document.getElementById("star5").addEventListener("click", function () {
    this.setAttribute("stroke", this.getAttribute("stroke") === "black" ? "red" : "black");
});