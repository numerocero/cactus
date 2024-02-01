## About this project

This is a challenge project for CactusTech showing:
- A backend in Laravel
- A frontend in LiveWire
- Use of Docker as a develop environment.


## Set up

In order to run this demo project you should follow these steps

- Ensure that Windows Subsystem for Linux 2 (WSL2) is installed and enabled. WSL allows you to run Linux binary executables natively on Windows 10. Information on how to install and enable WSL2 can be found within Microsoft's [developer environment documentation](https://docs.microsoft.com/en-us/windows/wsl/install-win10)
- Install [Docker Desktop](https://www.docker.com/products/docker-desktop) 
- Clone the project Git [repository](https://github.com/numerocero/cactus.git)
- Go to the root folder of the project and start the WSL `C:\cactus> wsl`
- Rebuild Docker containers `user@machine:/mnt/c/cactus$ ./vendor/bin/sail build --no-cache`
- Start the Docker containers `user@machine:/mnt/c/cactus$ ./vendor/bin/sail up -d`
- Install the project dependencies `user@machine:/mnt/c/cactus$ ./vendor/bin/sail composer install`
- Seed the database with the admin user `user@machine:/mnt/c/cactus$ ./vendor/bin/sail artisan db:seed`
- Optionally you can configure a shell alias to the sail sacript. To do so execute this command in the root folder of the project in WSL `alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'`

Now you can test the project in http://localhost


## Api tests

There is a Postman collection that tests all the project API endpoints. You should import the file `cactus.postman_collection.json` located in the root folder of the project in your Postman.

This collection has response examples for all the API crud endpoints.
