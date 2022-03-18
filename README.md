# Master Playlist

Master Playlist is a Web application that uses the [Music Corgis dataset](https://think.cs.vt.edu/corgis/json/music/) to
create and manage song playlists. Users will be greeted with a home screen showcasing an example playlist. Once logged
in they will be able to create a new playlist. Once the playlist is created, users will be able to search songs that
they would like to add on their playlist. They can add and remove songs, and also view song information, list duration,
artist info and more. Scale wise the MVP is getting the Corgi dataset working properly. From there we’d like to expand
into using the [Spotify API](https://developer.spotify.com/documentation/web-api/quick-start/),
[Soundcloud API](https://developers.soundcloud.com/docs/api/guide), and other music sharing websites.

# Contributors
Cameron Zipp, Pavel Krokhalev, and Abdikafi Jama

# Requirements

1. Separates all database/business logic using the MVC pattern.
   1. This can be viewed through the github directory.
2. Routes all URLs and leverages a templating language using the Fat-Free framework.
   1. The routes are all defined in the `controller/controller.php` file.
   2. The templates are all in the `views/` directory.
3. Has a clearly defined database layer using PDO and prepared statements.
   1. Located in the `model/datalayer.php` file.
4. Data can be added and viewed.
   1. You can select what songs you'd like to add to the playlist and view those in your personal playlist.
5. Has a history of commits from both team members to a Git repository. Commits are clearly commented.
   1. Viewed through GitHub commits tab.
6. Uses OOP, and utilizes multiple classes, including at least one inheritance relationship.
   1. Followed throughout the whole project. There is one inheritance relationship used between the `AdminUser` and `User`.
7. Contains full Docblocks for all PHP files and follows PEAR standards.
   1. Each PHP file has sufficient DocBlocks and follows PEAR standards.
8. Has full validation on the client side through JavaScript and server side through PHP.
   1. Does not have full client-side validation (other than HTML), but has server side validation through PHP.
9. All code is clean, clear, and well-commented. DRY (Don't Repeat Yourself) is practiced.
   1. This can be viewed throughout the project.
10. Your submission shows adequate effort for a final project in a full-stack web development course.
    1. This can be viewed throughout the project.
11. BONUS:  Incorporates Ajax that access data from a JSON file, PHP script, or API. If you implement Ajax, be sure to include how you did so in your readme file.
    1. We use Ajax to dynamically update the DataTables in our project. a Json Object is created through the Ajax route
       and is handled through the `scripts/dataTable.js` script.


# Prototypes ([Google File](https://docs.google.com/presentation/d/13YMkGm6H6Ul78zkcRolqZ5Epgg-Sc29LEd6dPj8veDQ/edit#slide=id.g10fc1302f6a_0_234))

## Desktop
![Team10 Desktop View](https://user-images.githubusercontent.com/78177750/151443552-2574b4a8-4786-47f1-83de-910921d7c421.png)
## Tablet
![Team10 Tablet View](https://user-images.githubusercontent.com/78177750/151443885-9df75914-6fb8-4c0b-8545-32452e60bde3.png)
## Mobile
![Team10 Mobile View](https://user-images.githubusercontent.com/78177750/151443902-0a768640-7fd4-499f-a966-6b178469b385.png)
## Class Diagram
![Team10 Class Diagram](https://user-images.githubusercontent.com/78177750/151443917-736101a2-3201-464e-a40f-f7b52f0cebe9.png)
## ER Diagram
![Team10 ER Diagram](https://user-images.githubusercontent.com/78177750/151443934-2250a76c-cf33-4995-9a2d-0d8978ad5ed5.png)
