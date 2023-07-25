<p align="center"><a href="https://larajobs.com" target="_blank"><img src="https://github.com/LukeTowers/larajobs-desktop/assets/7253840/24e5d3c2-74e9-4305-9503-43518aa7223c" width="400" alt="LaraJobs Logo"></a></p>

# LaraJobs Desktop

An open source NativePHP menu bar application for MacOS, providing instant notifications when new jobs are posted on LaraJobs.

## Description

LaraJobs Desktop is a convenient way to stay updated with the latest job postings from LaraJobs. The application sits in your menu bar, providing non-intrusive notifications and a quick overview of new job opportunities, ensuring you never miss out on your dream job.

Features:
- Get notified about new job postings
- View list of most recent job postings
- Quick links to submit postings or search for Laravel Consultants
- Global hotkey to open the app (default: `CmdOrCtrl+Shift+J`)
- Send batched notifications, just one, or an explicit "No new jobs" depending on the number of new jobs identified.
- *More features coming soon*

  
<img width="352" alt="Screenshot 2023-07-24 at 10 49 13 PM" src="https://github.com/LukeTowers/larajobs-desktop/assets/7253840/0201e452-cb6f-4682-9890-6fa2aaf33b63">
<img width="364" alt="Screenshot 2023-07-24 at 10 50 37 PM" src="https://github.com/LukeTowers/larajobs-desktop/assets/7253840/ef85c41b-a17b-4cc5-a3d0-d2461d985d13">
<img width="356" alt="Screenshot 2023-07-25 at 12 16 25 AM" src="https://github.com/LukeTowers/larajobs-desktop/assets/7253840/095493b6-f904-4597-a238-d57cbeb39d40">

<br>

<img width="411" alt="Screenshot 2023-07-23 at 11 41 18 PM" src="https://github.com/LukeTowers/larajobs-desktop/assets/7253840/46fd2c27-240f-424f-9c8b-afcb9f12685a">
<img width="243" alt="Screenshot 2023-07-25 at 12 18 06 AM" src="https://github.com/LukeTowers/larajobs-desktop/assets/7253840/4b4cdf50-914f-442c-9294-dd9273ae864e">

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
- Show timezone difference to current location.

## License

This project is licensed under the MIT license - see the [LICENSE](LICENSE) file for details.

## Acknowledgments

- [Laravel](https://laravel.com/)
- [NativePHP](https://nativephp.com/)
