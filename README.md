# Email Parser Application

## Setup Instructions

### Requirements

- PHP >= 8.2
- Composer
- MySQL

### Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/maheshdama13/email-parser.git
   cd email-parser
   ```
2. Install dependencies:
    ```bash
    composer install
    ```
3. Set up environment variables:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
- Update .env with your database credentials and other necessary settings.
4. Run migrations:
    ```bash
    php artisan migrate
    ```
5. Run the Seeder
    ```bash
    php artisan db:seed --class=UsersTableSeeder
    ``` 
6. Generate application key:
    ```bash
    php artisan key:generate
    ```
7. Serve the application:
    ```bash
    php artisan serve
    ```
### Running the Email Parsing Command
The email parsing command runs automatically every hour. To manually run it:
  ```bash
  php artisan emails:parse-and-extract
  ```


### API Endpoints
#### Authentication
Use Sanctum for API authentication. Generate a token for demo user.
`POST /api/tokens/create`
Response Body:
```json
{
    "token": "1|6yHlUoQ98l3YPiiQSAwAoCKpeGnLhTavUma8NUe9022d70ae"
}
```

Copy the token and add in the Header with "Bearer" text prepend for all the rest of requests
e.g. 

`Authorization: Bearer 1|6yHlUoQ98l3YPiiQSAwAoCKpeGnLhTavUma8NUe9022d70ae`

`POST /api/emails`
Example Request Body:
  ```json
  {
    "affiliate_id": 1,
    "envelope": "envelope data",
    "from": "sender@example.com",
    "subject": "Subject",
    "dkim": "dkim data",
    "SPF": "SPF data",
    "spam_score": 0.1,
    "email": "raw email data",
    "sender_ip": "127.0.0.1",
    "to": "receiver@example.com",
    "timestamp": 1620000000
  }
  ```

  Get by ID
  `GET /api/emails/{id}`
  Example Response:
  ```json
  {
    "id": 1,
    "affiliate_id": 1,
    "envelope": "envelope data",
    "from": "sender@example.com",
    "subject": "Subject",
    "dkim": "dkim data",
    "SPF": "SPF data",
    "spam_score": 0.1,
    "email": "raw email data",
    "raw_text": "plain text email content",
    "sender_ip": "127.0.0.1",
    "to": "receiver@example.com",
    "timestamp": 1620000000,
    "created_at": "2023-06-18T12:34:56.000000Z",
    "updated_at": "2023-06-18T12:34:56.000000Z",
    "deleted_at": null
  }
  ```

  Update
  `PUT /api/emails/{id}`
  Example Request Body:
  ```json
  {
    "subject": "Updated Subject",
    "spam_score": 0.2
  }
  ```
  Example Response:
  ```json
  {
    "id": 1,
    "affiliate_id": 1,
    "envelope": "envelope data",
    "from": "sender@example.com",
    "subject": "Updated Subject",
    "dkim": "dkim data",
    "SPF": "SPF data",
    "spam_score": 0.2,
    "email": "raw email data",
    "raw_text": "plain text email content",
    "sender_ip": "127.0.0.1",
    "to": "receiver@example.com",
    "timestamp": 1620000000,
    "created_at": "2023-06-18T12:34:56.000000Z",
    "updated_at": "2023-06-18T12:45:56.000000Z",
    "deleted_at": null
  }
  ```

  Get All
  `GET /api/emails`
  Example Response:
  ```json
  [
    {
        "id": 1,
        "affiliate_id": 1,
        "envelope": "envelope data",
        "from": "sender@example.com",
        "subject": "Subject",
        "dkim": "dkim data",
        "SPF": "SPF data",
        "spam_score": 0.1,
        "email": "raw email data",
        "raw_text": "plain text email content",
        "sender_ip": "127.0.0.1",
        "to": "receiver@example.com",
        "timestamp": 1620000000,
        "created_at": "2023-06-18T12:34:56.000000Z",
        "updated_at": "2023-06-18T12:34:56.000000Z",
        "deleted_at": null
    },
    ...
  ]```

  Delete by ID
  `DELETE /api/emails/{id}`
  Example Response:
  ```json
  {
    "message": "Email record deleted successfully"
  }
  ```


### Set Up Cron Job for Parsing Command:
  - Open the crontab editor:
    ```bash
    crontab -e
    ```
  - Add the following line to run the command every hour:
    ```bash
    0 * * * * /PROJECT-PATH/artisan emails:parse-and-extract
    ```
