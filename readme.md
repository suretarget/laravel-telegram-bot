
<p align="center">
    <img src="https://telegram.org/img/tl_card_connect.gif" width="160">
</p>

# Telegram Bot Manager for Laravel

**[Telegram Bot Manager](https://github.com/sumanion/laravel-telegram-bot)**
is an expressive and powerful way to manage
[Telegram Bots](https://telegram.org/blog/bot-revolution)
from [Laravel](https://laravel.com/) applications.

> **Telegram** is a popular cloud-based mobile and desktop messaging app
with a focus on security and speed.

> [Telegram](https://telegram.org/)

> **Telegram Bots** are simply Telegram accounts operated by software – not people – and they'll often have AI features. They can do anything – teach, play, search, broadcast, remind, connect, integrate with other services, or even pass commands to the Internet of Things.

> [Telegram Bot Platform](https://telegram.org/blog/bot-revolution)

With **Telegram Bot Manager** you can create simple *Telegram Bots* in no time and
advanced bots in a few minutes. *Telegram Bot Manager* can do pretty much anything the
[Telegram Bot API](https://core.telegram.org/bots/api) allows them to do,
from sending simple notifications to your users to create full featured bots
in a nice way with beautiful and easy to understand code.

> There are some steps required to install and to configure the *Telegram Bot Manager*,
  and at the first look it can seem overwhelming, but trust me, when you done it at least one time,
  next times it will take you less than a minute to install and to configure the package.

## Table of contents

- [Installation](#installation)
    - [Step 1: Composer](#step-1-composer)
    - [Step 2: Service Provider](#step-2-service-provider)
    - [Step 3: Migration](#step-3-migration)
- [Configuration](#configuration)
    - [Step 1: Create your bot](#step-1-create-your-bot)
    - [Step 2: Create a *Manager* for your bot](#step-2-create-a-manager-for-your-bot)
    - [Step 3: Add your bot's API Token to the Manager](#step-3-add-your-bots-api-token-to-the-manager)
    - [Step 4: Register the bot in your application](#step-4-register-the-bot-in-your-application)
    - [Step 5: Set up Webhook (optional)](#step-5-set-up-webhook-optional)

## Installation

### Step 1: Composer

From the command line, run:

```
composer require sumanion/laravel-telegram-bot
```

### Step 2: Service Provider

For your Laravel app, open `config/app.php` and, within the `providers` array, append:

```php
SumanIon\TelegramBot\Providers\TelegramBotServiceProvider::class,
```

### Step 3: Migration

*Telegram Bot Manager* uses some database tables to work with bots and bots users,
so you have to migrate the database first.

From your Laravel app, run the following artisan command:

```
php artisan migrate
```

*- This will create required tables.*

*Now you're almost ready to create awesome Telegram Bots.*

## Configuration

### Step 1: Create your bot

*If you already have a Telegram Bot you can skip this step.*

To create a new bot, open [@BotFather](https://telegram.me/BotFather) bot in Telegram,
it is the official way to create and configure Telegram Bots.
It has nice instructions which are easy to follow and understand.
[Click here for more info on how to create bots](https://core.telegram.org/bots#botfather).

After you have created the bot you will receive an *API Token*
which looks something like `123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11`,
copy it and move to the next step.

### Step 2: Create a *Manager* for your bot

A *Manager* is a class which contains all the methods used to manage your bots.
Don't worry if you don't understand what a *Manager* is,
we will return to managers later, for now just create one.

**Each bot must have a dedicated Manager.**
To create a Manager use the following artisan command
(it is similar to how you create `models` and `controllers`):

```
php artisan telegram:manager ManagerClassName
```

**Example:**

```
php artisan telegram:manager FirstTelegramBot
```

*- This command will create a manager class in `/app/Bots/FirstTelegramBot.php`.*

### Step 3: Add your bot's API Token to the *Manager*

Open the manager class which you have created in **Step 2**
*(in our example `/app/Bots/FirstTelegramBot.php`)* with your favorite text editor.
It comes with some default methods and properties.
In the `token()` method's return value enter your bot's API Token.

**In our example it will look like this:**

```php
public function token()
{
    return '123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11';
}
```

### Step 4: Register the bot in your application

To be able to use bots you have to register them in your Laravel application
and to assign them the *Manager* you have created.
To register the bot in your Laravel application run the following artisan command:

```
php artisan telegram:bot "Full\Qualified\BotManagerClassName"
```

**In our example it will look like this:**

```
php artisan telegram:bot "App\Bots\FirstTelegramBot"
```

*- This will register the bot and will assign it the manager.*

### Step 5: Set up Webhook (optional)

You can set up Telegram to send Webhook requests to your bot
each time your bot users write it messages.

This helps to come with almost instant responses to your bot users.

**Example:**

```
User: Hello, bot!
Bot: Hello, User!
```

*- Imagine we have a dummy bot which greets it's users.
When a user writes a message in chat with the bot `User: Hello, bot!`,
the bot almost instantly is notified about that message along with
all information which belongs to that message, and the bot can
instantly send response back to the chat `Bot: Hello, User!`.*

To set up the Webhook, run the following artisan command:

```
php artisan telegram:webhook "Full\Qualified\BotManagerClassName"
```

**In our example it will look like:**

```
php artisan telegram:webhook "App\Bots\FirstTelegramBot"
```

*- Now your bot is ready to receive and handle Webhooks.*

> **Important:** Webhooks work only with `HTTPS` protocol,
  and if your website uses `HTTP` you won't be able to use Webhooks,
  that's a Telegram API limitation.

> **Note:** You can use `valet share` to get public `HTTPS` link
  to your local project and you will be able to test Webhooks on a dev machine.
  [Learn more about `Laravel Valet`](https://laravel.com/docs/master/valet).
