# Docsgo

### Installation
Docsgo is very easy to install and deploy in a Docker container.

By default, the Docker will expose port 80, so change this within the Dockerfile if necessary. 

```sh
$ docker-compose up
```

Verify the deployment by navigating to your server address in your preferred browser.
[http://localhost/](http://localhost)

Default username: user@gmail.com and password docsgo@123

Default password can be changed in .env file PASS_CODE