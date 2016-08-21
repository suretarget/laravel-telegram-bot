
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
- [Core Components](#core-components)
    - [`\SumanIon\TelegramBot\TelegramBot`](#sumaniontelegrambottelegrambot)
    - [`\SumanIon\TelegramBot\TelegramBotUser`](#sumaniontelegrambottelegrambotuser)
    - [`\SumanIon\TelegramBot\TelegramBotPermission`](#sumaniontelegrambottelegrambotpermission)
    - [`\SumanIon\TelegramBot\Manager`](#sumaniontelegrambotmanager)
    - [`\SumanIon\TelegramBot\Update`](#sumaniontelegrambotupdate)
    - [`\SumanIon\TelegramBot\Action`](#sumaniontelegrambotaction)
- [Available methods](#available-methods)
    - [class `TelegramBotUser`](#class-telegrambotuser)
        - [`permissions()`](#permissions)
        - [`getPermission($permission):TelegramBotPermission`](#getpermissionpermissiontelegrambotpermission)
        - [`hasPermission($permission):bool`](#haspermissionpermissionbool)
        - [`addPermission($permission):void`](#addpermissionpermissionvoid)
        - [`removePermission($permission):void`](#removepermissionpermissionvoid)
        - [`removeAllPermissions():void`](#removeallpermissionsvoid)

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
php artisan telegram:bot "Fully\Qualified\BotManagerClassName"
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
php artisan telegram:webhook "Fully\Qualified\BotManagerClassName"
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

&nbsp;

*At this point your bot is ready and it waits for you to make it awesome!*
*Now let's learn how to manage the bot.*

&nbsp;

## Core Components

#### `\SumanIon\TelegramBot\TelegramBot`

This class is an `Eloquent` model. It represens the bot and
helps to connect bots with their users and
ensures that every bot has an unique `webhook_token`.

*Example:*

```php
// Get the bot instance from our previous examples
$bot = \SumanIon\TelegramBot\TelegramBot::withManager('App\\Bots\\FirstTelegramBot');

// List all users of this bot
$bot_users = $bot->users;
```

#### `\SumanIon\TelegramBot\TelegramBotUser`

This class is an `Eloquent` model. It represents every user of the bot.
Every Telegram user who interacts with the bot is registered automatically
by the manager. This helps to know who is using the bot and to define
custom permissions to users.

#### `\SumanIon\TelegramBot\TelegramBotPermission`

This class is an `Eloquent` model.
Bot users may have permissions, and you can set custom permissions to every user.
A permission helps to limit or extend things an user can do with the bot.

*Let's create some permissions:*

```bash
# To create a permission run the following artisan command
php artisan telegram:permission can_receive_notifications

# To remove a premission run the following artisan command
php artisan telegram:permission my_permission --remove
```

*Now let's grant the user permission to receive notifications:*

```php
$bot_user = \SumanIon\TelegramBot\TelegramBotUser::find(1);
$bot_user->addPermission('can_receive_notifications');
```

*Now imagine that we have a blog and you want to notify*
*your bot users that you have a new post:*

```php
// ... A new post was created ...

// Get instance of the bot
$bot = \SumanIon\TelegramBot\TelegramBot::withManager('App\\Bots\\FirstTelegramBot');

// Get bot manager
$manager = $bot->getManager();

// Notify all bot users that a new post was created,
// but only the users who have the permission to receive notifications.
$manager->notify(function ($user, $manager) {
    if ($user->hasPermission('can_receive_notifications')) {
        $manager->sendMessage('A new blog post was created! Check it out!');
    }
});
```

#### `\SumanIon\TelegramBot\Manager`

This is the class that makes the *Telegram Bot Manager* so powerful,
and it contains all the methods you may need to create any kind of bot.

> **Note:** All *Managers* by default are stored in `/app/Bots/` folder.

*Lets have some fun with our bot:*

```php
// Get instance of the bot
$bot = \SumanIon\TelegramBot\TelegramBot::withManager('App\\Bots\\FirstTelegramBot');

// Get the manager
$manager = $bot->getManager();

// Get a user of our bot
$bot_user = $bot->users[0];

// Send him some messages
$manager->sendMessage($bot_user, 'Hello');
$manager->sendMessage($bot_user, 'How are you?');

// .. or maybe let's send him a photo
$manager->sendPhoto($bot_user, base_path('welcome.jpg'));

// .. or maybe a document
$manager->sendDocument($bot_user, base_path('welcome.docx'));

// Let's greet all users
$manager->notify('Hello!');

// .. but we have a nice photo, let's send it to all users
$manager->notify(function ($user, $manager) {
    $manager->sendPhoto($user, base_path('welcome.jpg'));
});

```

#### `\SumanIon\TelegramBot\Update`

This class contains all information about current *Update*.
An *Update* means that the bot user tries to interact with the bot in the chat.
*(For example when user sends a message to the bot, this is an Update;*
*When user sends a photo to the bot, this is also an Update)*.

*Example:*

*Let's imagine we have an user and he/she send a message to the bot:*

```
User: Hello!
```

*This is an Update, and it's contents may look like the following:*

```json
{
    "updateid": 123456789,
    "message": {
        "messageid": 123456789,
        "from": {
            "id": 123456789,
            "firstname": "Ion",
            "lastname": "Suman",
            "username": "sumanion"
        },
        "chat": {
            "chat_id": 123456789,
            "firstname": "Ion",
            "lastname": "Suman",
            "username": "sumanion"
        },
        "date": 123456789,
        "text": "Hello!"
    }
}
```

*By default update is received as `JSON` string,*
*but it is then converted to the `Update` object to add additional flexibility.*
*You can access information from the Update like object properties:*

```php
// Get the text of the message
echo $update->message->text; // Hello!
```

#### `\SumanIon\TelegramBot\Action`

**The most powerful feature** of the *Telegram Bot Manager* are the *Actions*.
An *Action* is a class that defines how bot will process received *Updates*.
An *Update* may have as many *Actions* as you want.
They all may respond to a single *Update* or they can chose specific updates
which match their requirements.

> **Note:** All *Actions* by default are stored in `/app/Bots/Actions/` folder.

To create an action, run the following artisan command:

```bash
php artisan telegram:action ActionClassName
```

*For example:*

```bash
php artisan telegram:action SayHello
```

Then, you have to add the action's class name to the `$actions` array property
from the bot manager.

Open the bot manager class file *(in our example `/app/Bots/FirstTelegramBot.php`)*
with your favorite text editor and add the action.

*In our example this will look like:*

```php
protected $actions = [
    Actions\SayHello::class,
];
```

All *Actions* come with some default methods. The main method we are interested in
is the `handle()` method. This method describes how the *Action* should respond to the *Update*.

Open the action class file with your favorite text editor
*(in our example `/app/Bots/Actions/SayHello.php`)*.

Next, let's add some functionality.
Let's repeat the example we had earlier with some code.

*We want to respond to user with `Hello, User!` when the user says hello:*

```php
public function handle()
{
    $this->sendMessage('Hello, User!');
}
```

Now, when the user will send a message to the bot,
he/she will receive a response message with the text `Hello, User!`.

*Now let's make it more dynamic:*

```php
public function handle()
{
    $this->sendMessage("Hello, {$this->user->first_name}");
}
```

This time we will respond with `Hello, ` followed by the user's first name.

*Now let's make the bot more smart, so it will respond only when user says `Hello`:*

```php
public function handle()
{
    $this->respondsToPattern('/^hello/i');
    $this->sendMessage("Hello, {$this->user->first_name}!");
}
```

This time the user will receive the response message `Hello, User!`
only when he/she will send a message starting with the word `hello`.

# Available methods

> **Note:** All available classes are within `\SumanIon\TelegramBot\` namespace.

### class `TelegramBotUser`

##### `permissions()`

`Eloquent` relationship which returns all permissions of the user.

##### `getPermission($permission):TelegramBotPermission`

This method just returns an instance of `TelegramBotPermission` based on the `$permission`.

- `$permission` (`string`, `TelegramBotPermission`)

##### `hasPermission($permission):bool`

Use this method to check if user has a specific permission.

- `$permission` (`string`, `TelegramBotPermission`)

*Example code:*

```php
// Send a message to the user if it has required permission.
if ($bot_user->hasPermission('can_receive_notifications')) {
    $bot_manager->sendMessage($bot_user, 'Hello!');
}
```

##### `addPermission($permission):void`

This method will add a new Permission to the user.

- `$permission` (`string`, `TelegramBotPermission`)

*Example code:*

```php
// This will search a Permission with the name of 'can_receive_notifications'
// and if it exists it will add that permission to the user.
// Note: to create a new permission use artisan command: telegarm:permission {name}
$bot_user->addPermission('can_receive_notifications');
```

##### `removePermission($permission):void`

Remove a permission from the user.

- `$permission` (`string`, `TelegramBotPermission`)

*Example code:*

```php
// This will remove a permission with name 'can_receive_notifications' from the user.
// If the user doesn't have this permission nothing will happen.
$bot_user->removePermission('can_receive_notifications');
```

##### `removeAllPermissions():void`

Remove all permissions from the user.

*Example code:*

```php
$bot_user->removeAllPermissions();
```
