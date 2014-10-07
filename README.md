# Readme - Terrific Micro Twig

This extension ...

brings the Twig Templating Engine into Terrific Micro

## Table of contents

* [Installation](#installation)
* [Usage](#usage)
* [Configuration](#configuration)
* [Additional add-ons](#additional-add-ons)
* [Contributing](#contributing)
* [Credits & License](#credits)

## Installation

You need:

* [Terrific Micro](http://namics.github.io/terrific-micro/) v1.0.0 or newer
* The files in your project extensions folder ;-)

        cd project/extensions
        git clone https://github.com/namics/terrific-micro-twig.git

## Usage

Include the twig main file into your project (file: `project/index.project.php`)

    require_once(dirname(__FILE__) . '/extensions/terrific-micro-twig/twig.inc.php');

## Configuration

There's nothing to configure. Terrific Micro will now throw your templates into the Twig rendering engine. 
Any Twig errors will be reported on the view.

But maybe you want to configure Terrific Micro to handle View-Files with the Extension `.twig`. 
Do this in `config.json`:

    "micro" -> "view_file_extension" : "html.twig"

## Additional add-ons

You can add custom functions, filters etc. by defining the following function:

    $twigAdditionalFunctions = function($twig) {
        // do your stuff with the Twig environment
    };

You can add additional include paths by setting the following array:

    $twigAdditionalPaths = array('path/to/custom/includes');

Define these lines BEFORE the require_once call.

## Contributing

* For Bugs & Features please use [github](https://github.com/namics/terrific-micro-twig/issues)
* Feel free to fork and send PRs. That's the best way to discuss your ideas.

## Credits

* The Twig Integration was created by [Christian Stuff](https://github.com/Regaddi)
* [Twig Template Engine 1.16.0](http://twig.sensiolabs.org/)

## License

Released under the [MIT license](LICENSE)
