<p align="center"><a href="https://larajobs.com" target="_blank"><img src="https://github.com/LukeTowers/larajobs-desktop/assets/7253840/24e5d3c2-74e9-4305-9503-43518aa7223c" width="400" alt="LaraJobs Logo"></a></p>

# LaraJobs Desktop

An open source NativePHP menu bar application for MacOS, providing instant notifications when new jobs are posted on LaraJobs.

## Description

LaraJobs Desktop is a convenient way to stay updated with the latest job postings from LaraJobs. The application sits in your menu bar, providing non-intrusive notifications and a quick overview of new job opportunities, ensuring you never miss out on your dream job.

Features:
- Get notified about new job postings
- View list of most recent job postings
- Quick links to submit postings or search for Laravel Consultants
- *More features coming soon*

<img width="411" alt="Screenshot 2023-07-23 at 11 41 18 PM" src="https://github.com/LukeTowers/larajobs-desktop/assets/7253840/46fd2c27-240f-424f-9c8b-afcb9f12685a">

<img width="242" alt="Screenshot 2023-07-23 at 11 40 25 PM" src="https://github.com/LukeTowers/larajobs-desktop/assets/7253840/0421b540-6997-417c-b3b6-61fcd5a2ffcb">

## Prerequisites

The LaraJobs Desktop application currently only supports MacOS.

## Installation

1. Download the [LaraJobs Desktop application](link)
2. Run the application.
3. Follow the on-screen instructions to configure the application settings to fit your preferences.

![Settings Screenshot](https://raw.githubusercontent.com/UserScape/larajobs-desktop/main/public/images/screenshots/settings-screenshot.png)

## Usage

Use LaraJobs Desktop to stay informed about new jobs. Check out these screenshots for various use cases:

- [Notification Screenshot](https://raw.githubusercontent.com/UserScape/larajobs-desktop/main/public/images/screenshots/notification-screenshot.png)

*More use cases and screenshots coming soon*

## Potential Issues

### Notifications aren't displaying:

Please make sure that notifications are enabled for the app. When running `php artisan native:serve` notifications are sent from the "Electron" app.

Broken:
![Screenshot 2023-07-23 at 11 33 09 PM](https://github.com/LukeTowers/larajobs-desktop/assets/7253840/05433b27-d9e9-408f-b882-55b690b93738)

Working:
![Screenshot 2023-07-23 at 11 35 08 PM](https://github.com/LukeTowers/larajobs-desktop/assets/7253840/487f170c-c4ba-498b-81c5-452ee2e9f0b7)

## Contributing

Contributions are welcome! Please ensure your pull requests adhere to the following Laravel coding guidelines: [https://spatie.be/guidelines/laravel-php](https://spatie.be/guidelines/laravel-php)

## Roadmap

We have big plans for LaraJobs Desktop! Here are some features we're considering for future releases:

- Watch jobs functionality to keep track of jobs.
- Click on a notification to see quick job details, with an option to go to the site.
- Save job application details for easy reviewing later and to reduce effort required when applying to new jobs.
- Track application status and write notes.
- Backup / restore of settings.
- Make key information front and center (BLUF) to avoid even clicking on unimportant jobs.
- Show timezone difference to current location.
- Display salary information.
- Send batched notifications instead of one at a time.
- Show "X new jobs since you last checked".

## License

This project is licensed under the MIT license - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- [Laravel](https://laravel.com/)
- [NativePHP](https://nativephp.com/)
