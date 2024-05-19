# EasyPractice Technical Challenge

Welcome to the EasyPractice tech challenge! Below you'll find a list of tasks to complete on this project. Make sure you're familiar with Git, Laravel and Vue.js before starting. This challenge should take no more than 3 hours.

## Working on the challenge

1. Clone the repo
2. Copy `.env.example` to `.env`
3. Update the `.env` file to include the correct database connection details
4. Run `composer install`, `php artisan key:generate`, `php artisan migrate`, `npm install` and `npm run dev` (ignore the build warnings)
5. Open up the project in the browser and click on "Register" to create a new user. All the work will be done while logged in.
6. Code indentation should be set up at 4 spaces in both PHP and JS files.
7. Work through the tasks in a new branch named `challenge/{your-name}`. Commit as often as you like.
8. Once you have completed the tasks, create a new [Pull Request](https://docs.github.com/en/github/collaborating-with-pull-requests/proposing-changes-to-your-work-with-pull-requests/creating-a-pull-request) and send us the link to it.

## The tasks

Complete as many as you can. If you got some time left, there's BONUS tasks, but they're not required ;)

**Solve this first:**
- [x] (BUG) I created some seeders that you can run with `php artisan db:seed`, but it gives an error. Can you make it work?

**And these in any order:**
- [X] (BUG) For some reason, the client bookings are not showing up in the front-end. Can you fix that?
- [X] (BUG) The list of bookings displayed on a client page has unformatted dates. Can you make sure they look something like this: `Monday 19 January 2020, 14:00 to 15:00`
- [X] (FEATURE) Currently, any logged-in user can view all of the system's clients, including those created by other users. Users are obviously not happy with that. Can you make it so that a single Client only belongs to one User?
- [X] (BUG) When trying to delete a client, the front-end does not update. Can you improve the experience, so the user knows the client was actually deleted? (tip: use `php artisan db:seed --class=ClientSeeder` to generate some clients if you have none)
- [X] (FEATURE) We noticed users started entering random data when creating clients. We should include some validation. Make sure that, when creating a client:
  - The `name` is up to 190 characters and it's required
  - The `email` is an actual valid email address. Hint: "arunas@example" is NOT a valid email address in our case.
  - The `phone` can only contain digits, spaces and a plus sign
  - At least one of (phone/email) is required
- [X] (FEATURE) The client bookings are currently displayed in random order. Please display them in chronological order, newest first.
- [X] (FEATURE) Users want a quick way to see future and past bookings. When viewing client bookings, can you make a dropdown with three values - "All bookings", "Future bookings only" and "Past bookings only". Make it so that selecting an item from the dropdown would only show bookings that apply to the selected filter. When the page loads, default to "All bookings".

**BONUS TASKS!**
- [X] *BONUS:* (FEATURE) Users have requested the ability to write journals for their clients. A Journal should have a date field (without hours/minutes) and a text field (unlimited length). A client can have many journals. A user should be able to view, create and delete journals.
- [X] *BONUS:* (REFACTOR) We strive for fast and readable code that follows Laravel's/Vue.js style and best practices. Take the time remaining and refactor any code you think can be improved, including ours. The goal is to leave the code better than you found it ;)

## Running with docker

1. Clone the repository.
2. Copy the `.env.docker.example` file, rename it as `.env.docker` and add the `ALPHA_VANTAGE_API_KEY`.
3. Start all the services defined with Docker Compose witht he command `docker-compose up -d`.
4. If the `vendor` folder is not created, run `docker-compose exec -it app composer install`.
5. Run this command `docker-compose exec -it app php artisan key:generate`.
6. If the `node-modules` folder is not created, run `docker-compose exec -it app npm install`.
7. The app will be running on `http://localhost:7000/`. 

To run the migrations, execute these commands:

1. Run the migrations with the command `docker-compose exec app php artisan migrate`.
2. Run the seeders with the commad `docker-compose exec app php artisan db:seed`.

You will be able to login with `test@example.com` and `password`.

## Testing

Run this command:

```php
php artisan test
```

Testing with Docker

```php
`docker-compose exec app php artisan test`
```

## Known issues

There's a compilation issue. To sort it, Bootstrap must be updated to version 5, or Bootstrap can be removed to use only Tawilwind. If keeping both, Tailwind can use a prefix to avoid collisions.

## Thank You!

Thank you so much for participating in this tech challenge. Hope you had fun! If you have any questions or suggestions, please email us at development@easypractice.net
