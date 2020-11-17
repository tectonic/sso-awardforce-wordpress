# Award Force - WordPress Single Sign-On (SSO)

For Award Force clients with a website built with WordPress, this WordPress plugin allows your registered users to automatically log in to Award Force with their WordPress user account. An Award Force user account is automatically created for them.

License: GPLv2 or late

## Installation

- Download the [latest release](https://github.com/tectonic/sso-awardforce/releases) of the WordPress plugin from this repository.
- Log in to your WordPress site's admin area and install the plugin `Plugins > Add new > Upload plugin`
- Activate it!

## Usage

- Configure the plugin by adding an `API Key` and your `Award Force URL` under the `Award Force` menu entry in the admin area.
- Add a link in your theme to the following URL: `/awardforce/sso`. Make sure this link is only visible to authenticated users, e.g.:

```
<?php

    if (is_user_logged_in()) {
        echo '<a href="/awardforce/sso">Award Force</a>';
    }

?>
```

- When users click this link the plugin will redirect them to your Award Force account and log them in.
