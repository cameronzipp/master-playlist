/*fetch('music.json')
    .then(function (response) {
        return response.json();
    })
    .then(function (data) {
        appendData(data);
    })
    .catch(function (err) {
        console.log(err);
    });

function appendData(data) {
    let output = document.getElementById("songData");

    const resultLimit = 50;

    for (let i = 0; i < data.length; i++) {
        //append each person to the page
        let div = document.createElement("div");
        div.document.addClass("entry")

        const artistName = data[i].artist.name;
        const songTitle = data[i].song.title;

        div.innerHTML = "Artist Name: " + artistName + " " + " Song: " + songTitle;

        // if ()
        output.appendChild(div);
    }
}*/
let count = 0;
let page1 = document.createElement("div");
let page2 = document.createElement("div")
let page3 = document.createElement("div");
let page4 = document.createElement("div");
let output = document.getElementById("songData");

$.getJSON("music.json", function(result) {
    $.each(result, function(index, item) {
        let div = document.createElement("div");
        const artistName = item.artist.name;
        const songTitle = item.song.title;

        if (count < 50) {
            div.innerHTML += artistName + " - " + songTitle + "<br>";
            page1.appendChild(div);
            /*index + ": " + item.artist.name + " - " + item.song.title + "<br>"*/
            count++;
        } else if (count > 50 && count < 100) {
            $(page2).append(index + ": " + item.artist.name + " - " + item.song.title + "<br>");
            count++;
        } else if (count > 100 && count < 150) {
            $(page3).append(index + ": " + item.artist.name + " - " + item.song.title + "<br>");
            count++;
        } else {
            $(page4).append(index + ": " + item.artist.name + " - " + item.song.title + "<br>");
            count++;
        }
    })
    output.appendChild(page1);
})

$(document).ready( function () {
    $('#myTable').DataTable();
} );