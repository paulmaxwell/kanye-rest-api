# Kanye REST API

## Getting Started

This project uses Laravel Sail.

Follow these steps to get up and running.

- Make sure you have Composer installed on your system.
- Make sure you have Docker installed and running.
- CD into the project folder
- Run `composer install`
- Run `sail up`
- The application should now be running at `localhost:80`
- Run database migratios with `sail artisan migrate`

The application should now be running. You can check by visiting `localhost:80` in the browser.

## Using the API

There is an API spec in the project directory called `api-spec.yml`. Copy the contents of this file into a REST client like Insomnia and it will generate all the API routes for you to interact with.

First, you must create a new user. Make a request to the `POST /user` endpoint, making sure to supply a unique email address. The response contains the API token for that user.

Use newly created token as a bearer token on the `GET /quotes` and `GET /fresh-quotes` endpoints.

The `GET /quotes` endpoint returns quotes from the cache. If none are cached, it retrieves new ones from the external API and updates the cache.

The `GET /fresh-quotes` endpoint will always retrieve new quotes from the external API and update the cache.

## Testing

Run the tests with `sail artisan test`.
