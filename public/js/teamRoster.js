function showRatings() {
    var ratings = document.getElementById("teamRatings");
    var bio = document.getElementById("teamBio");

    ratings.style.display = "block";
    bio.style.display = "none";
     
}

function showBio() {
    var ratings = document.getElementById("teamRatings");
    var bio = document.getElementById("teamBio");

    bio.style.display = "block";
    ratings.style.display = "none";

}