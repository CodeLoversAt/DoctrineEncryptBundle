DoctrineEncryptBundle
=====================

Symfony 2 Bundle for storing encrypted data in a Symfony 2 project, using doctrine ORM or ODM. Based on [vmelnik/doctrine-encrypt-bundle](https://github.com/vmelnik-ukraine/DoctrineEncryptBundle).

## So what's different?
This bundle does not work with listening on doctrine events, but rather it offers a custom type for ORM and MongoDB, called `cl_encrypted`. Simply use this type for any property you want to encrypt.

## CURRENT STATUS

** EXPERIMENTAL!! **
