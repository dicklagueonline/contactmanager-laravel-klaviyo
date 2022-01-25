# Simple Contact Manager - Laravel app

## About

Simple contact manager app built with laravel, with the integration of klaviyo api to tracked user activity and sync user contacts.

### Prerequisites

Klaviyo Private/Public API keys - obtained by registering an account to klaviyo

KLAVIYO_PUBLIC_KEY - Klaviyo public api key

KLAVIYO_API_KEY - Klaviyo private api key

KLAVIYO_MEMBER_LIST_ID - List id of the container where all new registered profile will be grouped

### Getting Started

$ git clone <https://github.com/dicklagueonline/contactmanager-laravel-klaviyo.git> contact

$ cd contact

$ compser install

$ cp .env.example .env

$ php artisan key:generate

$ php artisan migrate

$ php artisan queue:work

$ php artisan serve
