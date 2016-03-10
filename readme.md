# Fluentkit Application Framework

[![Join the chat at https://gitter.im/fluentkit/fluentkit](https://badges.gitter.im/fluentkit/fluentkit.svg)](https://gitter.im/fluentkit/fluentkit?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

[![Build Status](https://travis-ci.org/fluentkit/fluentkit.svg?branch=master)](https://travis-ci.org/fluentkit/fluentkit)
[![Total Downloads](https://poser.pugx.org/fluentkit/fluentkit/d/total.svg)](https://packagist.org/packages/fluentkit/fluentkit)
[![Latest Stable Version](https://poser.pugx.org/fluentkit/fluentkit/v/stable)](https://packagist.org/packages/fluentkit/fluentkit)
[![Latest Unstable Version](https://poser.pugx.org/fluentkit/fluentkit/v/unstable.svg)](https://packagist.org/packages/fluentkit/fluentkit)
[![License](https://poser.pugx.org/fluentkit/fluentkit/license.svg)](https://packagist.org/packages/fluentkit/fluentkit)

Fluentkit is an application framework built onto of the popular [Laravel Framework](http://laravel.com).

At its core it contains user management, cms like abilities, and a minimal admin UI ready for usage.

Fluentkit Framework is the core building block of a large ecosystem of Fluentkit solutions.

Right now in alpha these solutions are yet to be created, once we have a solid foundation we will be planning at the very least:

 - Billing, Invoicing, Sales management
 - Newsletter functionality
 - Enhanced CMS / Blog abilities
 - Support and CRM solutions

*Aren't there already SASS services for all of this?

Yes there are, and there are some great services out there, we aim to offer tailored solutions wrapped up into a neat little package which can hosted by us, or on your own.

*Is this going to be a WordPress alternative?

Possibly? This isn't our intention, WordPress is a great application and alot of extendability offered by our framework is inspired by it.

However WordPress is a great Blogging tool and has years of development decisions and some great developers working on it every day.

Its role is to provide a blogging platform for people.

This tightly coupled nature isn't what we intend for Fluentkit.

And unfortunatley WordPress is bound by its PHP version support to PHP from the early 00's

Fluentkit makes no apologies for its requirements of PHP 5.5 and above.

It uses the latest technologies to provide you with the best of best both in terms of functionality and development freedom.

From Dependency Injection to advanced caching mechanisms (many provided by Laravel) Fluentkit has you covered.

Everything minus user, setting management and basic page creation is opt-in with opt-out default in Fluentkit.

Need invoicing but not an online shop? That's fine.

Need a support solution AND a newsletter system, that's great Fluentkit can (will) offer this all from one uncluttered interface which only has what you need, and nothing you dont.

We still have a lot of work to do, but were on track and will soon have an alpha ready.

In the meantime please take a look, we encourage tinkering but bear in mind we are pre alpha so dont rely on existing classes, events etc and these can change.

## Testing / Development

Great, if your here it sounds like you want to help us out. Thanks!

The framework is self contained and is setup to run inside a vagrant vm during development.

To ensure elements are tested in a consistent environment please run all tests through this vagrant box.

The first thing to do is clone your fork, then run:

```vagrant up``` then ```vagrant ssh``` then ```cd fluentkit``` then ```php artisan migrate --seed```

This will build the box, log you in and migrate the database including seeding it with sample data.

Make your additions, create tests and then run: ```phpunit```.

If all is well you will need to run ```php-cs-fixer fix``` to ensure your code complies with the coding standards,
don't worry we have a fixer file which will do all the hard work for you.

This step shouldn't be omitted as the framework will automatically check the standards using a service called Nitpick CI on any pull request,
and requests not passing the test wont be considered until they do pass.

When your done, commit your changes and open a pull request, assuming the request passes the tests and is accepted we will merge it.

## Official Documentation

Documentation for the framework can be found on the [Fluentkit website](http://fluentkit.io/docs) (not ready yet, we need to reach alpha first).

## Contributing

Thank you for considering contributing to the Fluentkit Application framework!

Please open an issue discussing the proposal first (we dont want to waste your time) and when your proposal is accepted go right ahead, fork the repo and send in a pull request.

## Security Vulnerabilities

If you discover a security vulnerability within Fluentkit, please send an e-mail to Lee Mason at contact@fluentkit.io. All security vulnerabilities will be promptly addressed.

## License

The Fluentkit Application framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
