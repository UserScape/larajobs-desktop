<p align="center"><a href="https://larajobs.com" target="_blank"><img src="https://raw.githubusercontent.com/LukeTowers/larajobs-desktop/main/public/images/larajobs.svg" width="400" alt="LaraJobs Logo"></a></p>

# LaraJobs Desktop

An open source NativePHP menu bar application for MacOS, providing instant notifications when new jobs are posted on LaraJobs.

## Description

LaraJobs Desktop is a convenient way to stay updated with the latest job postings from LaraJobs. The application sits in your menu bar, providing non-intrusive notifications and a quick overview of new job opportunities, ensuring you never miss out on your dream job.

### Features:
- Get notified about new job postings
- View list of most recent job postings
- Quick links to submit postings or search for Laravel Consultants
- Global hotkey to open the app (default: `CmdOrCtrl+Shift+J`)
- Send batched notifications, just one, or an explicit "No new jobs" depending on the number of new jobs identified.

<img width="352" alt="Notification with single new job" src="https://raw.githubusercontent.com/LukeTowers/larajobs-desktop/main/public/images/screenshots/notification-single.png">
<img width="364" alt="Notification with multiple new jobs" src="https://raw.githubusercontent.com/LukeTowers/larajobs-desktop/main/public/images/screenshots/notification-multi.png">
<img width="356" alt="Notification with no new jobs" src="https://raw.githubusercontent.com/LukeTowers/larajobs-desktop/main/public/images/screenshots/notification-none.png">

<br>

<img width="411" alt="Jobs list" src="https://raw.githubusercontent.com/LukeTowers/larajobs-desktop/main/public/images/screenshots/jobs-list.png">
<img width="243" alt="MenuBar context menu item" src="https://raw.githubusercontent.com/LukeTowers/larajobs-desktop/main/public/images/screenshots/menubar-context.png">

## Roadmap

We have big plans for LaraJobs Desktop! Here are some features we're considering for future releases:

- (WIP) - Ability to filter jobs by keyword, location, etc (see https://github.com/LukeTowers/larajobs-desktop/tree/wip/filtering-support)
- Watch jobs functionality to keep track of jobs.
- Click on a notification to see quick job details, with an option to go to the site.
- Save job application details for easy reviewing later and to reduce effort required when applying to new jobs.
- Track application status and write notes.
- Backup / restore of settings.
- Show timezone difference to current location.

## Prerequisites

The LaraJobs Desktop application currently only supports MacOS. You will also need PHP, Composer, Node, & Yarn installed on your system. Recommended to use [Laravel Herd](https://herd.laravel.com/) and then install yarn via Homebrew (`brew install yarn`).

## Installation

1. Download the project (`git clone git@github.com:LukeTowers/larajobs-desktop.git larajobs-desktop`
2. Run `cd larajobs-desktop && composer install && npm install && npm run build`
3. Run `php artisan native:serve`

Future Plans:
- Fix publishing / building - currently the builds produced by `native:build` or `native:publish` don't actually register the `MenuBar` for some reason.
- Automate building releases on publishing new tags through Github actions
- Add support for preferences (i.e. filtering, refresh frequency, etc)
- Ability to explicitly hide jobs

## Usage

Use LaraJobs Desktop to stay informed about new jobs.

## Potential Issues

### Notifications aren't displaying:

Please make sure that notifications are enabled for the app. When running `php artisan native:serve` notifications are sent from the "Electron" app.

Broken:
![Electron notifications 1](https://raw.githubusercontent.com/LukeTowers/larajobs-desktop/main/public/images/screenshots/electron-notifications-1.png)

Working:
![Electron notifications 2](https://raw.githubusercontent.com/LukeTowers/larajobs-desktop/main/public/images/screenshots/electron-notifications-2.png)

## Contributing

Contributions are welcome! Please ensure your pull requests adhere to the following Laravel coding guidelines: [https://spatie.be/guidelines/laravel-php](https://spatie.be/guidelines/laravel-php)

## License

This project is licensed under the MIT license - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- [Laravel](https://laravel.com/)
- [NativePHP](https://nativephp.com/)
