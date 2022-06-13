# Award Force - WordPress Single Sign-On (SSO)
- Contributors: acarpio89, nicocucuzza
- Tags: Award Force, entries, awards, recognition, submission, competition
- Tested up to: 6.0
- Requires PHP: 8.0
- Stable tag: trunk
- License: GPLv2 or late

## Description
For Award Force clients with a website built with WordPress, this WordPress plugin allows your registered users to automatically log in to Award Force with their WordPress user account. An Award Force user account is automatically created for them.

License: GPLv2 or late

## Installation

- Download the [latest release](https://github.com/tectonic/sso-awardforce/releases) of the WordPress plugin from this repository.
- Log in to your WordPress site's admin area and install the plugin `Plugins > Add new > Upload plugin`
- Activate it!

## Usage

- Log in to your WordPress site’s admin area and install the plugin `Plugins > Add new`
- Activate it.
- Configure the plugin by adding an `API Key` and your `Award Force URL` under the `Award Force` menu entry in the admin area. You can get your API key from your Award Force account at `Settings > Developers > API Key`
- Add a link in a WordPress post or page to the following URL: `/awardforce/sso`. 
- When users click this link the plugin will redirect them to your Award Force account and log them in.
