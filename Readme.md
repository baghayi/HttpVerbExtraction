Http Verb Extraction
=================


Introduction
---
`In a nutshell`, what this module does, is extracting each http verbs (as I call them), such as `create` (for posting on collection), `delete`, `fetchAll`, `deleteList`, ... to their own classes.

Well, It's been awhile I've been hacking around apigility and recently I chose to use it on a project we've started. The thing I don't like about it and which this module is kind of trying to address it is that in Resource classes we have lots of methods, each belongs to a http method (http verb) for either a collection or entity. Methods like `create`, `delete`, `fetchAll`, ... .

What it seems to me is like a controller with lots of actions in it. Which is in contrary to what I believe in, that is one action per controller. The issue as you might have already gussed by now arises here. That I'm not definitely going to invoke more than one action at a time. But the objects those methods depend on has to be passed to the respective class so that it can get to work whenever it has to.

To be clear, the issue I am facing is that, I have to pass lots of objects to the class so that some of them may be called by some of the methods in it. Which as it sounds it is violating Single Responsibility principle as well. That the respective class has may jobs to do.

To be fair, I need to mention that I've seen some people pass the class a mapper object which is one object only. But to me, it feels like delegating the problem to someone else, another object, and does not seem like getting rid of the problem at all.

By creating this module, I'am aiming for solving this issue.

Unfortunately I'm not completly familiar with apigility's internals so that I could not come up with a better solution. I mean there are some stuff that I do not like about this module and could be solved but it would need to change apigility as well which is not what I want for now. They may be solved in a better ways with apigility's current status, but I am not familiar with.

I will mention those issues but for now it's enought talking (writing). Lets see what we've got here.


Installation
---
First you need to either download this module manually, using git or by composer.
It is recommended to use composer, but the choice is yours.

If your are using composer, it will download the module to vendor/ directory by default.
If you are downloading manually, or cloning it using git, then you need to place it under vendor/ directory as composer does.

Then you need to add `HttpVerbExtraction` to your `config/application.config.php` file under 'modules' key.

+ For installing using composer you need to run this command in your project's root directory: 
    > `composer require "baghayi/http-verb-extraction:dev-master"`

+ If you want to directly clone it using git then you need to run this command under vendor/ (or wherever your modules will be loaded from) directory:
    > `git clone https://github.com/baghayi/HttpVerbExtraction`

+ You can also download module in a zip file by clicking on 'Download ZIP' button or use this URL, then move it to vendor/ directory then unzip it:
    > `https://github.com/baghayi/HttpVerbExtraction/archive/master.zip`

Now you are ready to go.

Usage
---
In order to use this module, you need to take these steps:

* Replace `ZF\Rest\AbstractResourceListener` with `HttpVerbExtraction\Rest\AbstractResourceListener` which is provided by this module, in your Resource classes.

For instance: if your API module name is DemoApi then its resource class location should be `DemoApi\V1\Rest\Demo\DemoResource.php` for rest resources. This class in apigility extends `ZF\Rest\AbstractResourceListener` by default. You need to change it to `HttpVerbExtraction\Rest\AbstractResourceListener`.

* Any methods in Resource classes are useless and you can remove them all as they won't be used by this module.

* For each http verbs such as `create`, `fetch`, ... you need to create a dedicated class which implements `HttpVerbExtraction\DispatchableInterface.php` interface.

* Then you need to define the previously created class as a service in the main service manager.

* After creating a service for each http verb (`create`, `delete`, ...) you need to associate them together. To do so you need to create an array in the config file of your module as following:

```
    'http-verb-extraction' => array(
        'Name of virtual controller (checkout zfcampus/zf-rest module out)' => array(
            'create'      => 'A service name',
            'delete'      => 'A service name',
            'deleteList'  => 'A service name',
            'fetch'       => 'A service name',
            'fetchAll'    => 'A service name',
            'patch'       => 'A service name',
            'patchList'   => 'A service name',
            'replaceList' => 'A service name',
            'update'      => 'A service name',
        ),
        // Repeat for each controller
    ),

```

As you can see, in the module config file, you need to create an array with key of `http-verb-extraction` which contains another array.

The nested array's key has to be the Resources controller name, which could be found in the api module's config file of your resources.

In our example, our DemoApi's controller name should be something like this: `DemoApi\\V1\\Rest\\Demo\\Controller` for rest resources.

As you can see the nested array consists of elements such as `create`, `delete`, `deleteList`, ... for each http verb, and their values have to be the name of a service that was previously created.

You can also remove verbs that you do not use or need.


Traits
---

In this module, there are about 5 traits at your disposal. Which could be used in the classes that are created for http verbs. 

* `HttpVerbExtraction\Traits\Data` for getting data sent by user to your api.
* `HttpVerbExtraction\Traits\Identifier` for getting id of an entity.
* `HttpVerbExtraction\Traits\Identity` for getting identity object.
* `HttpVerbExtraction\Traits\InputFilter` for getting inputFilter.
* `HttpVerbExtraction\Traits\QueryParams` for getting query params specified in the URL by user.

All these traits have only one method in them, to do the one task that they are supposed to do.

But you do not necessarily need to use these traits. You can get the values provided by these traists, directly in your verbs classes.

Verb classes that implements `HttpVerbExtraction\DispatchableInterface.php` interface, will get ResourceEvent as argument in its dispatch method. All of the values provided by traits could be retrieved directly by the event passed in your class.

If you are not sure how to get the specified values as traits does, you can look up traits source code as they are pretty straightforward to understand.

Not to mention that, methods defined in the traits require event object to be passed to them so that they can do what they are supposed to do.

Services
---
* `HttpVerbExtraction\Service\ControllerName` for getting controller name of your resource that you are in.

* `HttpVerbExtraction\Service\CollectionClass` for getting collection class name of the resource you are in.

* `HttpVerbExtraction\Service\EntityClass` for getting entity class name of the resource you are in.
* `HttpVerbExtraction\Service\VerbServiceName` used for getting service names of verbs defined in config file.


Initializer
---
There is only one initializer for now and that is used in the Abstract class which resource classes extends, to provide `HttpVerbExtraction\Rest\DispatchVerb` object in it so that it can attach events such as `create`, `fetch`, ... to its `dispatch` method.

* `HttpVerbExtraction/Initializer/DispatchVerbAwareInterface.php`



Issues
---
1- One thing that I think needs to be taken care of is ResourceClass and its factory class themselves.
As they are not being delt with by developers any more, I think they could be moved or removed to be hidden from developers (Apigility users). They do not need to be presented to the developers.

They might have been a better way of solving this issue, but unfortunately I'm not aware of, at the moment.

2- http-verb-extraction array key that I have introduced could be merged with zf-rest key in the config file, but I did not want to introduce anything new in it by myself (as outsider, not member of apigility main developers). Even though it does the job, but could have a proper home.


Thank you :)
---