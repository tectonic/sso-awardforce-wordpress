# Award Force - WordPress SSO

This plugin has been developed for Award Force clients that wish to provide single sign-on capabilities to their WordPress site.

## Installation

- Download the [latest release](https://github.com/tectonic/sso-awardforce/releases) from this repository.
- Log into your WordPress site's admin area and install the plugin `Plugins > Add new > Upload plugin`
- Activate it!

## Usage

- Configure the plugin by adding an `API Key` and your `Installation URL` under the `Award Force` menu entry in the admin area.
- Add a link in your theme to the following URL: `/awardforce/sso`. This link should only be visible to authenticated users.
- When users click this link the plugin will redirect them to your Award Force installation.