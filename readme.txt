=== WP Uptime ===
Contributors: codesyntax, bipoza
Donate link: https://codesyntax.com/
Tags: monitorization, status, wp-json, restapi
Requires at least: 4.7
Tested up to: 6.2
Stable tag: 3.0.0
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Editable non-cached monitorization path for Wordpress.

== Description ==

## WP Uptime
Editable non-cached monitorization path for Wordpress.

## How to use

Just install the plugin and activate it.

## Default settings

By default, the API is at this address and if mysql is running it will return OK.

```
https://your-site.com/ok/
```

## Edition panel

![wp-uptime-admin-panel](https://user-images.githubusercontent.com/26112509/226600732-58bdf02b-cb17-4acb-87f9-f997b38ff923.png)


== Frequently Asked Questions ==

= Can I edit the endpoint and the OK response? =

Yes, from the administration panel you can configure the response from a string to a full JSON.

For example:
```
Path: /server-status/
Response: {"status":"ok"}
```

== Screenshots ==

1. Edition panel

== Changelog ==

= 3.0.0 =
* Improvement in the route and disable caching.

= 2.0.5 =
* Plugin display name changed from WPUptime to WP Uptime.

= 2.0.4 =
* First stable version.

= 2.0.3 =
* Removes the plugin options from the database after uninstalling the plugin.

= 2.0.0 =
* Add edition from the administration panel.
* Add editable fields.

== Upgrade Notice ==

= 2.0.4 =
First stable version. It is recommended to install this version.

= 2.0.3 =
This version fixes a security related bug.  Upgrade immediately.
