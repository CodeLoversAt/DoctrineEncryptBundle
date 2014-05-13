DoctrineEncryptBundle
=====================

Symfony 2 Bundle for storing encrypted data in a Symfony 2 project, using doctrine ORM or ODM. Based on [vmelnik/doctrine-encrypt-bundle](https://github.com/vmelnik-ukraine/DoctrineEncryptBundle).

## So what's different?
This bundle basically works the same way. It simply doesn't check **all** entities, that are being persisted or loaded, but only the ones marked with the class annotation `@EncryptedEntity`.

## CURRENT STATUS

** EXPERIMENTAL!! **
