# Differ

### Hexlet tests and linter status:
[![Actions Status](https://github.com/brahmanchik/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/brahmanchik/php-project-48/actions)

[![show-directory](https://github.com/brahmanchik/php-project-48/actions/workflows/ci-checks.yml/badge.svg)](https://github.com/brahmanchik/php-project-48/actions/workflows/ci-checks.yml)

[![Maintainability](https://api.codeclimate.com/v1/badges/193d24e5902652b42601/maintainability)](https://codeclimate.com/github/brahmanchik/php-project-48/maintainability)

[![Test Coverage](https://api.codeclimate.com/v1/badges/193d24e5902652b42601/test_coverage)](https://codeclimate.com/github/brahmanchik/php-project-48/test_coverage)

## Description

**Differ** a program that determines the difference between two data structures. The input files can be JSON, YAML or YML.
You can also see the comparison result in various output formats, such as stylish, plain, json.
The default output format is stylish. If the files do not exist, the utility will notify you about it.

## Prerequisites
- Linux, MacOS, WSL
- PHP >=8.3
- Composer
- Make
- Git

## Libraries
- php-cli-tools
- docopt
- functional-php
- yaml

## Install

Downloading the utility and installing dependencies:
```bash
git clone https://github.com/brahmanchik/php-project-48
cd php-project-48
make install
```

Give the binary file execution rights:
```bash
sudo chmod +x bin/gendiff
```

## Run

To use the utility, run the binary file and specify the output format (stylish by default). Also pass the paths to the two files you need:
```bash
bin/gendiff --format=stylish file1.json file2.json
```

You can also choose the second output format plain:
```bash
bin/gendiff --format=plain file1.json file2.json
```
Instead of the flag --format, you can use the short version -f.

## Demonstration of comparison with yaml and json files

[![asciicast](https://asciinema.org/a/HgLB9G9g9BydEq6BaKHbefJIS.svg)](https://asciinema.org/a/HgLB9G9g9BydEq6BaKHbefJIS)
