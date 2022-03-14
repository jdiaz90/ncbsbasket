function showStatistics() {
    var regular = document.getElementById("statistics");
    var playoff = document.getElementById("playoffStats");

    var regularButton = document.getElementById("statisticsButton");
    var playoffButton = document.getElementById("playoffStatsButton");

    regular.style.display = "block";
    playoff.style.display = "none";

    regularButton.classList.add("disabled")
    regularButton.classList.add("active")
    playoffButton.classList.toggle("disabled")
    playoffButton.classList.toggle("active")
     
}

function showPlayoffStats() {
    var regular = document.getElementById("statistics");
    var playoff = document.getElementById("playoffStats");

    var regularButton = document.getElementById("statisticsButton");
    var playoffButton = document.getElementById("playoffStatsButton");

    playoff.style.display = "block";
    regular.style.display = "none";

    playoffButton.classList.add("disabled")
    playoffButton.classList.add("active")
    regularButton.classList.toggle("disabled")
    regularButton.classList.toggle("active")

}