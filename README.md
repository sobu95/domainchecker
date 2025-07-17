# Domain Checker

This project provides a simple PHP application to monitor deleted domains and analyze them using Google Gemini API.

## Setup

1. Create a MySQL database and update `config.php` with your credentials.
2. Run `php install.php` to create tables. The script outputs cron commands required for domain fetching and processing.
3. Configure a web server (e.g., Apache or nginx) to serve the project directory.
4. Access `login.php` to sign in. You need to manually insert an admin user into the `users` table.

## Cron Jobs

- Daily download of deleted domains:
  ```
  php /path/to/cron/fetch_domains.php >> /var/log/fetch.log
  ```
- Query Google Gemini for new domains:
  ```
  php /path/to/cron/query_gemini.php >> /var/log/gemini.log
  ```
- Send summary and reminder emails:
  ```
  php /path/to/cron/send_emails.php >> /var/log/emails.log
  ```

## Notes

This is a basic implementation. The Gemini integration requires a valid API key.
