HeroJsonValidationBunde
=======================

This was made in one evening to make it easier for me to share this code between projects I work on.

Pretty much all the actual work is done by justinrainbow's json-schema_ library.

.. _json-schema: https://github.com/justinrainbow/json-schema

I put it up publicly because I couldn't be bothered to pay for packagist or set up a custom repository every time.
If you want to use it go ahead, just don't rely on it to work perfectly in every situation.

Installation
************

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

.. code-block:: bash

    $ composer require hrombach/json-validation-bundle

Applications that don't use Symfony Flex
----------------------------------------

Step 1: Download the Bundle
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

.. code-block:: terminal

    $ composer require hrombach/json-validation-bundle

This command requires you to have Composer installed globally, as explained
in the `installation chapter`_ of the Composer documentation.

Step 2: Enable the Bundle
~~~~~~~~~~~~~~~~~~~~~~~~~

Then, enable the bundle by adding it to the list of registered bundles
in the ``app/AppKernel.php`` file of your project:

.. code-block:: php

    <?php
    // app/AppKernel.php

    // ...
    class AppKernel extends Kernel
    {
        public function registerBundles()
        {
            $bundles = array(
                // ...

                new Hero\Bundle\JsonValidation\HeroJsonValidationBundle(),
            );

            // ...
        }

        // ...
    }

.. _`installation chapter`: https://getcomposer.org/doc/00-intro.md

Basic usage
***********

Inject the validator into your controller

.. code-block:: php

    /**
     * ExampleController constructor.
     *
     * @param Validator    $validator
     */
    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

To be the most lazy (like me) just use

.. code-block:: php

    try {
        $this->validator->validateRequest($request);
    catch (JsonValidationFailedException $e) {
        foreach ($e->getValidationErrors() as $error) {
            // whatever you do with those ¯\_(ツ)_/¯
        }
    }

In the beginning of your controller action.
The validator will try to find a file named after the ``_route`` of your request, appended with ``.schema.json`` in ``%kernel.project_dir%/public/schema``.
