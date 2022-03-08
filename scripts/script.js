fetch('music.json')
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
    var output = document.getElementById("songData");

    for (let i = 0; i < data.length; i++) {
        //append each person to the page
        var div = document.createElement("div");
        div.innerHTML = "Artist Name: " + data[i].artist.name + " " + " Song: " + data[i].song.title;

        output.appendChild(div);
    }
}
