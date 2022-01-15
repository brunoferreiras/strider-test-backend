# Posterr
## Gettings Started
It's need to install in your computer:
`Docker: 18.06.0+`
`Docker-compose: 1.27.0+`

Execute this commands to start the application:
```bash
// Create the .env file
cp .env.example .env
// Start all containers docker
docker-compose up -d
// Enter in container
make bash
// Generate the key
php artisan key:generate
// It's everything!
```
## Framework
- [Laravel](https://laravel.com/)
## Database
- MySQL 8.0

## API Docs
### Get all posts
**Request**
```bash
curl --location --request GET 'localhost:8040/api/v1/posts'
```
**Status**
```text
HTTP 200
```
**Response**
```json
{ "current_page": 1, "data": [ { "id": 1, "content": "asdasd", "user_id": 1, "created_at": "2022-01-15T18:41:01.000000Z", "updated_at": "2022-01-15T18:41:01.000000Z", "reposts": [], "quote_posts": [] }, { "id": 2, "content": "asdasd", "user_id": 1, "created_at": "2022-01-15T18:41:02.000000Z", "updated_at": "2022-01-15T18:41:02.000000Z", "reposts": [], "quote_posts": [] }, { "id": 3, "content": "asdasd", "user_id": 1, "created_at": "2022-01-15T18:41:03.000000Z", "updated_at": "2022-01-15T18:41:03.000000Z", "reposts": [], "quote_posts": [] }, { "id": 4, "content": "asdasd", "user_id": 1, "created_at": "2022-01-15T18:41:04.000000Z", "updated_at": "2022-01-15T18:41:04.000000Z", "reposts": [], "quote_posts": [] }, { "id": 5, "content": "asdasd", "user_id": 1, "created_at": "2022-01-15T18:41:04.000000Z", "updated_at": "2022-01-15T18:41:04.000000Z", "reposts": [], "quote_posts": [] }, { "id": 6, "content": "asdasd", "user_id": 1, "created_at": "2022-01-15T18:41:05.000000Z", "updated_at": "2022-01-15T18:41:05.000000Z", "reposts": [], "quote_posts": [] } ], "first_page_url": "http://localhost:8040/api/v1/posts?page=1", "from": 1, "last_page": 1, "last_page_url": "http://localhost:8040/api/v1/posts?page=1", "links": [ { "url": null, "label": "&laquo; Previous", "active": false }, { "url": "http://localhost:8040/api/v1/posts?page=1", "label": "1", "active": true }, { "url": null, "label": "Next &raquo;", "active": false } ], "next_page_url": null, "path": "http://localhost:8040/api/v1/posts", "per_page": 15, "prev_page_url": null, "to": 6, "total": 6 }
```

### Get all posts following
**Request**
```bash
curl --location --request GET 'localhost:8040/api/v1/posts/following?user_id=6'
```
**Status**
```text
HTTP 200
```
**Response**
```json
{ "current_page": 1, "data": [ { "id": 1, "content": "asdasd", "user_id": 1, "created_at": "2022-01-15T18:41:01.000000Z", "updated_at": "2022-01-15T18:41:01.000000Z", "reposts": [], "quote_posts": [] }, { "id": 2, "content": "asdasd", "user_id": 1, "created_at": "2022-01-15T18:41:02.000000Z", "updated_at": "2022-01-15T18:41:02.000000Z", "reposts": [], "quote_posts": [] }, { "id": 3, "content": "asdasd", "user_id": 1, "created_at": "2022-01-15T18:41:03.000000Z", "updated_at": "2022-01-15T18:41:03.000000Z", "reposts": [], "quote_posts": [] }, { "id": 4, "content": "asdasd", "user_id": 1, "created_at": "2022-01-15T18:41:04.000000Z", "updated_at": "2022-01-15T18:41:04.000000Z", "reposts": [], "quote_posts": [] }, { "id": 5, "content": "asdasd", "user_id": 1, "created_at": "2022-01-15T18:41:04.000000Z", "updated_at": "2022-01-15T18:41:04.000000Z", "reposts": [], "quote_posts": [] }, { "id": 6, "content": "asdasd", "user_id": 1, "created_at": "2022-01-15T18:41:05.000000Z", "updated_at": "2022-01-15T18:41:05.000000Z", "reposts": [], "quote_posts": [] } ], "first_page_url": "http://localhost:8040/api/v1/posts?page=1", "from": 1, "last_page": 1, "last_page_url": "http://localhost:8040/api/v1/posts?page=1", "links": [ { "url": null, "label": "&laquo; Previous", "active": false }, { "url": "http://localhost:8040/api/v1/posts?page=1", "label": "1", "active": true }, { "url": null, "label": "Next &raquo;", "active": false } ], "next_page_url": null, "path": "http://localhost:8040/api/v1/posts", "per_page": 15, "prev_page_url": null, "to": 6, "total": 6 }
```

### Get profile
**Request**
```bash
curl --location --request GET 'localhost:8040/api/v1/users/brunoferreiras/profile'
```
**Status**
```text
HTTP 200
```
**Response**
```json
{ "username": "brunoferreiras", "date_joined": "Jan 15, 2022", "total_followers": 0, "total_following": 0, "total_posts": 6 }
```

### Create user
**Request**
```bash
curl --location --request POST 'localhost:8040/api/v1/users' \
--header 'Content-Type: application/json' \
--data-raw '{
    "name": "Bruno Ferreira",
    "username": "brunoferreiras"
}'
```
**Status**
```text
HTTP 201
```
**Response**
```json
{ "name": "Bruno Ferreira", "username": "brunoferreiras", "updated_at": "2022-01-15T19:58:31.000000Z", "created_at": "2022-01-15T19:58:31.000000Z", "id": 1 }
```

### Create Post
**Request**
```bash
curl --location --request POST 'localhost:8040/api/v1/posts' \
--header 'Content-Type: application/json' \
--data-raw '{
    "content": "any text",
    "user_id": 1
}'
```
**Status**
```text
HTTP 201
```
**Response**
```json
{ "content": "any text", "user_id": 1, "updated_at": "2022-01-15T19:59:07.000000Z", "created_at": "2022-01-15T19:59:07.000000Z", "id": 1 }
```

### Create Repost
**Request**
```bash
curl --location --request POST 'localhost:8040/api/v1/posts/1/repost' \
--header 'Content-Type: application/json' \
--data-raw '{
    "comment": "",
    "user_id": 1
}'
```
**Status**
```text
HTTP 201
```
**Response**
```json
{ "comment": null, "user_id": 1, "post_id": "1", "updated_at": "2022-01-15T19:59:47.000000Z", "created_at": "2022-01-15T19:59:47.000000Z", "id": 1 }
```

### Create Quote post
**Request**
```bash
curl --location --request POST 'localhost:8040/api/v1/posts/1/repost' \
--header 'Content-Type: application/json' \
--data-raw '{
    "comment": "any comment",
    "user_id": 1
}'
```
**Status**
```text
HTTP 201
```
**Response**
```json
{ "comment": "any comment", "user_id": 1, "post_id": "1", "updated_at": "2022-01-15T19:59:47.000000Z", "created_at": "2022-01-15T19:59:47.000000Z", "id": 1 }
```

### Follow
**Request**
```bash
curl --location --request POST 'localhost:8040/api/v1/users/brunoferreiras/follow' \
--header 'Content-Type: application/json' \
--data-raw '{
    "follower_id": 6,
    "following_id": 5
}'
```
**Status**
```text
HTTP 204
```
**Response**
```json
```

### Unfollow
**Request**
```bash
curl --location --request POST 'localhost:8040/api/v1/users/brunoferreiras/unfollow' \
--header 'Content-Type: application/json' \
--data-raw '{
    "follower_id": 1,
    "following_id": 2
}'
```
**Status**
```text
HTTP 204
```
**Response**
```json
```

## Cobertura de testes

Execute the tests:
```bash
// Outside container
make test
// Inner container
./vendor/bin/phpunit --testdox --verbose
```
![Coverage](./docs/coverage.png)
