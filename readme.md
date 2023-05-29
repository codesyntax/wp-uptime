# WP Uptime

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


## Frequently Asked Questions

* Can I edit the endpoint and the OK response?

    Yes, from the administration panel you can configure the response from a string to a full JSON.

    For example:
    ```
    Path: /server-status/
    Response: {"status":"ok"}
    ```
