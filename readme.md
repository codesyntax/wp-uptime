# WP uptime

Non-cached monitorization path for Wordpress.

## How to use

Just install the plugin and activate it.

## Test it

Open the /wp-json/wp-uptime/ok path of your website and check that it returns OK.

```
https://your-site.com/wp-json/wp-uptime/ok
```

## How it works

When you activate the plugin, the WP Uptime page will be created with the slug 'ok'.

This page has a custom template that will render OK if the connection to the database is correct.

If you deactivate the plugin, the /ok page will be removed.
